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
/*
 * load OXID Framework
 */

if (!function_exists('getShopBasePath')) {
    function getShopBasePath()
    {
        return dirname(__FILE__).'/../../../../';
    }
}

require_once getShopBasePath() . "bootstrap.php";

// receive params
$sPaymentId = filter_input( INPUT_POST, 'paymentid' );
$sAction = filter_input( INPUT_POST, 'action' );
$sParamsJson = filter_input( INPUT_POST, 'params' );

/**
 * Class for receiving ajax calls and delivering needed data
 *
 * @author andre
 */
class fcpayone_ajax extends oxBase {

    /**
     * Helper object for dealing with different shop versions
     * @var object
     */
    protected $_oFcpoHelper = null;
    
    /**
     * init object construction
     * 
     * @return null
     */
    public function __construct() {
        parent::__construct();
        $this->_oFcpoHelper = oxNew('fcpohelper');
    }

    /**
     * Triggers a call on payoneapi for handling ajax calls for referencedetails
     *
     * @param $sParamsJson
     * @return void
     */
    public function fcpoGetAmazonReferenceId($sParamsJson) {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $aParams = json_decode($sParamsJson,true);
        $sAmazonReferenceId = $aParams['fcpoAmazonReferenceId'];
        $oSession->deleteVariable('fcpoAmazonReferenceId');
        $oSession->setVariable('fcpoAmazonReferenceId', $sAmazonReferenceId);
        $sAmazonLoginAccessToken = $oSession->getVariable('sAmazonLoginAccessToken');

        // do the call cascade
        $this->_fcpoHandleGetOrderReferenceDetails($sAmazonReferenceId, $sAmazonLoginAccessToken);
        $this->_fcpoHandleSetOrderReferenceDetails($sAmazonReferenceId, $sAmazonLoginAccessToken);
    }

    /**
     * Public handler for confirmorderreference call
     *
     * @param $sParamsJson
     * @return void
     */
    public function fcpoConfirmAmazonPayOrder($sParamsJson)
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $aParams = json_decode($sParamsJson, true);
        $sAmazonReferenceId = $aParams['fcpoAmazonReferenceId'];
        $sToken = $aParams['fcpoAmazonStoken'];
        $sDeliveryMD5 = $aParams['fcpoAmazonDeliveryMD5'];

        $oSession->deleteVariable('fcpoAmazonReferenceId');
        $oSession->setVariable('fcpoAmazonReferenceId', $sAmazonReferenceId);

        $this->_fcpoHandleConfirmAmazonPayOrder($sAmazonReferenceId, $sToken, $sDeliveryMD5);
    }

    /**
     * Calls confirmorderreference call. Sends a 404 on invalid state
     *
     * @param $sAmazonReferenceId
     * @param $sToken
     */
    protected function _fcpoHandleConfirmAmazonPayOrder($sAmazonReferenceId, $sToken, $sDeliveryMD5)
    {
        $oRequest = $this->_oFcpoHelper->getFactoryObject('fcporequest');

        $aResponse =
            $oRequest->sendRequestGetConfirmAmazonPayOrder($sAmazonReferenceId, $sToken, $sDeliveryMD5);

        $blSend400 = (
            isset($aResponse['status']) &&
            $aResponse['status'] != 'OK'
        );

        if ($blSend400) return header("HTTP/1.0 404 Not Found");

        header("HTTP/1.0 200 Ok");
    }


    /**
     * Triggers call setorderreferencedetails
     *
     * @param $sAmazonReferenceId
     * @param $sAmazonLoginAccessToken
     * @return void
     */
    protected function _fcpoHandleSetOrderReferenceDetails($sAmazonReferenceId, $sAmazonLoginAccessToken) {
        $oUtils = $this->_oFcpoHelper->fcpoGetUtils();
        $oRequest = $this->_oFcpoHelper->getFactoryObject('fcporequest');
        $sWorkorderId = $this->_oFcpoHelper->fcpoGetSessionVariable('fcpoAmazonWorkorderId');

        $aResponse = $oRequest->sendRequestSetAmazonOrderReferenceDetails($sAmazonReferenceId, $sAmazonLoginAccessToken, $sWorkorderId);

        if ($aResponse['status'] == 'OK') {
            $oUser = $this->_oFcpoHelper->getFactoryObject('oxuser');
            $oUser->fcpoSetAmazonOrderReferenceDetailsResponse($aResponse);
        } else {
            $oConfig = $this->_oFcpoHelper->fcpoGetConfig();
            $sShopUrl = $oConfig->getShopUrl();
            $oUtils->redirect($sShopUrl."index.php?cl=basket");
        }
    }

    /**
     * Triggers call getorderreferencedetails
     *
     * @param $sAmazonReferenceId
     * @param $sAmazonLoginAccessToken
     * @return void
     */
    protected function _fcpoHandleGetOrderReferenceDetails($sAmazonReferenceId, $sAmazonLoginAccessToken) {
        $oUtils = $this->_oFcpoHelper->fcpoGetUtils();
        $oRequest = $this->_oFcpoHelper->getFactoryObject('fcporequest');

        $aResponse = $oRequest->sendRequestGetAmazonOrderReferenceDetails($sAmazonReferenceId, $sAmazonLoginAccessToken);

        if ($aResponse['status'] == 'OK') {
            $this->_oFcpoHelper->fcpoDeleteSessionVariable('fcpoAmazonWorkorderId');
            $this->_oFcpoHelper->fcpoSetSessionVariable('fcpoAmazonWorkorderId', $aResponse['workorderid']);
            $this->_oFcpoHelper->fcpoDeleteSessionVariable('paymentid');
            $this->_oFcpoHelper->fcpoSetSessionVariable('paymentid', 'fcpoamazonpay');
        } else {
            $oConfig = $this->_oFcpoHelper->fcpoGetConfig();
            $sShopUrl = $oConfig->getShopUrl();
            $oUtils->redirect($sShopUrl."index.php?cl=basket");
        }
    }

    /**
     * Performs a precheck for payolution installment
     * 
     * @param type $sPaymentId
     * @return bool
     */
    public function fcpoTriggerPrecheck($sPaymentId, $sParamsJson) {
        $oPaymentController = $this->_oFcpoHelper->getFactoryObject('payment');
        $oPaymentController->setPayolutionAjaxParams(json_decode($sParamsJson, true));
        $mPreCheckResult =  $oPaymentController->fcpoPayolutionPreCheck($sPaymentId);
        $sReturn = ($mPreCheckResult === true) ? 'SUCCESS': $mPreCheckResult;
        
        return $sReturn;
    }
    
    /**
     * Performs a precheck for payolution installment
     * 
     * @param type $sPaymentId
     * @return mixed
     */
    public function fcpoTriggerInstallmentCalculation($sPaymentId) {
        $oPaymentController = $this->_oFcpoHelper->getFactoryObject('payment');

        $oPaymentController->fcpoPerformInstallmentCalculation($sPaymentId);
        $mResult = $oPaymentController->fcpoGetInstallments();
        
        $mReturn = (is_array($mResult) && count($mResult) > 0) ? $mResult : false;
        
        return $mReturn;
    }
    
    /**
     * Parse result of calculation to html for returning html code
     * 
     * @param array $aCalculation
     * @return string
     */
    public function fcpoParseCalculation2Html($aCalculation) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $oConfig = $this->_oFcpoHelper->fcpoGetConfig();

        $sTranslateInstallmentSelection = $oLang->translateString('FCPO_PAYOLUTION_INSTALLMENT_SELECTION');
        $sTranslateSelectInstallment = $oLang->translateString('FCPO_PAYOLUTION_SELECT_INSTALLMENT');

        $sHtml = '
            <div class="content">
                <p id="payolution_installment_calculation_headline" class="payolution_installment_box_headline">2. '.$sTranslateInstallmentSelection.'</p>
                <p id="payolution_installment_calculation_headline" class="payolution_installment_box_subtitle">'.$sTranslateSelectInstallment.'</p>
        ';
        $sHtml .= '<div class="payolution_installment_offers">';
        $sHtml .= '<input id="payolution_no_installments" type="hidden" value="'.count($aCalculation).'">';
        $sHtml .= '<fieldset>';
        foreach ($aCalculation as $sKey=>$aCurrentInstallment) {
            $sHtml .= $this->_fcpoGetInsterestHiddenFields($sKey, $aCurrentInstallment);
            $sHtml .= $this->_fcpoGetInsterestRadio($sKey);
            $sHtml .= $this->_fcpoGetInsterestLabel($sKey, $aCurrentInstallment);
            $sHtml .= '<br>';
        }
        $sHtml .= '</fieldset>';
        $sHtml .= '</div></div>';
        $sHtml .= '<div class="payolution_installment_details">';
        foreach ($aCalculation as $sKey=>$aCurrentInstallment) {
            $sHtml .= '<div id="payolution_rates_details_'.$sKey.'" class="payolution_rates_invisible">';
            foreach ($aCurrentInstallment['Months'] as $sMonth=>$aRatesDetails) {
                $sHtml .= $this->_fcpoGetInsterestMonthDetail($sMonth, $aRatesDetails).'<br>';
            }
            $sDownloadUrl = $oConfig->getShopUrl().'/modules/fcPayOne/lib/fcpopopup_content.php?login=1&loadurl='.$aCurrentInstallment['StandardCreditInformationUrl'];
            
            $sHtml .= '<div class="payolution_draft_download"><a href="'.$sDownloadUrl.'"'.$this->_fcpoGetLightView().'>'.$oLang->translateString('FCPO_PAYOLUTION_INSTALLMENT_DOWNLOAD_DRAFT').'</a></div>';
            $sHtml .= '</div>';
        }
        $sHtml .= '</div>';
        
        return $sHtml;
    }
    
    /**
     * Returns lightview part for download
     * 
     * @param void
     * @return string
     */
    protected function _fcpoGetLightView() {
        $sContent = 'class="lightview" data-lightview-type="iframe" data-lightview-options="';
        $sContent .= "width: 800, height: 600, viewport: 'scale',background: { color: '#fff', opacity: 1 },skin: 'light'";
        $sContent .= '"';
        
        return $sContent;
    }
    
    
    /**
     * Formats error message to be displayed in a error box
     * 
     * @param string $sMessage
     * @return string
     */
    public function fcpoReturnErrorMessage($sMessage) {
        $oConfig = $this->_oFcpoHelper->fcpoGetConfig();
        if (!$oConfig->isUtf()) {
            $sMessage = utf8_encode($sMessage);
        }
        
        $sReturn  = '<p class="payolution_message_error">';
        $sReturn .= $sMessage;
        $sReturn .= '</p>';
        
        return $sReturn;
    }
    
    
    /**
     * Set hidden fields for beeing able to set needed values
     * 
     * @param string $sKey
     * @param array $aCurrentInstallment
     * @return string
     */
    protected function _fcpoGetInsterestHiddenFields($sKey, $aCurrentInstallment) {
        $sHtml  = '<input type="hidden" id="payolution_installment_value_'.$sKey.'" value="'.str_replace('.', ',', $aCurrentInstallment['Amount']).'">';
        $sHtml .= '<input type="hidden" id="payolution_installment_duration_'.$sKey.'" value="'.$aCurrentInstallment['Duration'].'">';
        $sHtml .= '<input type="hidden" id="payolution_installment_eff_interest_rate_'.$sKey.'" value="'.str_replace('.', ',', $aCurrentInstallment['EffectiveInterestRate']).'">';
        $sHtml .= '<input type="hidden" id="payolution_installment_interest_rate_'.$sKey.'" value="'.str_replace('.', ',', $aCurrentInstallment['InterestRate']).'">';
        $sHtml .= '<input type="hidden" id="payolution_installment_total_amount_'.$sKey.'" value="'.str_replace('.', ',', $aCurrentInstallment['TotalAmount']).'">';

        return $sHtml;
    }
    
    /**
     * Returns a caption for a certain month
     * 
     * @param string $sMonth
     * @param array $aRatesDetails
     * @return string
     */
    protected function _fcpoGetInsterestMonthDetail($sMonth, $aRatesDetails) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $sRateCaption = $oLang->translateString('FCPO_PAYOLUTION_INSTALLMENT_RATE');
        $sDueCaption = $oLang->translateString('FCPO_PAYOLUTION_INSTALLMENT_DUE_AT');
        $sDue = date('d.m.Y', strtotime($aRatesDetails['Due']));
        $sRate = str_replace('.', ',', $aRatesDetails['Amount']);
        
        $sMonthDetailsCaption = $sMonth.'. '.$sRateCaption.': '. $sRate.' '.$aRatesDetails['Currency'].' ('.$sDueCaption.' '.$sDue.')';
        
        return $sMonthDetailsCaption;
    }
    
    /**
     * Returns a html radio button for current installment offer
     * 
     * @param string $sKey
     * @return string
     */
    protected function _fcpoGetInsterestRadio($sKey) {
        $sHtml = '<input type="radio" id="payolution_installment_offer_'.$sKey.'" name="payolution_installment_selection" value="'.$sKey.'">';
        
        return $sHtml;
    }
    
    /**
     * Returns a html label for current installment offer radiobutton
     * 
     * @param string $sKey
     * @param array $aCurrentInstallment
     * @return string
     */
    protected function _fcpoGetInsterestLabel($sKey, $aCurrentInstallment) {
        $sInterestCaption = $this->_fcpoGetInsterestCaption($aCurrentInstallment);
        $sHtml = '<label for="payolution_installment_offer_'.$sKey.'">'.$sInterestCaption.'</label>';

        return $sHtml;
    }

    /**
     * Returns translated caption for current installment offer
     * 
     * @param array $aCurrentInstallment
     * @return string
     */
    protected function _fcpoGetInsterestCaption($aCurrentInstallment) {
        $oLang = $this->_oFcpoHelper->fcpoGetLang();
        $sPerMonth = $oLang->translateString('FCPO_PAYOLUTION_INSTALLMENT_PER_MONTH');
        $sRates = $oLang->translateString('FCPO_PAYOLUTION_INSTALLMENT_RATES');
        $sMonthlyAmount = str_replace('.', ',', $aCurrentInstallment['Amount']);
        $sDuration = $aCurrentInstallment['Duration'];
        $sCurrency = $aCurrentInstallment['Currency'];
        
        // put all together to final caption
        $sCaption = $sMonthlyAmount." ".$sCurrency." ".$sPerMonth." - ".$sDuration." ".$sRates;
        
        return $sCaption;
    }

    /**
     * Returns JS snippet via ajax if user confirms GDPR
     *
     * @param void
     * @return string
     */
    public function fcpoGetPaysafeFraudProtectionSnippet()
    {
        $oViewConf = oxNew('oxViewConfig');
        $sPaySafeSessionId = $oViewConf->fcpoGetPaySafeSessionId();
        $sSrc = "https://h.online-metrix.net/fp/tags?org_id=363t8kgq&session_id=".$sPaySafeSessionId;
        $sStyleNoScript = "width: 100px; height: 100px; border: 0; position: absolute; top: -5000px;";

        $sSnippet = '
            <script type="text/javascript" src="'.$sSrc.'"></script>
            <noscript>
                <iframe style="'.$sStyleNoScript.'" src="'.$sSrc.'"></iframe>
            </noscript>
        ';

        return $sSnippet;
    }

    /**
     *
     *
     * @param $sPaymentId
     * @param $sAction
     * @param $sParamsJson
     * @return string
     */
    public function fcpoTriggerKlarnaAction($sPaymentId, $sAction, $sParamsJson)
    {
        if ($sAction === 'start_session') {
            return $this->fcpoTriggerKlarnaSessionStart($sPaymentId, $sParamsJson);
        }
    }
    /**
     * Trigger klarna session start
     *
     * @param $sPaymentId
     * @param $sParamsJson
     * @return string
     */
    public function fcpoTriggerKlarnaSessionStart($sPaymentId, $sParamsJson)
    {
        // Update birthday, telephone number and personalid if posted
        $this->_fcpoUpdateUser($sParamsJson);
        $oRequest = $this->_oFcpoHelper->getFactoryObject('fcporequest');
        $aResponse = $oRequest->sendRequestKlarnaStartSession($sPaymentId);
        $blIsValid = (
            isset($aResponse['status'], $aResponse['add_paydata[client_token]']) &&
            $aResponse['status'] === 'OK'
        );
        if (!$blIsValid) {
            $this->_oFcpoHelper->fcpoSetSessionVariable('payerror', -20);
            $this->_oFcpoHelper->fcpoSetSessionVariable(
                'payerrortext',
                $aResponse['errormessage']
            );
            return header("HTTP/1.0 503 Service not available");
        }
        $this->_fcpoSetKlarnaSessionParams($aResponse);
        return $this->_fcpoGetKlarnaWidgetJS($aResponse['add_paydata[client_token]'], $sParamsJson);
    }

    /**
     *
     *
     * @param $sParamsJson
     * @return string
     */
    public function _fcpoUpdateUser($sParamsJson)
    {
        $aParams = json_decode($sParamsJson, true);
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();
        /** @var oxUser $oUser value */
        if ($aParams['birthday'] !== 'undefined') {
            $oUser->oxuser__oxbirthdate = new oxField($aParams['birthday']);
        }
        if ($aParams['telephone'] !== 'undefined') {
            $oUser->oxuser__oxfon = new oxField($aParams['telephone']);
        }
        if ($aParams['personalid'] !== 'undefined') {
            $oUser->oxuser__fcpopersonalid = new oxField($aParams['personalid']);
        }
        $oUser->save();
    }

    /**
     * Set needed session params for later handling of Klarna payment
     *
     * @param $aResponse
     * @return void
     */
    protected function _fcpoSetKlarnaSessionParams($aResponse)
    {
        $this->_oFcpoHelper->fcpoDeleteSessionVariable('klarna_authorization_token');
        $this->_oFcpoHelper->fcpoSetSessionVariable(
            'klarna_authorization_token',
            $aResponse['add_paydata[client_token]']
        );
        $this->_oFcpoHelper->fcpoDeleteSessionVariable('fcpoWorkorderId');
        $this->_oFcpoHelper->fcpoSetSessionVariable(
            'fcpoWorkorderId',
            $aResponse['workorderid']
        );
    }

    /**
     * @param $sClientToken
     * @param $sParamsJson
     * @return string
     */
    protected function _fcpoGetKlarnaWidgetJS($sClientToken, $sParamsJson)
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();

        $aParams = json_decode($sParamsJson, true);
        $aCustomer = $this->_fcpoGetKlarnaCustomerParams();
        $aBilling = $this->_fcpoGetKlarnaBillingParams();

        // set params depending on private person / company
        if ($oUser->oxuser__oxcompany->value != '') {
            $aBilling['organization_name'] = $oUser->oxuser__oxcompany->value;
            $aCustomer['organization_registration_id'] = $oUser->oxuser__oxustid->value;
        }

        $aShipping = $this->_fcpoGetKlarnaShippingParams();
        $aPurchase = $this->_fcpoGetKlarnaPurchaseParams();
        $aOrderlines = $this->_fcpoGetKlarnaOrderlinesParams();
        $aOrder = $this->_fcpoGetKlarnaOrderParams();

        $aKlarnaWidgetSearch = array(
            '%%TOKEN%%',
            '%%PAYMENT_CONTAINER_ID%%',
            '%%PAYMENT_CATEGORY%%',
            '%%KLARNA_CUSTOMER%%',
            '%%KLARNA_BILLING%%',
            '%%KLARNA_SHIPPING%%',
            '%%KLARNA_PURCHASE%%',
            '%%KLARNA_ORDERLINES%%',
            '%%KLARNA_ORDER%%',
        );

        $aKlarnaWidgetReplace = array(
            $sClientToken,
            $aParams['payment_container_id'],
            $aParams['payment_category'],
            json_encode($aCustomer, JSON_UNESCAPED_UNICODE),
            json_encode($aBilling, JSON_UNESCAPED_UNICODE),
            json_encode($aShipping, JSON_UNESCAPED_UNICODE),
            json_encode($aPurchase, JSON_UNESCAPED_UNICODE),
            json_encode($aOrderlines, JSON_UNESCAPED_UNICODE),
            json_encode($aOrder, JSON_UNESCAPED_UNICODE),
        );

        $sKlarnaWidgetJS = file_get_contents($this->_fcpoGetKlarnaWidgetPath());
        $sKlarnaWidgetJS = str_replace($aKlarnaWidgetSearch, $aKlarnaWidgetReplace, $sKlarnaWidgetJS);

        return (string) $sKlarnaWidgetJS;
    }

    /**
     * Returns customer params for klarna widget
     *
     * @param void
     * @return array
     */
    protected function _fcpoGetKlarnaCustomerParams()
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();
        $sGender = ($oUser->oxuser__oxsal->value == 'MR') ? 'male' : 'female';

        return array(
            'date_of_birth' => ($oUser->oxuser__oxbirthdate->value === '0000-00-00') ? '' : $oUser->oxuser__oxbirthdate->value,
            'gender' => $sGender,
            'national_identification_number' => $oUser->oxuser__fcpopersonalid->value,
        );
    }

    /**
     * Returns title param for klarna widget
     *
     * @param void
     * @return string
     */
    protected function _fcpoGetKlarnaTitleParam()
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();
        $sGender = ($oUser->oxuser__oxsal->value == 'MR') ? 'male' : 'female';
        $sCountryIso2 = $oUser->fcpoGetUserCountryIso();
        switch ($sCountryIso2) {
            case 'AT':
            case 'DE':
                $sTitle = ($sGender === 'male') ? 'Herr' : 'Frau';
                break;
            case 'CH':
                $sTitle = ($sGender === 'male') ? 'Herr' : 'Frau';
                break;
            case 'GB':
            case 'US':
                $sTitle = ($sGender === 'male') ? 'Mr' : 'Ms';
                break;
            case 'DK':
            case 'FI':
            case 'SE':
            case 'NL':
            case 'NO':
                $sTitle = ($sGender === 'male') ? 'Dhr.' : 'Mevr.';
                break;
        }
        return $sTitle;
    }


    /**
     * Returns customer billing address params for klarna widget
     *
     * @param void
     * @return array
     */
    protected function _fcpoGetKlarnaBillingParams()
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();

        return array(
            'given_name' => $oUser->oxuser__oxfname->value,
            'family_name' => $oUser->oxuser__oxlname->value,
            'email' => $oUser->oxuser__oxusername->value,
            'title' => $this->_fcpoGetKlarnaTitleParam(),
            'street_address' => $oUser->oxuser__oxstreet->value . " " . $oUser->oxuser__oxstreetnr->value,
            'street_address2' => $oUser->oxuser__oxaddinfo->value,
            // 'street_name' => $oUser->oxuser__oxstreet->value,
            // 'streetNumber' => $oUser->oxuser__oxstreetnr->value,
            'postal_code' => $oUser->oxuser__oxzip->value,
            'city' => $oUser->oxuser__oxcity->value,
            'region' => $oUser->getStateTitle(),
            'phone' => $oUser->oxuser__oxfon->value,
            'country' => $oUser->fcpoGetUserCountryIso(),
            'organization_name' => $oUser->oxuser__oxcompany->value,
        );
    }

    /**
     * Returns customer billing address params for klarna widget
     *
     * @param void
     * @return array
     */
    protected function _fcpoGetKlarnaShippingParams()
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();
        $oShippingAddress = $this->_fcpoGetShippingAddress();
        $blHasShipping = (!$oShippingAddress) ? false : true;

        if ($blHasShipping) {
            return array(
                'given_name' => $oShippingAddress->oxaddress__oxfname->value,
                'family_name' => $oShippingAddress->oxaddress__oxlname->value,
                'email' => $oUser->oxuser__oxusername->value,
                'title' => $this->_fcpoGetKlarnaTitleParam(),
                'street_address' => $oShippingAddress->oxaddress__oxstreet->value . " " . $oShippingAddress->oxaddress__oxstreetnr->value,
                'street_address2' => $oShippingAddress->oxaddress__oxaddinfo->value,
                'postal_code' => $oShippingAddress->oxaddress__oxzip->value,
                'city' => $oShippingAddress->oxaddress__oxcity->value,
                'region' => "",
                'phone' => $oShippingAddress->oxaddress__oxfon->value,
                'country' => $oShippingAddress->fcpoGetUserCountryIso(),
                'organization_name' => $oShippingAddress->oxaddress__oxcompany->value
            );
        } else {
            return $this->_fcpoGetKlarnaBillingParams();
        }
    }

    /**
     * Return needed data for performing authorization
     *
     * @param void
     * @return array
     */
    protected function _fcpoGetKlarnaPurchaseParams()
    {
        $oConfig = $this->_oFcpoHelper->fcpoGetConfig();
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $oUser = $oBasket->getUser();
        $oCur = $oConfig->getActShopCurrencyObject();

        $aKlarnaData = array(
            'purchase_country' => $oUser->fcpoGetUserCountryIso(),
            'purchase_currency' => $oCur->name,
        );

        return $aKlarnaData;
    }

    /**
     * Returns and brings basket positions into appropriate form
     *
     * @param void
     * @return array
     */
    protected function _fcpoGetKlarnaOrderlinesParams()
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();

        $aOrderlines = array();
        foreach ($oBasket->getContents() as $oBasketItem) {
            $oArticle = $oBasketItem->getArticle();
            $aOrderline = array(
                'reference' => $oArticle->oxarticles__oxartnum->value,
                'name' =>  $oBasketItem->getTitle(),
                'quantity' => $oBasketItem->getAmount(),
                'unit_price' => $oBasketItem->getUnitPrice()->getBruttoPrice() *100,
                'tax_rate' => $oBasketItem->getVatPercent() * 100,
                'total_amount' => $oBasketItem->getPrice()->getBruttoPrice() * 100 * $oBasketItem->getAmount(),
                // 'product_url' => $oBasketItem->getLink(),
                // 'image_url' => $oBasketItem->getIconUrl(),
            );
            $aOrderlines[] = $aOrderline;
        }

        $sDeliveryCosts = $this->_fcpoFetchDeliveryCostsFromBasket($oBasket);

        $oDelivery = $oBasket->getCosts('oxdelivery');

        $sDeliveryCosts = (double) str_replace(',', '.', $sDeliveryCosts);
        if ($sDeliveryCosts > 0) {
            $aOrderlineShipping = array(
                'reference' => 'delivery',
                'name' =>  'Standard Versand',
                'quantity' => 1,
                'unit_price' => $sDeliveryCosts * 100,
                'tax_rate' => (string)$oDelivery->getVat() * 100,
                'total_amount' => $sDeliveryCosts * 100,
                // 'product_url' => $oBasketItem->getLink(),
                // 'image_url' => $oBasketItem->getIconUrl(),
            );
            $aOrderlines[] = $aOrderlineShipping;
        }

        return $aOrderlines;
    }

    /**
     * Returns and brings basket positions into appropriate form
     *
     * @param void
     * @return array
     */
    protected function _fcpoGetKlarnaOrderParams()
    {
        $oSession = $this->_oFcpoHelper->fcpoGetSession();
        $oBasket = $oSession->getBasket();
        $dAmount = $oBasket->getPrice()->getBruttoPrice();
        $dTaxAmount = $oBasket->getPrice()->getVat();

        return array(
            'order_amount' => $dAmount *100,
            'order_tax_amount' => $dTaxAmount
        );;
    }

    /**
     * Returns an object with the shipping address.
     *
     * @param void
     * @return mixed false|object
     */
    protected function _fcpoGetShippingAddress()
    {
        if (!($sAddressId = $this->_oFcpoHelper->fcpoGetRequestParameter('deladrid'))) {
            $sAddressId = $this->_oFcpoHelper->fcpoGetSessionVariable('deladrid');
        }

        if (!$sAddressId) {
            return false;
        }

        $oShippingAddress = oxNew('oxaddress');
        $oShippingAddress->load($sAddressId);

        return $oShippingAddress;
    }

    /**
     * Returns the path to a text file with js for the klarna widget.
     *
     * @return string
     */
    protected function _fcpoGetKlarnaWidgetPath()
    {
        $oViewConf = $this->_oFcpoHelper->getFactoryObject('oxviewconfig');
        return  $oViewConf->getModulePath('fcpayone') . '/out/snippets/fcpoKlarnaWidget.txt';
    }

    /**
     * Returns delivery costs of given basket object
     *
     * @param $oBasket
     * @return object $oDelivery
     */
    protected function _fcpoFetchDeliveryCostsFromBasket($oBasket)
    {
        $oDelivery = $oBasket->getCosts('oxdelivery');
        if ($oDelivery === null) return 0.0;

        return $oDelivery->getBruttoPrice();
    }

}


if ($sPaymentId) {
    $oPayoneAjax = new fcpayone_ajax();
    if ($sAction == 'precheck') {
        $sResult =  $oPayoneAjax->fcpoTriggerPrecheck($sPaymentId, $sParamsJson);
        if ($sResult == 'SUCCESS') {
            $sAction = 'calculation';
        }
        else {
            echo $oPayoneAjax->fcpoReturnErrorMessage($sResult);
        }
    }
    
    if ($sAction == 'calculation') {
        $mResult = $oPayoneAjax->fcpoTriggerInstallmentCalculation($sPaymentId);
        if (is_array($mResult) && count($mResult) > 0) {
            // we have got a calculation result. Parse it to needed html
            echo $oPayoneAjax->fcpoParseCalculation2Html($mResult);
        }
    }

    if ($sAction == 'get_amazon_reference_details' && $sPaymentId == 'fcpoamazonpay') {
        $oPayoneAjax->fcpoGetAmazonReferenceId($sParamsJson);
    }

    $blConfirmAmazonOrder = (
        $sAction == 'confirm_amazon_pay_order' &&
        $sPaymentId == 'fcpoamazonpay'
    );
    if ($blConfirmAmazonOrder) {
        $oPayoneAjax->fcpoConfirmAmazonPayOrder($sParamsJson);
    }

    if ($sAction == 'getpaysafefraudsnippet') {
        echo $oPayoneAjax->fcpoGetPaysafeFraudProtectionSnippet();
    }

    $aKlarnaPayments = array(
        'fcpoklarna_invoice',
        'fcpoklarna_installments',
        'fcpoklarna_directdebit',
    );

    if (in_array($sPaymentId, $aKlarnaPayments) && $sAction == 'start_session')
    {
        echo $oPayoneAjax->fcpoTriggerKlarnaAction($sPaymentId, $sAction, $sParamsJson);
    }
}