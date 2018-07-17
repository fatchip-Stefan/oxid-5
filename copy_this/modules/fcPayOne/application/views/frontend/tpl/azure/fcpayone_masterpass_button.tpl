
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
    <img class="js-payone-masterpass"
         data-payone-masterpass-shopurl="[{$oViewConf->fcpoGetShopUrl()}]"
         data-payone-masterpass-controller="[{$oViewConf->fcpoGetAjaxControllerUrl()}]"
         src="[{$oViewConf->fcpoGetMasterpassButtonImg()}]">
</div>
