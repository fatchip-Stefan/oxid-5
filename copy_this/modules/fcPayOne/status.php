<?php
/** 
 * PAYONE OXID Connector is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PAYONE OXID Connector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PAYONE OXID Connector.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.payone.de
 * @copyright (C) Payone GmbH
 * @version   OXID eShop CE
 */
 
set_time_limit(0);
ini_set ('memory_limit', '1024M');
ini_set ('log_errors', 1);
ini_set ('error_log', '../../log/fcpoErrors.log');

if(file_exists(dirname(__FILE__)."/config.ipwhitelist.php")) {
    include_once dirname(__FILE__)."/config.ipwhitelist.php";
} else {
    echo 'Config file missing!';
    exit;
}

$sClientIp = null;
if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $aIps = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $sTmpClientIp = trim($aIps[0]);
    $blAllowed = in_array($sTmpClientIp, $aWhitelistForwarded);
    if ($blAllowed) {
        $sClientIp = $sTmpClientIp;
    }
    $sClientIp = trim($aIps[0]);
}

$sRemoteIp = isset($sClientIp) ? $sClientIp : $_SERVER['REMOTE_ADDR'];

if(array_search($sRemoteIp, $aWhitelist) === false) {
    $blMatch = false;
    foreach ($aWhitelist as $sIP) {
        if(stripos($sIP, '*') !== false) {
            $sDelimiter = '/';
            
            $sRegex = preg_quote($sIP, $sDelimiter);
            $sRegex = str_replace('\*', '\d{1,3}', $sRegex);
            $sRegex = $sDelimiter.'^'.$sRegex.'$'.$sDelimiter;

            preg_match($sRegex, $sRemoteIp, $aMatches);
            if(is_array($aMatches) && count($aMatches) == 1 && $aMatches[0] == $sRemoteIp) {
                $blMatch = true;
            }
        }
    }

    if($blMatch === false) {
        echo 'Access denied';
        exit;
    }
}

if(file_exists(dirname(__FILE__)."/../../bootstrap.php")) {
    require_once dirname(__FILE__) . "/../../bootstrap.php";
} else {
	if (!function_exists('getShopBasePath')) {
		/**
		 * Returns shop base path.
		 *
		 * @return string
		 */
		function getShopBasePath()
		{
			return dirname(__FILE__).'/../../';
		}
	}

	set_include_path(get_include_path() . PATH_SEPARATOR . getShopBasePath());

	/**
	 * Returns true.
	 *
	 * @return bool
	 */
	if ( !function_exists( 'isAdmin' )) {
		function isAdmin()
		{
			return true;
		}
	}

	error_reporting( E_ALL ^ E_NOTICE );

	// custom functions file
	require getShopBasePath() . 'modules/functions.php';

	// Generic utility method file
	require_once getShopBasePath() . 'core/oxfunctions.php';

}

class fcPayOneTransactionStatusHandler extends oxBase {

    protected $_aShopList = null;


    protected $_oFcpoHelper = null;

    protected $_oFcViewConf = null;

    public function __construct() {
        parent::__construct();
        $this->_oFcpoHelper = oxNew('fcpohelper');
        $this->_oFcViewConf = $this->_oFcpoHelper->getFactoryObject('oxViewConfig');
    }

    /**
     * Check and return post parameter
     * 
     * @param string $sKey
     * @return string
     */
    public function fcGetPostParam( $sKey ) {
        $sReturn    = '';
        $mValue     = filter_input( INPUT_GET, $sKey );
        if (!$mValue) {
            $mValue = filter_input( INPUT_POST, $sKey );
        }
    
        if ( $mValue ) {
            if( $this->getConfig()->isUtf() ) {
                $mValue = utf8_encode( $mValue );
            }
            $db = oxDb::getInstance();
            $sReturn = $db->escapeString($mValue);
        }
        
        return $sReturn;
    }
    
    protected function _getShopList() {
        if($this->_aShopList === null) {
            $aShops = array();
            
            $sQuery = "SELECT oxid FROM oxshops";
            $oResult = oxDb::getDb()->Execute($sQuery);
            if ($oResult != false && $oResult->recordCount() > 0) {
                while (!$oResult->EOF) {
                    $aShops[] = $oResult->fields[0];
                    $oResult->moveNext();
                }
            }
            $this->_aShopList = $aShops;
        }
        return $this->_aShopList;
    }
    
    protected function _getConfigParams($sParam) {
        $aParams = array();
        foreach ($this->_getShopList() as $sShop) {
            $mValue = $this->getConfig()->getShopConfVar($sParam, $sShop);
            if($mValue) {
                $aParams[$sShop] = $mValue;
            }
        }
        return $aParams;
    }
    
    protected function _isKeyValid() {
        $sKey = $this->fcGetPostParam('key');
        if($sKey) {
            $aKeys = array_merge(
                array_values($this->_getConfigParams('sFCPOPortalKey')),
                array_values($this->_getConfigParams('sFCPOSecinvoicePortalKey')) // OXID-228: Check also SecInvoice key
            );

            foreach ($aKeys as $i => $sConfigKey) {
                if(md5($sConfigKey) == $sKey) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns order number of an available txid
     *
     * @return int
     */
    protected function _getOrderNr() {
        $oDb = oxDb::getDb();
        $sTxid = $this->fcGetPostParam('txid');

        $sQuery = "
            SELECT 
                oxordernr 
            FROM 
                oxorder 
            WHERE 
                fcpotxid = ".$oDb->quote($sTxid)."
            LIMIT 1                
        ";
        $iOrderNr = (int) $oDb->GetOne($sQuery);
        
        return $iOrderNr;
    }
    
    public function log() {
        $iOrderNr = $this->_getOrderNr();
        $oxDb = oxDb::getDb();

        $sQuery = "
            INSERT INTO fcpotransactionstatus (
                FCPO_ORDERNR,   FCPO_KEY,           FCPO_TXACTION,          FCPO_PORTALID,          FCPO_AID,           FCPO_CLEARINGTYPE,          FCPO_TXTIME,                        FCPO_CURRENCY,          FCPO_USERID,            FCPO_ACCESSNAME,            FCPO_ACCESSCODE,            FCPO_PARAM,         FCPO_MODE,          FCPO_PRICE,         FCPO_TXID,          FCPO_REFERENCE,         FCPO_SEQUENCENUMBER,            FCPO_COMPANY,           FCPO_FIRSTNAME,         FCPO_LASTNAME,          FCPO_STREET,            FCPO_ZIP,           FCPO_CITY,          FCPO_EMAIL,         FCPO_COUNTRY,           FCPO_SHIPPING_COMPANY,          FCPO_SHIPPING_FIRSTNAME,            FCPO_SHIPPING_LASTNAME,         FCPO_SHIPPING_STREET,           FCPO_SHIPPING_ZIP,          FCPO_SHIPPING_CITY,         FCPO_SHIPPING_COUNTRY,          FCPO_BANKCOUNTRY,           FCPO_BANKACCOUNT,           FCPO_BANKCODE,          FCPO_BANKACCOUNTHOLDER,         FCPO_CARDEXPIREDATE,            FCPO_CARDTYPE,          FCPO_CARDPAN,           FCPO_CUSTOMERID,            FCPO_BALANCE,           FCPO_RECEIVABLE,        FCPO_CLEARING_BANKACCOUNTHOLDER,        FCPO_CLEARING_BANKACCOUNT,          FCPO_CLEARING_BANKCODE,         FCPO_CLEARING_BANKNAME,         FCPO_CLEARING_BANKBIC,          FCPO_CLEARING_BANKIBAN,         FCPO_CLEARING_LEGALNOTE,        FCPO_CLEARING_DUEDATE,          FCPO_CLEARING_REFERENCE,        FCPO_CLEARING_INSTRUCTIONNOTE
            ) VALUES (
                '{$iOrderNr}',  '".$this->fcGetPostParam('key')."',   '".$this->fcGetPostParam('txaction')."',  '".$this->fcGetPostParam('portalid')."',  '".$this->fcGetPostParam('aid')."',   '".$this->fcGetPostParam('clearingtype')."',  FROM_UNIXTIME('".$this->fcGetPostParam('txtime')."'), '".$this->fcGetPostParam('currency')."',  '".$this->fcGetPostParam('userid')."',    '".$this->fcGetPostParam('accessname')."',    '".$this->fcGetPostParam('accesscode')."',    '".$this->fcGetPostParam('param')."', '".$this->fcGetPostParam('mode')."',  '".$this->fcGetPostParam('price')."', '".$this->fcGetPostParam('txid')."',  '".$this->fcGetPostParam('reference')."', '".$this->fcGetPostParam('sequencenumber')."',    '".$this->fcGetPostParam('company')."',   '".$this->fcGetPostParam('firstname')."', '".$this->fcGetPostParam('lastname')."',  '".$this->fcGetPostParam('street')."',    '".$this->fcGetPostParam('zip')."',   '".$this->fcGetPostParam('city')."',  '".$this->fcGetPostParam('email')."', '".$this->fcGetPostParam('country')."',   '".$this->fcGetPostParam('shipping_company')."',  '".$this->fcGetPostParam('shipping_firstname')."',    '".$this->fcGetPostParam('shipping_lastname')."', '".$this->fcGetPostParam('shipping_street')."',   '".$this->fcGetPostParam('shipping_zip')."',  '".$this->fcGetPostParam('shipping_city')."', '".$this->fcGetPostParam('shipping_country')."',  '".$this->fcGetPostParam('bankcountry')."',   '".$this->fcGetPostParam('bankaccount')."',   '".$this->fcGetPostParam('bankcode')."',  '".$this->fcGetPostParam('bankaccountholder')."', '".$this->fcGetPostParam('cardexpiredate')."',    '".$this->fcGetPostParam('cardtype')."',  '".$this->fcGetPostParam('cardpan')."',   '".$this->fcGetPostParam('customerid')."',    '".$this->fcGetPostParam('balance')."',   '".$this->fcGetPostParam('receivable')."','".$this->fcGetPostParam('clearing_bankaccountholder')."','".$this->fcGetPostParam('clearing_bankaccount')."',  '".$this->fcGetPostParam('clearing_bankcode')."', '".$this->fcGetPostParam('clearing_bankname')."', '".$this->fcGetPostParam('clearing_bankbic')."',  '".$this->fcGetPostParam('clearing_bankiban')."', '".$this->fcGetPostParam('clearing_legalnote')."','".$this->fcGetPostParam('clearing_duedate')."',  '".$this->fcGetPostParam('clearing_reference')."','".$this->fcGetPostParam('clearing_instructionnote')."'
            )";
        $oRs = $oxDb->Execute($sQuery);
        if($oRs === false) {
            error_log($oxDb->errorMsg()."\n".$sQuery);
        }
    }
    
    protected function _addParam($sKey, $mValue) {
        $sParams = '';
        if(is_array($mValue)) {
            foreach ($mValue as $sKey2 => $mValue2) {
                $sParams .= $this->_addParam($sKey.'['.$sKey2.']', $mValue2);
            }
        } else {
            $sParams .= "&".$sKey."=".urlencode($mValue);
        }
        return $sParams;
    }

    protected function _handleForwarding() {

        $sParams = '';
        foreach($_POST as $sKey => $mValue) {
            $sParams .= $this->_addParam($sKey, $mValue);
        }

        $sParams = substr($sParams,1);
        $sBaseUrl = (empty($this->getConfig()->getShopUrl())) ? $this->getConfig()->getSslShopUrl() : $this->getConfig()->getShopUrl();
        $sForwarderUrl = $sBaseUrl . 'modules/fcPayOne/statusforward.php';

        $oCurl = curl_init($sForwarderUrl);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sParams);

        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_TIMEOUT_MS, 100);

        $oResult = curl_exec($oCurl);

        curl_close($oCurl);

    }
    
    protected function _handleMapping($oOrder) {
        $sPayoneStatus = $this->fcGetPostParam('txaction');
        $sPaymentId = oxDb::getDb()->quote($oOrder->oxorder__oxpaymenttype->value);
        
        $sQuery = "SELECT fcpo_folder FROM fcpostatusmapping WHERE fcpo_payonestatus = '{$sPayoneStatus}' AND fcpo_paymentid = {$sPaymentId} ORDER BY oxid ASC LIMIT 1";
        $sFolder = oxDb::getDb()->GetOne($sQuery);
        if(!empty($sFolder)) {
            $sQuery = "UPDATE oxorder SET oxfolder = '{$sFolder}' WHERE oxid = '{$oOrder->getId()}'";
            oxDb::getDb()->Execute($sQuery);
        }
    }
    
    public function handle() {
        if($this->_isKeyValid()) {
            $this->log();
            $sTxid = $this->fcGetPostParam('txid');
            $sOrderId = oxDb::getDb()->GetOne("SELECT oxid FROM oxorder WHERE fcpotxid = '".$sTxid."'");
            if($sOrderId) {
                $oOrder = oxNew('oxorder');
                $oOrder->load($sOrderId);
                if($this->_allowDebit($sTxid)) {
                    $query = "UPDATE oxorder SET oxpaid = NOW() WHERE oxid = '{$sOrderId}'";
                    oxDb::getDb()->Execute($query);
                }
                if($this->fcGetPostParam('txaction') == 'paid') {
                    $query = "UPDATE oxorder SET oxfolder = 'ORDERFOLDER_NEW', oxtransstatus = 'OK' WHERE oxid = '{$sOrderId}' AND oxtransstatus = 'INCOMPLETE' AND oxfolder = 'ORDERFOLDER_PROBLEMS'";
                    oxDb::getDb()->Execute($query);
                }

                $this->_handleMapping($oOrder);
                $this->_handleNotification($oOrder);
                $this->_handleOrderPostTrigger($oOrder);
            }
            $this->_handleForwarding();

            echo 'TSOK';
        } else {
            echo 'Key wrong or missing!';
        }
    }

    protected function _handleOrderPostTrigger($oOrder) {
        $sPaymentId = $oOrder->oxorder__oxpaymenttype->value;
        $sTxAction = $this->fcGetPostParam('txaction');
        $sTxStatus = $this->fcGetPostParam('transaction_status');

        $blIsAmazonRecover = (
            $sPaymentId == 'fcpoamazonpay' &&
            $sTxAction == 'appointed' &&
            $sTxStatus == 'completed'
        );

        $blIsAmazonOrderFailed = (
            $sPaymentId == 'fcpoamazonpay' &&
            $sTxAction == 'failed'
        );

        if ($blIsAmazonRecover) {
            $this->_fcpoRecoverOrder($oOrder);
        }

        if ($blIsAmazonOrderFailed) {
            $this->_fcpoCancelOrder($oOrder);
        }
    }

    protected function _fcpoRecoverOrder($oOrder) {
        $oOrder->oxorder__oxfolder = new oxField('ORDERFOLDER_NEW');
        $oOrder->oxorder__oxtransstatus = new oxField('OK');
        $oOrder->save();
    }

    protected function _fcpoCancelOrder($oOrder) {
        $oOrder->cancelOrder();
    }

    protected function _handleNotification($oOrder) {
        $sPaymentId = $oOrder->oxorder__oxpaymenttype->value;

        $sNotificationType = $this->_fcpoDetermineNotificationType($sPaymentId);

        switch ($sNotificationType) {
            case 'email_amazonpay_failed':
                $this->_fcpoSendAmazonDeclinedProblemMail($oOrder);
                break;
        }
    }

    protected function _fcpoSendAmazonDeclinedProblemMail($oOrder) {
        $oEmail = oxNew('oxemail');
        $sPrefixedCustomerEmail = $oOrder->oxorder__oxbillemail->value;
        $sCustomerEmail = $this->_oFcViewConf->fcpoAmazonEmailDecode($sPrefixedCustomerEmail);

        $sSubject = $this->_fcpoGetAmazonDeclinedSubject($oOrder);
        $sBody = $this->_fcpoGetAmazonDeclinedBody($oOrder);
        $oEmail->sendEmail($sCustomerEmail, $sSubject, $sBody);
    }


    protected function _fcpoGetAmazonDeclinedSubject($oOrder) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $sSubjectRaw = $oLang->translateString('FCPO_MAIL_AMZ_DECLINED_SUBJECT');
        $sOrderNr = $oOrder->oxorder__oxordernr->value;
        $sSubject = sprintf($sSubjectRaw, $sOrderNr);

        return $sSubject;
    }

    protected function _fcpoGetAmazonDeclinedBody($oOrder) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $sBodyRaw = $oLang->translateString('FCPO_MAIL_AMZ_DECLINED_BODY');
        if (!$sBodyRaw) {
            $sBodyRaw = $this->fcpoGetFallbackText('FCPO_MAIL_AMZ_DECLINED_BODY');
        }
        $oShop = oxNew('oxShop');
        $oShop->load($oOrder->oxorder__oxshopid->value);
        $sShopname = $oShop->oxshops__oxname->value;

        $sBody = sprintf($sBodyRaw, $sShopname, $sShopname);

        return $sBody;
    }

    protected function fcpoGetFallbackText($sIdent) {
        $aTexts = array(
            'FCPO_MAIL_AMZ_DECLINED_BODY'=>"Valued customer,\n\nThank you very much for your order at %s.\nAmazon Pay was not able to process your payment.\nPlease go to https://pay.amazon.com/uk/ and update the payment information for your order. Afterwards we will automatically request payment again from Amazon Pay and you will receive a confirmation email.\n\nKind regards,\n\n%s",
        );

        $sReturn = (isset($aTexts[$sIdent])) ? $aTexts[$sIdent] : 'Text is missing';

        return $sReturn;
    }

    protected function _fcpoSendGenericProblemMail($oOrder) {
        $oEmail = oxNew('oxemail');
        $sCustomerEmail = $oOrder->oxorder__oxbillemail->value;
        $sCustomerEmail = $this->_oFcViewConf->fcpoAmazonEmailDecode($sCustomerEmail);
        $sSubject = $this->_fcpoGetGenericProblemMailSubject($oOrder);
        $sBody = $this->_fcpoGetGenericProblemMailBody($oOrder);
        $oEmail->sendEmail($sCustomerEmail, $sSubject, $sBody);
    }

    protected function _fcpoGetGenericProblemMailSubject($oOrder) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $sSubjectRaw = $oLang->translateString('FCPO_MAIL_SUBJECT_FAILED');
        $sOrderNr = $oOrder->oxorder__oxordernr->value;
        $sSubject = sprintf($sSubjectRaw, $sOrderNr);

        return $sSubject;
    }

    protected function _fcpoGetGenericProblemMailBody($oOrder) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $sBodyRaw = $oLang->translateString('FCPO_MAIL_BODY_FAILED');
        $blIsMale = $this->_fcIsMale($oOrder);

        // salutation
        $sSalutation = $oLang->translateString('FCPO_MAIL_SALUTATION_INFORMAL');
        if ($blIsMale === true) {
            $sSalutation = $oLang->translateString('FCPO_MAIL_SALUTATION_MALE');
        } else if ($blIsMale === false) {
            $sSalutation = $oLang->translateString('FCPO_MAIL_SALUTATION_FEMALE');
        }

        $sCustomerName = $oOrder->oxorder__oxbilllname->value;
        if ($blIsMale === null) {
            $sCustomerName = $oOrder->oxorder__oxbillfname->value." ".$oOrder->oxorder__oxbilllname->value;
        }

        $sOrderNr = $oOrder->oxorder__oxordernr->value;
        $oShop = oxNew('oxShop');
        $oShop->load($oOrder->oxorder__oxshopid->value);
        $sResponseEmail = $oShop->oxshops__oxorderemail->value;

        $sBody = sprintf($sBodyRaw, $sSalutation, $sCustomerName, $sOrderNr, $sResponseEmail);

        return $sBody;
    }

    protected function _fcIsMale($oOrder) {
        $sBillSalutation = $oOrder->oxorder__oxbillsal->value;
        $blReturn = null;
        if ($sBillSalutation == 'MR') {
            $blReturn = true;
        } elseif ($sBillSalutation == 'MRS') {
            $blReturn = false;
        }

        return $blReturn;
    }

    protected function _fcpoDetermineNotificationType($sPaymentId) {
        $sTxAction = $this->fcGetPostParam('txaction');
        $sTxStatus = $this->fcGetPostParam('transaction_status');
        $sFailedCause = $this->fcGetPostParam('failedcause');
        $sReasonCode = $this->fcGetPostParam('reasoncode');


        switch($sPaymentId) {
            case 'fcpoamazonpay':
                $blSendAmazonProblemMail = (
                    $sTxAction == 'appointed' &&
                    $sTxStatus == 'pending' &&
                    $sReasonCode == '981'
                );

                if ($blSendAmazonProblemMail) {
                    $sReturn = 'email_amazonpay_failed';
                }
                break;
            default:
                $sReturn = 'none';
        }

        return $sReturn;
    }

    /**
     * Checks based on the transaction status received by PAYONE whether
     * the debit request is available for this order at the moment.
     * 
     * @param void
     * @return bool
     */
    protected function _allowDebit($sTxid) {
        $sAuthMode = oxDb::getDb()->GetOne("SELECT fcpoauthmode FROM oxorder WHERE fcpotxid = '".$sTxid."'");
        if ($sAuthMode == 'authorization') {
            $blReturn = true;
        } else {
            $iCount = oxDb::getDb()->GetOne("SELECT COUNT(*) FROM fcpotransactionstatus WHERE fcpo_txid = '{$sTxid}' AND fcpo_txaction = 'capture'");
            if ($iCount == 0) {
                $blReturn = false;
            }
        }
        return $blReturn;
    }
    

}

$oScript = oxNew('fcPayOneTransactionStatusHandler');
$oScript->handle();
