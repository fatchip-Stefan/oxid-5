<script type="text/javascript" src="https://h.online-metrix.net/fp/tags.js?org_id=363t8kgq&session_id=[{$oViewConf->fcpoGetPaySafeSessionId()}]"></script>
<noscript>
    <iframe style="width: 100px; height: 100px; border: 0; position: absolute; top: -5000px;" src="https://h.online-metrix.net/fp/tags?org_id=363t8kgq&session_id=[{$oViewConf->fcpoGetPaySafeSessionId()}]"></iframe>
</noscript>

[{assign var="sFcPoTemplatePath" value=$oView->fcpoGetActiveThemePath()}]

[{if $sPaymentID == "fcpopo_bill"}]
    [{assign var="sFcPoTemplatePath" value=$sFcPoTemplatePath|cat:'/fcpo_payment_payolution_bill.tpl'}]
    [{include file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath($sFcPoTemplatePath)}]
[{elseif $sPaymentID == "fcpopo_debitnote"}]
    [{assign var="sFcPoTemplatePath" value=$sFcPoTemplatePath|cat:'/fcpo_payment_payolution_debitnote.tpl'}]
    [{include file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath($sFcPoTemplatePath)}]
[{elseif $sPaymentID == "fcpopo_installment"}]
    [{assign var="sFcPoTemplatePath" value=$sFcPoTemplatePath|cat:'/fcpo_payment_payolution_installment.tpl'}]
    [{include file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath($sFcPoTemplatePath)}]
[{/if}]