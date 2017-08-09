<div id="LoginWithAmazon"></div>
<script>
    window.onAmazonLoginReady = function() {
        amazon.Login.setClientId('[{$oViewConf->fcpoGetAmazonPayClientId()}]');
    };
    window.onAmazonPaymentsReady = function(){
        var authRequest;
        OffAmazonPayments.Button('LoginWithAmazon', '[{$oViewConf->fcpoGetAmazonPaySellerId()}]', {
            type: '[{$oViewConf->fcpoGetAmazonPayButtonType()}]',
            color: '[{$oViewConf->fcpoGetAmazonPayButtonColor()}]',
            size: 'medium',
            language: '[{$oViewConf->fcpoGetAmazonPayButtonLanguage()}]',
            authorization: function() {
                loginOptions = {scope: 'profile payments:widget payments:shipping_address payments:billing_address', popup: true};
                authRequest = amazon.Login.authorize (loginOptions, '[{$oViewConf->fcpoGetAmazonRedirectUrl()}]');
            }
        });
    }
</script>
<script async="async" src='[{$oViewConf->fcpoGetAmazonWidgetsUrl()}]'></script>
