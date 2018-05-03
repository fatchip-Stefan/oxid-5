[{if $oViewConf->fcpoCanDisplayAmazonPayButton()}]
    <p>[{oxmultilang ident="FCPO_AMAZON_LOGIN"}]</p>
    <p>
        [{assign var="sFcPoTemplatePath" value=$oViewConf->fcpoGetActiveThemePath()}]
        [{assign var="sFcPoTemplatePath" value=$sFcPoTemplatePath|cat:'/fcpayone_amazon_paybutton.tpl'}]
        [{include
            file=$oViewConf->fcpoGetAbsModuleTemplateFrontendPath($sFcPoTemplatePath)
            sAmazonButtonId='LoginWithAmazonButtonLogin'
            sAmazonButtonClass=''
        }]
    </p>
    <p>[{oxmultilang ident="FCPO_OR"}]</p>
[{/if}]
[{$smarty.block.parent}]