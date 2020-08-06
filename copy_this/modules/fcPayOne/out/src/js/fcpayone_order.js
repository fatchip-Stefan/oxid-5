/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function editThisStatus( sID, sOxid ) {
    var oTransfer = top.basefrm.edit.document.getElementById( "transfer" );
    oTransfer.status_oxid.value = sID;
    oTransfer.oxid.value = sOxid;
    oTransfer.cl.value = top.oxid.admin.getClass( sID );

    //forcing edit frame to reload after submit
    top.forceReloadingEditFrame();

    var oSearch = top.basefrm.list.document.getElementById( "search" );
    oSearch.oxid.value = sOxid;
    oSearch.submit();
}

function toggleBankaccount() {
     if(top.basefrm.edit.document.getElementById('fcBankAccount1').style.display == 'none') {
         top.basefrm.edit.document.getElementById('fcBankAccount1').style.display = '';
         top.basefrm.edit.document.getElementById('fcBankAccount2').style.display = '';
         top.basefrm.edit.document.getElementById('fcBankAccount3').style.display = '';
         top.basefrm.edit.document.getElementById('fcBankAccount4').style.display = '';
         top.basefrm.edit.document.getElementById('fcShowBankaccount').style.display = 'none';
         top.basefrm.edit.document.getElementById('fcHideBankaccount').style.display = '';
     } else {
         top.basefrm.edit.document.getElementById('fcBankAccount1').style.display = 'none';
         top.basefrm.edit.document.getElementById('fcBankAccount2').style.display = 'none';
         top.basefrm.edit.document.getElementById('fcBankAccount3').style.display = 'none';
         top.basefrm.edit.document.getElementById('fcBankAccount4').style.display = 'none';
         top.basefrm.edit.document.getElementById('fcHideBankaccount').style.display = 'none';
         top.basefrm.edit.document.getElementById('fcShowBankaccount').style.display = '';
     }
}

function onClickCapture(oElement) {
    var dCaptureAmount          = parseFloat(document.getElementById('fc_capture_amount').value.replace(',', '.'));;
    var sErrorMessageCapture    = document.getElementById('fc_error_message_capture_greater_null').value;
    var sConfirmSure            = document.getElementById('fc_confirm_message').value;

    if(dCaptureAmount == 0) {
        alert(sErrorMessageCapture);
    } else {
        if(confirm(sConfirmSure)) {
            oElement.form.fnc.value='capture';
            oElement.form.submit();
        }
    }
}

function onClickCaptureComplete(checkboxValue) {
    if (checkboxValue === true) {
        setPriceEdit(false);
    } else {
        setPriceEdit(true);
    }
}

function setPriceEdit(toggle) {
    var formInputFields = document.getElementsByClassName("fcpoCapture");
    for (var i = 0; i < formInputFields.length; i++) {
        // console.log(formInputFields[i]);
        formInputFields[i].readOnly = toggle;
        if (toggle === false) {
            formInputFields[i].style.borderColor = "red";
        } else {
            formInputFields[i].style.borderColor = "";
        }
        revertAmountToOrderPrice(!toggle);
    }
}

function checkKeyEvent(event, element) {
    if (event.key == ",") {
        // Cancel the event
        event.preventDefault();
        event.stopPropagation();

        // Add point instead
        if (element.readOnly === false) {
            element.value += ".";
        }
    }
}

function addCaptureData(orderArticleId, price) {
    if (window.payoneCaptureData === undefined) {
        window.payoneCaptureData = {};
    }
    window.payoneCaptureData[orderArticleId] = {orderPrice: price};
}

function handleCaptureAmountChange(orderArticleId, element) {
    if (window.payoneCaptureData[orderArticleId] !== undefined) {
        window.payoneCaptureData[orderArticleId].changedPrice = parseFloat(element.value.replace(",", "."));
    }
}

function revertAmountToOrderPrice(completeCaptureEnabled) {
    for (var orderArticleId in window.payoneCaptureData) {
        var elem = document.getElementById("captureAmount_" + orderArticleId);
        if (elem !== undefined) {
            if (completeCaptureEnabled === false) {
                elem.value = window.payoneCaptureData[orderArticleId].orderPrice.toFixed(2);
            } else if (window.payoneCaptureData[orderArticleId].changedPrice !== undefined){
                elem.value = window.payoneCaptureData[orderArticleId].changedPrice.toFixed(2);
            }
        }
    }
}


