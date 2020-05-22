<dl>
    <dt>
        <input id="payment_[{$sPaymentID}]" type="radio" name="paymentid" value="[{$sPaymentID}]"
               [{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]checked[{/if}]>
        <label for="payment_[{$sPaymentID}]"><b>[{$paymentmethod->oxpayments__oxdesc->value}]</b>
            [{$oView->fcpoGetFormattedPaymentCosts($paymentmethod)}]</label>
    </dt>
    <dd class="[{if $oView->getCheckedPaymentId() == $paymentmethod->oxpayments__oxid->value}]activePayment[{/if}]">
        <input type="hidden" name="fcpo_mode_[{$sPaymentID}]" value="[{$paymentmethod->fcpoGetOperationMode()}]">
        [{if ! $oView->fcpoIsB2BPov()}]
        <ul>
            <li>
                <!-- Use BR here for spacing class='form' breaks dropdowns -->
                <BR>
                <label>[{oxmultilang ident="FCPO_PAYOLUTION_BIRTHDATE"}]</label>
                <select name="dynvalue[fcpo_secinvoice_birthdate_day]">
                    [{foreach from=$oView->fcpoGetDayRange() item='sDay'}]
                    <option value="[{$sDay}]" [{if $sDay == $oView->fcpoGetBirthdayField('day')}]selected[{/if}]>
                        [{$sDay}]
                    </option>
                    [{/foreach}]
                </select>

                <select name="dynvalue[fcpo_secinvoice_birthdate_month]">
                    [{foreach from=$oView->fcpoGetMonthRange() item='sMonth'}]
                    <option value="[{$sMonth}]"
                            [{if $sMonth == $oView->fcpoGetBirthdayField('month')}]selected[{/if}]>[{$sMonth}]
                    </option>
                    [{/foreach}]
                </select>

                <select name="dynvalue[fcpo_secinvoice_birthdate_year]">
                    [{foreach from=$oView->fcpoGetYearRange() item='sYear'}]
                    <option value="[{$sYear}]" [{if $sYear == $oView->fcpoGetBirthdayField('year')}]selected[{/if}]>
                        [{$sYear}]
                    </option>
                    [{/foreach}]
                </select>
            </li>
        </ul>
        [{else}]
        <ul>
            <li>
                <label>[{oxmultilang ident="FCPO_SECINVOICE_USTID"}]</label>
                <input name="dynvalue[fcpo_secinvoice_ustid]" value="[{$oView->fcpoGetUserValue('oxustid')}]"
                       type="text">
            </li>
        </ul>
        <li>
            [{oxmultilang ident="FCPO_SECINVOICE_NO_COMPANY"}]
        </li>
        [{/if}]
        [{block name="checkout_payment_longdesc"}]
        [{if $paymentmethod->oxpayments__oxlongdesc->value}]
        <div class="desc">
            [{$paymentmethod->oxpayments__oxlongdesc->getRawValue()}]
        </div>
        [{/if}]
        [{/block}]
    </dd>
</dl>