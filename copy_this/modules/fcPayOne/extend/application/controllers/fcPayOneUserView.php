<?php

/**
 * Created by PhpStorm.
 * User: andre
 * Date: 13.07.17
 * Time: 17:50
 */
class fcPayOneUserView extends fcPayOneUserView_parent {

    /**
     * Helper object for dealing with different shop versions
     * @var object
     */
    protected $_oFcpoHelper = null;

    /**
     * Helper object for dealing with different shop versions
     * @var object
     */
    protected $_oFcpoDb = null;


    /**
     * init object construction
     *
     * @return null
     */
    public function __construct() {
        parent::__construct();
        $this->_oFcpoHelper = oxNew('fcpohelper');
        $this->_oFcpoDb = oxDb::getDb();
        $this->_blIsPayolutionInstallmentAjax = false;
    }

    /**
     * Method will be called when returning from amazonlogin
     *
     * @param void
     * @return void
     */
    public function fcpoAmazonLoginReturn() {
        $oConfig = $this->getConfig();
        $oSession = $this->getSession();

        // delete possible old data
        $oSession->deleteVariable('sAmazonLoginAccessToken');
        $oSession->deleteVariable('sAmazonLoginScope');

        $sAmazonLoginAccessToken = $oConfig->getRequestParameter('access_token');
        $sAmazonLoginScope = $oConfig->getRequestParameter('scope');

        $blNeededDataAvailable = ($sAmazonLoginAccessToken && $sAmazonLoginScope);
        $sPaymentId = 'fcpoamazonpay';
        if ($blNeededDataAvailable) {
            $oSession->setVariable('sAmazonLoginAccessToken', $sAmazonLoginAccessToken);
            $oSession->setVariable('sAmazonLoginScope', $sAmazonLoginScope);
            $oSession->setVariable('paymentid', $sPaymentId);
            $oSession->setVariable('_selected_paymentid', $sPaymentId);
            $oBasket = $oSession->getBasket();
            $oBasket->setPayment('fcpoamazonpay');
        } else {
            // @todo: Redirect to basket with message, currently redirect without comment
            $oUtils = oxRegistry::getUtils();
            $sShopUrl = $oConfig->getShopUrl();
            $oUtils->redirect($sShopUrl."index.php?cl=basket");
        }

        // go ahead with rendering
        $this->render();
    }

    /**
     * Returns user error message if there is some. false if none
     *
     * @param void
     * @return mixed string|bool
     */
    public function fcpoGetUserErrorMessage() {
        $mReturn = false;
        $sMessage = $this->_oFcpoHelper->fcpoGetRequestParameter('fcpoerror');
        if ($sMessage) {
            $sMessage = urldecode($sMessage);
            $mReturn = $sMessage;
        }

        return $mReturn;
    }

}