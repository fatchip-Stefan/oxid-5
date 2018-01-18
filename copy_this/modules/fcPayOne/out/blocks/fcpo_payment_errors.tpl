[{$smarty.block.parent}]

[{assign var='sCurrentThemeName' value='azure'}]
[{if method_exists($oViewConf, 'getActiveTheme')}]
    [{assign var='sCurrentThemeName' value=$oViewConf->getActiveTheme()}]
[{/if}]

[{assign var="iPayError" value=$oView->getPaymentError()}]
[{if $iPayError == -20}]
    [{if $sCurrentThemeName == 'mobile'}]
        <div class="payment-row">
            <div class="alert alert-error">[{$oView->getPaymentErrorText()}]</div>
        </div>    
    [{elseif $sCurrentThemeName == 'flow'}]
        <div class="alert alert-danger">[{$oView->getPaymentErrorText()}]</div>
    [{else}]
        <div class="status error">[{$oView->getPaymentErrorText()}]</div>
    [{/if}]
[{/if}]

[{foreach from=$oView->fcpoGetUserFlagMessages() item='sUserFlagMessage'}]
    [{if $sCurrentThemeName == 'mobile'}]
        <div class="payment-row">
            <div class="alert alert-info">[{oxmultilang ident=$sUserFlagMessage}]</div>
        </div>
    [{elseif $sCurrentThemeName == 'flow'}]
        <div class="alert alert-info">[{oxmultilang ident=$sUserFlagMessage}]</div>
    [{else}]
        <div class="status info">[{oxmultilang ident=$sUserFlagMessage}]</div>
    [{/if}]
[{/foreach}]

