[{if !$iAmzButtonIncluded}]
    [{assign var="iAmzButtonIncluded" value="0"}]
[{else}]
    [{assign var="iAmzButtonIncluded" value=$iAmzButtonIncluded+1}]
[{/if}]

[{if !$sAmazonButtonId}]
    [{assign var="sAmazonButtonId" value='LoginWithAmazon'}]
[{/if}]

<div id="[{$sAmazonButtonId}]" class="payone_amazon_btn pull-right"></div>
<script>
    if (typeof window.onAmazonLoginReady !== 'function') {
        window.onAmazonLoginReady = function() {
            amazon.Login.setClientId('[{$oViewConf->fcpoGetAmazonPayClientId()}]');
            [{if !$oViewConf->fcpoAmazonLoginSessionActive()}]
                amazon.Login.logout();
            [{/if}]
        };
    }

    if (typeof window.onAmazonPaymentsReadyArray === 'undefined') {
        window.onAmazonPaymentsReadyArray = [];
    }

    if (typeof window.onAmazonPaymentsReady !== 'function') {
        window.onAmazonPaymentsReady = function () {
            window.onAmazonPaymentsReadyArray.forEach(function (callback) {
                callback();
            });
        };
    }

    window.onAmazonPaymentsReadyArray.push(function () {
        var authRequest, loginOptions;
        OffAmazonPayments.Button('[{$sAmazonButtonId}]', '[{$oViewConf->fcpoGetAmazonPaySellerId()}]', {
            type: '[{$oViewConf->fcpoGetAmazonPayButtonType()}]',
            color: '[{$oViewConf->fcpoGetAmazonPayButtonColor()}]',
            language: 'none',
            size: 'medium',
            authorization: function () {
                loginOptions = {
                    scope: 'payments:billing_address payments:shipping_address payments:widget profile',
                    popup: true
                };
                authRequest = amazon.Login.authorize(loginOptions, '[{$oViewConf->fcpoGetAmazonRedirectUrl()}]');
            }
        });
    });

</script>
[{if $iAmzButtonIncluded <=1}]
    <script async="async" src='[{$oViewConf->fcpoGetAmazonWidgetsUrl()}]'></script>
[{/if}]
