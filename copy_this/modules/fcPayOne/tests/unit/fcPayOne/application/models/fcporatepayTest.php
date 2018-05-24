<?php
/**
 * Created by PhpStorm.
 * User: andrefatchip
 * Date: 08.03.18
 * Time: 11:38
 */

class Unit_fcPayOne_Application_Models_fcporatepay extends OxidTestCase {
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     * @throws exception
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array()) {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Set protected/private attribute value
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $propertyName property that shall be set
     * @param array  $value value to be set
     * @throws exception
     * @return mixed Method return.
     */
    public function invokeSetAttribute(&$object, $propertyName, $value) {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue($object, $value);
    }


    /**
     * Testing fcpoInsertProfile for coverage
     */
    public function test_fcpoInsertProfile_Coverage() {
        $oTestObject = $this->getMock('fcporatepay', array('_fcpoUpdateRatePayProfile'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoUpdateRatePayProfile')
            ->will($this->returnValue(null));

        $oMockDb = $this->getMock('oxDb', array('quote', 'Execute'));
        $oMockDb->expects($this->any())->method('quote')->will($this->returnValue('someQuotedValue'));
        $oMockDb->expects($this->any())->method('Execute')->will($this->returnValue(null));
        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $aMockRatepayData = array(
            'shopid'=>'someShopId',
            'currency'=>'',
            'paymentid'=>'',
        );

        $this->assertEquals(null, $oTestObject->fcpoInsertProfile('someOxid', $aMockRatepayData));
    }

    /**
     * Testing fcpoGetRatePayProfiles coverage
     */
    public function test_fcpoGetRatePayProfiles_Coverage() {
        $oTestObject = $this->getMock('fcporatepay', array('fcpoGetFields'));
        $oTestObject->expects($this->any())->method('fcpoGetFields')->will($this->returnValue(array('some', 'fields')));

        $aMockRows = array(
            array(
                'value1',
                'value2',
            ),
        );

        $oMockDb = $this->getMock('oxDb', array('getAll'));
        $oMockDb->expects($this->any())->method('getAll')->will($this->returnValue($aMockRows));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetDb')->will($this->returnValue($oMockDb));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $aExpect = $aReturn = $oTestObject->fcpoGetRatePayProfiles('somePaymentId');

        $this->assertEquals($aExpect, $aReturn);
    }

    /**
     * Testing fcpoAddRatePayProfile for coverage
     */
    public function test_fcpoAddRatePayProfile_Coverage() {
        $oTestObject = oxNew('fcporatepay');
        $oMockUtilsObject = $this->getMock('oxUtilsObject', array('generateUId'));
        $oMockUtilsObject->expects($this->any())->method('generateUId')->will($this->returnValue('someNewOxid'));

        $oMockDb = $this->getMock('oxDb', array('Execute'));
        $oMockDb->expects($this->any())->method('Execute')->will($this->returnValue(null));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetUtilsObject')->will($this->returnValue($oMockUtilsObject));
        $oHelper->expects($this->any())->method('fcpoGetDb')->will($this->returnValue($oMockDb));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(null, $oTestObject->fcpoAddRatePayProfile());
    }

    /**
     * Testing fcpoGetProfileData for coverage
     */
    public function test_fcpoGetProfileData_Coverage() {
        $oTestObject = $this->getMock('fcporatepay', array('fcpoGetFields'));
        $oTestObject->expects($this->any())->method('fcpoGetFields')->will($this->returnValue(array('field1', 'field2')));

        $aMockRow = array(
            'field1'=>'value1',
            'field2'=>'value2',
        );

        $oMockDb = $this->getMock('oxDb', array('quote', 'GetRow'));
        $oMockDb->expects($this->any())->method('quote')->will($this->returnValue('someId'));
        $oMockDb->expects($this->any())->method('GetRow')->will($this->returnValue($aMockRow));
        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $aExpect = $aReturn = $oTestObject->fcpoGetProfileData('someId');
        $this->assertEquals($aExpect,$aReturn);
    }

    /**
     * Testing fcpoGetFields for coverage
     */
    public function test_fcpoGetFields_Coverage() {
        $oTestObject = oxNew('fcporatepay');
        $aMockRows = array(
            $aMockRow = array(
                'field1',
                'field2',
            )
        );

        $oMockDb = $this->getMock('oxDb', array('getAll'));
        $oMockDb->expects($this->any())->method('getAll')->will($this->returnValue($aMockRows));
        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $aExpect = array('field1');

        $this->assertEquals($aExpect, $oTestObject->fcpoGetFields());
    }

    /**
     * Testing _fcpoGetProfilePaymentActiveField for coverage
     */
    public function test__fcpoGetProfilePaymentActiveField_Coverage() {
        $oTestObject = oxNew('fcporatepay');
        $sExpect = 'activation_status_invoice';
        $sMockPaymentId = 'fcporp_bill';
        $this->assertEquals($sExpect, $oTestObject->_fcpoGetProfilePaymentActiveField($sMockPaymentId));
    }

    /**
     * Testing _fcpoUpdateRatePayProfile for coverage
     */
    public function test__fcpoUpdateRatePayProfile_Coverage() {
        $aMockRatepayProfileData = array('some', 'data');

        $oTestObject = $this->getMock('fcporatepay', array(
            'fcpoGetProfileData',
            '_fcpoUpdateRatePayProfileByResponse'
        ));
        $oTestObject
            ->expects($this->any())
            ->method('fcpoGetProfileData')
            ->will($this->returnValue($aMockRatepayProfileData));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoUpdateRatePayProfileByResponse')
            ->will($this->returnValue(null));

        $aMockResponse = array('status'=>'OK');

        $oMockRequest = $this->getMock('fcporequest', array('sendRequestRatePayProfile'));
        $oMockRequest
            ->expects($this->any())
            ->method('sendRequestRatePayProfile')
            ->will($this->returnValue($aMockResponse));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('getFactoryObject')->will($this->returnValue($oMockRequest));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(null, $oTestObject->_fcpoUpdateRatePayProfile('someOxid'));
    }

    /**
     * Testing _fcpoUpdateRatePayProfileByResponse for coverage
     */
    public function test__fcpoUpdateRatePayProfileByResponse_Coverage() {
        $oTestObject = oxNew('fcporatepay');

        $aMockResponse = array(
            'add_paydata[merchant-name]'=>'',
            'add_paydata[merchant-status]'=>'',
            'add_paydata[shop-name]'=>'',
            'add_paydata[name]'=>'',
            'add_paydata[type]'=>'',
            'add_paydata[activation-status-elv]'=>'',
            'add_paydata[activation-status-installment]'=>'',
            'add_paydata[activation-status-invoice]'=>'',
            'add_paydata[activation-status-prepayment]'=>'',
            'add_paydata[amount-min-longrun]'=>'',
            'add_paydata[b2b-PQ-full]'=>'',
            'add_paydata[b2b-PQ-light]'=>'',
            'add_paydata[b2b-elv]'=>'',
            'add_paydata[b2b-installment]'=>'',
            'add_paydata[b2b-invoice]'=>'',
            'add_paydata[b2b-prepayment]'=>'',
            'add_paydata[country-code-billing]'=>'',
            'add_paydata[country-code-delivery]'=>'',
            'add_paydata[delivery-address-PQ-full]'=>'',
            'add_paydata[delivery-address-PQ-light]'=>'',
            'add_paydata[delivery-address-elv]'=>'',
            'add_paydata[delivery-address-installment]'=>'',
            'add_paydata[delivery-address-invoice]'=>'',
            'add_paydata[delivery-address-prepayment]'=>'',
            'add_paydata[device-fingerprint-snippet-id]'=>'',
            'add_paydata[eligibility-device-fingerprint]'=>'',
            'add_paydata[eligibility-ratepay-elv]'=>'',
            'add_paydata[eligibility-ratepay-installment]'=>'',
            'add_paydata[eligibility-ratepay-invoice]'=>'',
            'add_paydata[eligibility-ratepay-pq-full]'=>'',
            'add_paydata[eligibility-ratepay-pq-light]'=>'',
            'add_paydata[eligibility-ratepay-prepayment]'=>'',
            'add_paydata[interest-rate-merchant-towards-bank]'=>'',
            'add_paydata[interestrate-default]'=>'',
            'add_paydata[interestrate-max]'=>'',
            'add_paydata[interestrate-min]'=>'',
            'add_paydata[min-difference-dueday]'=>'',
            'add_paydata[month-allowed]'=>'',
            'add_paydata[month-longrun]'=>'',
            'add_paydata[month-number-max]'=>'',
            'add_paydata[month-number-min]'=>'',
            'add_paydata[payment-amount]'=>'',
            'add_paydata[payment-firstday]'=>'',
            'add_paydata[payment-lastrate]'=>'',
            'add_paydata[rate-min-longrun]'=>'',
            'add_paydata[rate-min-normal]'=>'',
            'add_paydata[service-charge]'=>'',
            'add_paydata[tx-limit-elv-max]'=>'',
            'add_paydata[tx-limit-elv-min]'=>'',
            'add_paydata[tx-limit-installment-max]'=>'',
            'add_paydata[tx-limit-installment-min]'=>'',
            'add_paydata[tx-limit-invoice-max]'=>'',
            'add_paydata[tx-limit-invoice-min]'=>'',
            'add_paydata[tx-limit-prepayment-max]'=>'',
            'add_paydata[tx-limit-prepayment-min]'=>'',
            'add_paydata[valid-payment-firstdays]'=>'',
        );

        $oMockDb = $this->getMock('oxDb', array('quote', 'Execute'));
        $oMockDb->expects($this->any())->method('quote')->will($this->returnValue('someValue'));
        $oMockDb->expects($this->any())->method('Execute')->will($this->returnValue(null));

        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $this->assertEquals(null, $oTestObject->_fcpoUpdateRatePayProfileByResponse('someId', $aMockResponse));
    }

}