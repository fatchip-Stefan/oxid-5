[{$smarty.block.parent}]
[{assign var="payment" value=$oView->getPayment()}]
[{if $payment && method_exists($payment, 'fcpoGetMandateText') && $payment->fcpoGetMandateText()}]
    [{assign var="sMandateText" value=$payment->fcpoGetMandateText()}]
    <div id="fcpoSEPAMandate">
        <h3 class="section">
            <strong>SEPA-Lastschrift</strong>
        </h3>
        [{oxmultilang ident="FCPO_ORDER_MANDATE_INFOTEXT"}]
        <div class="fcpoSEPAMandate">
            [{$sMandateText}]
        </div>
        
        <div class="fcpoSEPAMandateCheckbo">
            <label style="float:left; padding-right:10px;" for="mandate_status" class="control-label">[{oxmultilang ident="FCPO_ORDER_MANDATE_CHECKBOX"}]</label>
            <input type="checkbox" onclick="fcpoHandleMandateCheckbox(this);">
            <div class="clear"></div>
        </div>
    </div>
[{/if}]
