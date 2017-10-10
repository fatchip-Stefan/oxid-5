<link rel="stylesheet" type="text/css" href="[{$oViewConf->fcpoGetModuleCssPath('fcpoamazon.css')}]">

[{if !$iAmzButtonIncluded}]
    [{assign var="iAmzButtonIncluded" value="0"}]
[{else}]
    [{assign var="iAmzButtonIncluded" value=$iAmzButtonIncluded+1}]
[{/if}]

[{if !$sAmazonButtonId}]
    [{assign var="sAmazonButtonId" value='LoginWithAmazon'}]
[{/if}]

<div id="[{$sAmazonButtonId}][{$iAmzButtonIncluded}]" class="[{$sAmazonButtonClass}]"></div>
<script>
    function getURLParameter(name, source) {
        return decodeURIComponent((new RegExp('[?|&|#]' + name + '=' +
            '([^&]+?)(&|#|;|$)').exec(source) || [,""])[1].replace(/\+/g,
            '%20')) || null;
    }

    var accessToken = getURLParameter("access_token", location.hash);

    if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
        var newLocation = "[{$oViewConf->fcpoGetAmazonRedirectUrl()}]" + "&access_token=" + encodeURI(accessToken);
        document.location.href = newLocation;
    }

    // initialize client
    if (typeof window.onAmazonLoginReady !== 'function') {
        window.onAmazonLoginReady = function() {
            amazon.Login.setClientId('[{$oViewConf->fcpoGetAmazonPayClientId()}]');
            [{if !$oViewConf->fcpoAmazonLoginSessionActive()}]
                amazon.Login.logout();
            [{/if}]
        };
    }

    // initialize button array
    if (typeof window.onAmazonPaymentsReadyArray === 'undefined') {
        window.onAmazonPaymentsReadyArray = [];
    }

    // iterate through filled array with buttons
    if (typeof window.onAmazonPaymentsReady !== 'function') {
        window.onAmazonPaymentsReady = function () {
            window.onAmazonPaymentsReadyArray.forEach(function (callback) {
                callback();
            });
        };
    }

    // fill array with amazon pay button
    window.onAmazonPaymentsReadyArray.push(function () {
        var authRequest, loginOptions;
        OffAmazonPayments.Button('[{$sAmazonButtonId}][{$iAmzButtonIncluded}]', '[{$oViewConf->fcpoGetAmazonPaySellerId()}]', {
            type: '[{$oViewConf->fcpoGetAmazonPayButtonType()}]',
            color: '[{$oViewConf->fcpoGetAmazonPayButtonColor()}]',
            language: 'none',
            size: 'medium',
            authorization: function () {
                loginOptions = {
                    scope: 'payments:billing_address payments:shipping_address payments:widget profile',
                    [{if $oViewConf->isSsl()}]
                        popup: true
                    [{else}]
                        popup: false
                    [{/if}]
                };
                authRequest = amazon.Login.authorize(loginOptions, '[{$oViewConf->fcpoGetAmazonRedirectUrl()}]');
            }
        });
    });

</script>
[{if $iAmzButtonIncluded <=1}]
    <script async="async" src='[{$oViewConf->fcpoGetAmazonWidgetsUrl()}]'></script>
[{/if}]
