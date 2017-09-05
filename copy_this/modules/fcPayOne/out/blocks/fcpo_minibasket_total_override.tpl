[{$smarty.block.parent}]

[{if $oViewConf->fcpoCanDisplayAmazonPayButton()}]
    <p class="functions clear text-right">
        [{assign var="sFcPoTemplatePath" value=$oViewConf->fcpoGetActiveThemePath()}]
        [{assign var="sFcPoTemplatePath" value=$sFcPoTemplatePath|cat:'/fcpayone_amazon_paybutton_minibasket.tpl'}]
        [{include file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath($sFcPoTemplatePath)}]
    </p>
[{/if}]
