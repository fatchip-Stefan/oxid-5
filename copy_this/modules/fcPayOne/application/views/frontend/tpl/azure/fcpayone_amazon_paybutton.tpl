[{if !$sAmazonButtonId}]
    [{assign var="sAmazonButtonId" value='LoginWithAmazon'}]
[{/if}]


<div id="[{$sAmazonButtonId}]" class="btn pull-right"></div>
<script>
    window.onAmazonLoginReady = function() {
        amazon.Login.setClientId('[{$oViewConf->fcpoGetAmazonPayClientId()}]');
        [{if !$oViewConf->fcpoAmazonLoginSessionActive()}]
            amazon.Login.logout();
        [{/if}]
    };
    window.onAmazonPaymentsReady = function(){
        var authRequest;
        OffAmazonPayments.Button('[{$sAmazonButtonId}]', '[{$oViewConf->fcpoGetAmazonPaySellerId()}]', {
            type: '[{$oViewConf->fcpoGetAmazonPayButtonType()}]',
            color: '[{$oViewConf->fcpoGetAmazonPayButtonColor()}]',
            size: 'medium',
            language: 'none',
            authorization: function() {
                loginOptions = {scope: 'profile payments:widget payments:shipping_address payments:billing_address', popup: true};
                authRequest = amazon.Login.authorize (loginOptions, '[{$oViewConf->fcpoGetAmazonRedirectUrl()}]');
            }
        });
    }
</script>
[{if $sAmazonButtonId != 'LoginWithAmazonButtonBottom'}]
    <script async="async" src='[{$oViewConf->fcpoGetAmazonWidgetsUrl()}]'></script>
[{/if}]
