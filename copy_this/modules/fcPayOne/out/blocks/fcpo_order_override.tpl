[{if $oViewConf->fcpoAmazonLoginSessionActive()}]
    [{oxid_include_dynamic file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath('fcpo_payment_amazon_script.tpl')}]
[{/if}]

[{$smarty.block.parent}]

[{if $oViewConf->fcpoIsKlarnaPaynow()}]
    [{oxid_include_dynamic file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath('fcpo_payment_klarna_script.tpl')}]
[{/if}]
