[{$smarty.block.parent}]

[{if $oViewConf->fcpoCanDisplayAmazonPayButton('minibasket')}]
    <p class="functions clear text-right">
        [{include file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath('fcpayone_amazon_paybutton.tpl')}]
    </p>
[{/if}]