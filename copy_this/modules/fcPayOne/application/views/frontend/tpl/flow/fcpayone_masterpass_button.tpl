[{oxscript include=$oViewConf->fcpoGetModuleJsPath('fcPayOne.js')}]
<link rel="stylesheet" type="text/css" href="[{$oViewConf->fcpoGetModuleCssPath('fcpomasterpass.css')}]">
<script type="text/javascript" src="[{$oViewConf->fcpoGetMasterPassJsLibUrl()}]"></script>

<div class="payone_basket_masterpass_btn_flow pull-right">
    <input type="hidden" id="fcpo_ajax_controller_url" value="[{$oViewConf->fcpoGetAjaxControllerUrl()}]">
    <input type="hidden" id="fcpo_ajax_shopurl" value="[{$oViewConf->fcpoGetShopUrl()}]">
    <img id="fcpo_masterpass_button" src="[{$oViewConf->fcpoGetMasterPassButtonImg()}]">
</div>
