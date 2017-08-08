<?php

/**
 * Created by PhpStorm.
 * User: andre
 * Date: 13.07.17
 * Time: 17:50
 */
class fcPayOneUserView extends fcPayOneUserView_parent {

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
     * Method will be called when amazon user has been recognized as existing as a standard user
     * with a set password. In this case the user needs to login to make sure that this account
     * won't be compromised
     *
     * @param void
     * @return void
     */
    public function fcpoAmazonMergeUserMandatory() {
        $this->_blLoginMandatory = true;
        // go ahead with rendering
        $this->render();
    }

    /**
     * Template getter for decision to show a login form or not
     *
     * @param void
     * @return bool
     */
    public function fcpoGetLoginMandatoryForAmazonPay() {
        return $this->_blLoginMandatory;
    }

}