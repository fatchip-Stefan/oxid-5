<?php
/**
 * Created by PhpStorm.
 * User: andrefatchip
 * Date: 08.03.18
 * Time: 21:47
 */

class Unit_fcPayOne_Application_Models_fcpayone_ajaxTest extends OxidTestCase {

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
     * Testing fcpoGetAmazonReferenceId for coverage
     */
    public function test_fcpoGetAmazonReferenceId_Coverage() {
        $oTestObject = $this->getMock('fcpayone_ajax', array(
            '_fcpoHandleGetOrderReferenceDetails',
            '_fcpoHandleSetOrderReferenceDetails',
        ));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoHandleGetOrderReferenceDetails')
            ->will($this->returnValue(null));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoHandleSetOrderReferenceDetails')
            ->will($this->returnValue(null));

        $oMockSession = $this->getMock('oxSession', array(
            'deleteVariable',
            'setVariable',
            'getVariable',
        ));
        $oMockSession
            ->expects($this->any())
            ->method('deleteVariable')
            ->will($this->returnValue(true));
        $oMockSession
            ->expects($this->any())
            ->method('setVariable')
            ->will($this->returnValue(true));
        $oMockSession
            ->expects($this->any())
            ->method('getVariable')
            ->will($this->returnValue('someSessionValue'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetSession')->will($this->returnValue($oMockSession));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $sMockJson = '{"some":"jsonparam"}';

        $this->assertEquals(null, $oTestObject->fcpoGetAmazonReferenceId($sMockJson));
    }

    /**
     * Testing _fcpoHandleSetOrderReferenceDetails for status ok
     */
    public function test__fcpoHandleSetOrderReferenceDetails_StatusOK() {
        $oTestObject = oxNew('fcpayone_ajax');

        $aMockResponse = array('status'=>'OK');

        $oMockRequest = $this->getMock('fcporequest', array(
            'sendRequestSetAmazonOrderReferenceDetails',
        ));
        $oMockRequest
            ->expects($this->any())
            ->method('sendRequestSetAmazonOrderReferenceDetails')
            ->will($this->returnValue($aMockResponse));

        $oMockUser = $this->getMock('oxUser', array('fcpoSetAmazonOrderReferenceDetailsResponse'));
        $oMockUser
            ->expects($this->any())
            ->method('fcpoSetAmazonOrderReferenceDetailsResponse')
            ->will($this->returnValue(null));

        $oMockUtils = $this->getMock('oxUtils', array('redirect'));
        $oMockUtils
            ->expects($this->any())
            ->method('redirect')
            ->will($this->returnValue(null));

        $oMockConfig = $this->getMock('oxConfig', array('getShopUrl'));
        $oMockConfig
            ->expects($this->any())
            ->method('getShopUrl')
            ->will($this->returnValue('https://www.someshop.com/'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetUtils')
            ->will($this->returnValue($oMockUtils));
        $oHelper
            ->expects($this->any())
            ->method('getFactoryObject')
            ->will($this->onConsecutiveCalls($oMockRequest,$oMockUser));
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetConfig')
            ->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(
            null,
            $oTestObject->_fcpoHandleSetOrderReferenceDetails('someReferenceId','someAccessToken')
        );
    }

    /**
     * Testing _fcpoHandleSetOrderReferenceDetails for status error
     */
    public function test__fcpoHandleSetOrderReferenceDetails_StatusError() {
        $oTestObject = oxNew('fcpayone_ajax');

        $aMockResponse = array('status'=>'ERROR');

        $oMockRequest = $this->getMock('fcporequest', array(
            'sendRequestSetAmazonOrderReferenceDetails',
        ));
        $oMockRequest
            ->expects($this->any())
            ->method('sendRequestSetAmazonOrderReferenceDetails')
            ->will($this->returnValue($aMockResponse));

        $oMockUser = $this->getMock('oxUser', array('fcpoSetAmazonOrderReferenceDetailsResponse'));
        $oMockUser
            ->expects($this->any())
            ->method('fcpoSetAmazonOrderReferenceDetailsResponse')
            ->will($this->returnValue(null));

        $oMockUtils = $this->getMock('oxUtils', array('redirect'));
        $oMockUtils
            ->expects($this->any())
            ->method('redirect')
            ->will($this->returnValue(null));

        $oMockConfig = $this->getMock('oxConfig', array('getShopUrl'));
        $oMockConfig
            ->expects($this->any())
            ->method('getShopUrl')
            ->will($this->returnValue('https://www.someshop.com/'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetUtils')
            ->will($this->returnValue($oMockUtils));
        $oHelper
            ->expects($this->any())
            ->method('getFactoryObject')
            ->will($this->onConsecutiveCalls($oMockRequest,$oMockUser));
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetConfig')
            ->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(
            null,
            $oTestObject->_fcpoHandleSetOrderReferenceDetails('someReferenceId','someAccessToken')
        );
    }

    /**
     * Testing _fcpoHandleGetOrderReferenceDetails for status OK
     */
    public function test__fcpoHandleGetOrderReferenceDetails_StatusOK() {
        $oTestObject = oxNew('fcpayone_ajax');

        $aMockResponse = array('status'=>'OK');

        $oMockRequest = $this->getMock('fcporequest', array(
            'sendRequestGetAmazonOrderReferenceDetails',
        ));
        $oMockRequest
            ->expects($this->any())
            ->method('sendRequestGetAmazonOrderReferenceDetails')
            ->will($this->returnValue($aMockResponse));

        $oMockUtils = $this->getMock('oxUtils', array('redirect'));
        $oMockUtils
            ->expects($this->any())
            ->method('redirect')
            ->will($this->returnValue(null));

        $oMockConfig = $this->getMock('oxConfig', array('getShopUrl'));
        $oMockConfig
            ->expects($this->any())
            ->method('getShopUrl')
            ->will($this->returnValue('https://www.someshop.com/'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetUtils')
            ->will($this->returnValue($oMockUtils));
        $oHelper
            ->expects($this->any())
            ->method('getFactoryObject')
            ->will($this->returnValue($oMockRequest));
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetConfig')
            ->will($this->returnValue($oMockConfig));
        $oHelper
            ->expects($this->any())
            ->method('fcpoDeleteSessionVariable')
            ->will($this->returnValue(null));
        $oHelper
            ->expects($this->any())
            ->method('fcpoSetSessionVariable')
            ->will($this->returnValue(null));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(
            null,
            $oTestObject->_fcpoHandleGetOrderReferenceDetails('someReferenceId','someAccessToken')
        );
    }

    /**
     * Testing _fcpoHandleGetOrderReferenceDetails for status error
     */
    public function test__fcpoHandleGetOrderReferenceDetails_StatusError() {
        $oTestObject = oxNew('fcpayone_ajax');

        $aMockResponse = array('status'=>'ERROR');

        $oMockRequest = $this->getMock('fcporequest', array(
            'sendRequestSetAmazonOrderReferenceDetails',
        ));
        $oMockRequest
            ->expects($this->any())
            ->method('sendRequestGetAmazonOrderReferenceDetails')
            ->will($this->returnValue($aMockResponse));

        $oMockUtils = $this->getMock('oxUtils', array('redirect'));
        $oMockUtils
            ->expects($this->any())
            ->method('redirect')
            ->will($this->returnValue(null));

        $oMockConfig = $this->getMock('oxConfig', array('getShopUrl'));
        $oMockConfig
            ->expects($this->any())
            ->method('getShopUrl')
            ->will($this->returnValue('https://www.someshop.com/'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetUtils')
            ->will($this->returnValue($oMockUtils));
        $oHelper
            ->expects($this->any())
            ->method('getFactoryObject')
            ->will($this->returnValue($oMockRequest));
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetConfig')
            ->will($this->returnValue($oMockConfig));
        $oHelper
            ->expects($this->any())
            ->method('fcpoDeleteSessionVariable')
            ->will($this->returnValue(null));
        $oHelper
            ->expects($this->any())
            ->method('fcpoSetSessionVariable')
            ->will($this->returnValue(null));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(
            null,
            $oTestObject->_fcpoHandleGetOrderReferenceDetails('someReferenceId','someAccessToken')
        );
    }

    /**
     * Testing fcpoTriggerPrecheck for coverage
     */
    public function test_fcpoTriggerPrecheck_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');

        $oMockPayment = $this->getMock('payment', array(
            'setPayolutionAjaxParams',
            'fcpoPayolutionPreCheck',
        ));
        $oMockPayment
            ->expects($this->any())
            ->method('setPayolutionAjaxParams')
            ->will($this->returnValue(null));
        $oMockPayment
            ->expects($this->any())
            ->method('fcpoPayolutionPreCheck')
            ->will($this->returnValue(true));


        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('getFactoryObject')
            ->will($this->returnValue($oMockPayment));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $sMockJson = '{"some":"jsonparam"}';

        $this->assertEquals(
            'SUCCESS',
            $oTestObject->fcpoTriggerPrecheck('somePaymentId', $sMockJson)
        );
    }

    /**
     * Testing fcpoTriggerInstallmentCalculation for coverage
     */
    public function test_fcpoTriggerInstallmentCalculation_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');

        $oMockPayment = $this->getMock('payment', array(
            'fcpoPerformInstallmentCalculation',
            'fcpoGetInstallments',
        ));
        $oMockPayment
            ->expects($this->any())
            ->method('fcpoPerformInstallmentCalculation')
            ->will($this->returnValue(null));
        $oMockPayment
            ->expects($this->any())
            ->method('fcpoGetInstallments')
            ->will($this->returnValue(false));


        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('getFactoryObject')
            ->will($this->returnValue($oMockPayment));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(
            false,
            $oTestObject->fcpoTriggerInstallmentCalculation('somePaymentId')
        );
    }

    /**
     * Testing fcpoParseCalculation2Html for coverage
     */
    public function test_fcpoParseCalculation2Html_Coverage() {
        $oTestObject = $this->getMock('fcpayone_ajax', array(
            '_fcpoGetInsterestHiddenFields',
            '_fcpoGetInsterestRadio',
            '_fcpoGetInsterestLabel',
            '_fcpoGetInsterestMonthDetail',
            '_fcpoGetLightView',
        ));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetInsterestHiddenFields')
            ->will($this->returnValue('someFields'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetInsterestRadio')
            ->will($this->returnValue('someRadio'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetInsterestLabel')
            ->will($this->returnValue('someLabel'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetInsterestMonthDetail')
            ->will($this->returnValue('someDetail'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetLightView')
            ->will($this->returnValue('someLightView'));

        $oMockConfig = $this->getMock('oxConfig', array('getShopUrl'));
        $oMockConfig
            ->expects($this->any())
            ->method('getShopUrl')
            ->will($this->returnValue('https://www.someshop.com/'));

        $oMockLang = $this->getMock('oxLang', array('translateString'));
        $oMockLang
            ->expects($this->any())
            ->method('translateString')
            ->will($this->returnValue('https://www.someshop.com/'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetLang')
            ->will($this->returnValue($oMockLang));
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetConfig')
            ->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $aMockCalculation = array(array(
            'Months'=>array(
                'someMonth'=>array('some'=>'data')
            ),
            'StandardCreditInformationUrl'=>array(
                'someUrlInfo'=>'someUrl'
            ),
        ));
        $sExpect = $sResponse = $oTestObject->fcpoParseCalculation2Html($aMockCalculation);

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetLightView for coverage
     */
    public function test__fcpoGetLightView_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');
        $sExpect = $sResponse = $oTestObject->_fcpoGetLightView();

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing fcpoReturnErrorMessage for coverage
     */
    public function test_fcpoReturnErrorMessage_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');

        $oMockConfig = $this->getMock('oxConfig', array('isUtf'));
        $oMockConfig
            ->expects($this->any())
            ->method('isUtf')
            ->will($this->returnValue(false));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetConfig')
            ->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $sExpect = $sResponse = $oTestObject->fcpoReturnErrorMessage('someMessage');

        $this->assertEquals($sExpect, $sResponse);

    }

    /**
     * Testing _fcpoGetInsterestHiddenFields for coverage
     */
    public function test__fcpoGetInsterestHiddenFields_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');

        $aMockInstallment = array(
            'Amount'=>'',
            'Duration'=>'',
            'EffectiveInterestRate'=>'',
            'InterestRate'=>'',
            'TotalAmount'=>'',
        );
        $sExpect = $sResponse = $oTestObject->_fcpoGetInsterestHiddenFields('someKey', $aMockInstallment);

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetInsterestMonthDetail coverage
     */
    public function test__fcpoGetInsterestMonthDetail_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');

        $oMockLang = $this->getMock('oxLang', array('translateString'));
        $oMockLang
            ->expects($this->any())
            ->method('translateString')
            ->will($this->returnValue('someTranslatedString'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetLang')
            ->will($this->returnValue($oMockLang));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $aMockRatesDetails = array(
            'Due'=>'',
            'Amount'=>'',
            'Currency'=>'',
        );
        $sExpect = $sResponse = $oTestObject->_fcpoGetInsterestMonthDetail('someMonth', $aMockRatesDetails);

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetInsterestRadio for coverage
     */
    public function test__fcpoGetInsterestRadio_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');
        $sExpect = $sResponse = $oTestObject->_fcpoGetInsterestRadio('someKey');

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetInsterestLabel for coverage
     */
    public function test__fcpoGetInsterestLabel_Coverage() {
        $oTestObject = $this->getMock('fcpayone_ajax', array('_fcpoGetInsterestCaption'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetInsterestCaption')
            ->will($this->returnValue('someCaption'));

        $aMockInstallmentData = array('some', 'data');
        $sExpect = $sResponse = $oTestObject->_fcpoGetInsterestLabel('someKey', $aMockInstallmentData);

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetInsterestCaption for coverage
     */
    public function test__fcpoGetInsterestCaption_Coverage() {
        $oTestObject = oxNew('fcpayone_ajax');

        $oMockLang = $this->getMock('oxLang', array('translateString'));
        $oMockLang
            ->expects($this->any())
            ->method('translateString')
            ->will($this->returnValue('someTranslatedString'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper
            ->expects($this->any())
            ->method('fcpoGetLang')
            ->will($this->returnValue($oMockLang));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $aMockInstallment = array(
            'Amount'=>'199.99',
            'Duration'=>'',
            'EffectiveInterestRate'=>'',
            'InterestRate'=>'',
            'TotalAmount'=>'',
        );
        $sExpect = $sResponse = $oTestObject->_fcpoGetInsterestCaption($aMockInstallment);

        $this->assertEquals($sExpect, $sResponse);

    }
}