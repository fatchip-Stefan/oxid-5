[{oxscript include=$oViewConf->fcpoGetModuleJsPath('fcPayOne.js')}]
<link rel="stylesheet" type="text/css" href="[{$oViewConf->fcpoGetModuleCssPath('fcpomasterpass.css')}]">
[{oxscript include=$oViewConf->fcpoGetModuleJsPath('fcPayOne.js')}]
<script type="text/javascript" src="[{$oViewConf->fcpoGetMasterpassJsLibUrl()}]"></script>

[{if $sMasterpassButtonId}]
    [{assign var="iMasterpassButtonIncluded" value=$iMasterpassButtonIncluded+1}]
    [{elseif !$iMasterpassButtonIncluded}]
    [{assign var="iMasterpassButtonIncluded" value="0"}]
    [{else}]
    [{assign var="iMasterpassButtonIncluded" value=$iMasterpassButtonIncluded+1}]
[{/if}]

[{if !$sMasterpassButtonId}]
    [{assign var="sMasterpassButtonId" value='LoginWithMasterpass'}]
[{/if}]

[{$oViewConf->fcpoSetCurrentMasterpassButtonId($sMasterpassButtonId)}]

<div class="payone_basket_masterpass_btn_flow pull-right">
    <input type="hidden" id="fcpo_ajax_controller_url" value="[{$oViewConf->fcpoGetAjaxControllerUrl()}]">
    <input type="hidden" id="fcpo_ajax_shopurl" value="[{$oViewConf->fcpoGetShopUrl()}]">
    <img id="[{$sMasterpassButtonId}][{$iMasterpassButtonIncluded}]" src="[{$oViewConf->fcpoGetMasterpassButtonImg()}]">
</div>
