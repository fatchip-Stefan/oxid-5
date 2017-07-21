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

        if ($blNeededDataAvailable) {
            $oSession->setVariable('sAmazonLoginAccessToken', $sAmazonLoginAccessToken);
            $oSession->setVariable('sAmazonLoginScope', $sAmazonLoginScope);
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

}