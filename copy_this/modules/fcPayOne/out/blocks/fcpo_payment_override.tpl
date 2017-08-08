[{if $oViewConf->fcpoAmazonLoginSessionActive()}]
    <style type="text/css">
        #walletWidgetDiv {
            min-width: 300px;
            width: 100%;
            max-width: 900px;
            min-height: 228px;
            height: 240px;
            max-height: 400px;
        }
    </style>

    <form action="[{$oViewConf->getSslSelfLink()}]" class="form-horizontal js-oxValidate payment" id="payment" name="order" method="post" novalidate="novalidate">
        <div class="hidden">
            [{$oViewConf->getHiddenSid()}]
            [{$oViewConf->getNavFormParams()}]
            <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
            <input type="hidden" name="fnc" value="validateamazonpayment">
            <input type="hidden" name="paymentid" value="fcpoamazonpay">
        </div>

        <div id="walletWidgetDiv"></div>

        <script>
            window.onAmazonLoginReady = function() {amazon.Login.setClientId('[{$oViewConf->fcpoGetAmazonPayClientId()}]'); };
            window.onAmazonPaymentsReady = function() {
                new OffAmazonPayments.Widgets.Wallet({
                    sellerId: '[{$oViewConf->fcpoGetAmazonPaySellerId()}]',
                    scope: 'profile payments:widget payments:shipping_address payments:billing_address',
                    onOrderReferenceCreate: function(orderReference) {
                        orderReferenceId = orderReference.getAmazonOrderReferenceId();
                    },
                    onPaymentSelect: function(orderReference) {
                        document.getElementById("amazon_order_reference_id").value = orderReferenceId;
                    },
                    design: {
                        designMode: 'responsive'
                    },
                    onError: function(error) {
                        console.log(error.getErrorCode() + ': ' + error.getErrorMessage());
                    }
                }).bind("walletWidgetDiv");
            };
        </script>
        <script async="async" src='[{$oViewConf->fcpoGetAmazonWidgetsUrl()}]'></script>

        [{block name="checkout_payment_nextstep"}]
            <div class="well well-sm">
                <a href="[{oxgetseourl ident=$oViewConf->getOrderLink()}]" class="btn btn-default pull-left prevStep submitButton largeButton" id="paymentBackStepBottom"><i class="fa fa-caret-left"></i> [{oxmultilang ident="PREVIOUS_STEP"}]</a>
                <button type="submit" name="userform" class="btn btn-primary pull-right submitButton nextStep largeButton" id="paymentNextStepBottom">[{oxmultilang ident="CONTINUE_TO_NEXT_STEP"}] <i class="fa fa-caret-right"></i></button>
                <div class="clearfix"></div>
            </div>
        [{/block}]
    </form>
[{else}]
    <script type="text/javascript">
        var oFcPayoneData = oFcPayoneData || [];
        oFcPayoneData.inputs =
            {
                fcpo_mid:                       '[{$oView->getMerchantId()}]',
                fcpo_portalid:                  '[{$oView->getPortalId()}]',
                fcpo_encoding:                  '[{$oView->getEncoding()}]',
                fcpo_aid:                       '[{$oView->getSubAccountId()}]',
                fcpo_amount:                    '[{$oView->getAmount()}]',
                fcpo_currency:                  '[{$currency->name}]',
                fcpo_tpllang:                   '[{$oView->getTplLang()}]',
                fcpo_bill_country:              '[{$oView->fcGetBillCountry()}]',
                dynvalue_fcpo_pseudocardpan:    '',
                dynvalue_fcpo_ccmode:           '',
                fcpo_checktype:                 '[{$oView->getChecktype()}]',
                fcpo_hashelvWith:               '[{$oView->getHashELVWithChecktype()}]',
                fcpo_hashelvWithout:            '[{$oView->getHashELVWithoutChecktype()}]',
                fcpo_integratorid:              '[{$oView->getIntegratorid()}]',
                fcpo_integratorver:             '[{$oView->getIntegratorver()}]',
                fcpo_integratorextver:          '[{$oView->getIntegratorextver()}]'
            };
    </script>

    [{oxscript include=$oViewConf->fcpoGetModuleJsPath('fcPayOne.js')}]
    [{oxstyle include=$oViewConf->fcpoGetModuleCssPath('fcpayone.css')}]

    [{$smarty.block.parent}]
[{/if}]