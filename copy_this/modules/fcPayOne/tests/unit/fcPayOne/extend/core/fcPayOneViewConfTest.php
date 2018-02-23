<?php
/** 
 * PAYONE OXID Connector is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PAYONE OXID Connector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PAYONE OXID Connector.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.payone.de
 * @copyright (C) Payone GmbH
 * @version   OXID eShop CE
 */
 
 
class Unit_fcPayOne_Extend_Core_fcPayOneViewConf extends OxidTestCase {

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     * @return mixed Method return.
     * @throws exception
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
     * @return mixed Method return.
     * @throws exception
     */
    public function invokeSetAttribute(&$object, $propertyName, $value) {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue($object, $value);
    }
    
    
    /**
     * Testing fcpoGetModulePath for coverage
     */
    public function test_fcpoGetModulePath_Coverage() {
        $oTestObject = $this->getMock('fcPayOneViewConf', array('getModulePath'));
        $oTestObject->expects($this->any())->method('getModulePath')->will($this->returnValue('someValue'));

        $this->assertEquals('someValue', $oTestObject->fcpoGetModulePath());
    }

    /**
     * Testing fcpoGetModuleUrl for coverage
     */
    public function test_fcpoGetModuleUrl_Coverage() {
        $oTestObject = $this->getMock('fcPayOneViewConf', array('getModuleUrl'));
        $oTestObject->expects($this->any())->method('getModuleUrl')->will($this->returnValue('someValue'));

        $this->assertEquals('someValue', $oTestObject->fcpoGetModuleUrl());
    }

    /**
     * Testing fcpoGetAdminModuleImgUrl for coverage
     */
    public function test_fcpoGetAdminModuleImgUrl_Coverage() {
        $oTestObject = $this->getMock('fcPayOneViewConf', array('fcpoGetModuleUrl'));
        $oTestObject->expects($this->any())->method('fcpoGetModuleUrl')->will($this->returnValue('someValue/'));

        $this->assertEquals('someValue/out/admin/img/', $oTestObject->fcpoGetAdminModuleImgUrl());
    }

    /**
     * Testing fcpoGetAbsModuleJsPath for coverage
     */
    public function test_fcpoGetAbsModuleJsPath_Coverage() {
        $sMockFile = 'someFile';
        $oTestObject = $this->getMock('fcPayOneViewConf', array('fcpoGetModulePath'));
        $oTestObject->expects($this->any())->method('fcpoGetModulePath')->will($this->returnValue('someValue/'));

        $this->assertEquals('someValue/out/src/js/someFile', $oTestObject->fcpoGetAbsModuleJsPath($sMockFile));
    }

    /**
     * Testing fcpoGetModuleJsPath for coverage
     */
    public function test_fcpoGetModuleJsPath_Coverage() {
        $sMockFile = 'someFile';
        $oTestObject = $this->getMock('fcPayOneViewConf', array('fcpoGetModuleUrl'));
        $oTestObject->expects($this->any())->method('fcpoGetModuleUrl')->will($this->returnValue('someValue/'));

        $this->assertEquals('someValue/out/src/js/someFile', $oTestObject->fcpoGetModuleJsPath($sMockFile));
    }

    /**
     * Testing fcpoGetIntShopVersion for coverage
     */
    public function test_fcpoGetIntShopVersion_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetIntShopVersion')->will($this->returnValue(4800));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(4800, $oTestObject->fcpoGetIntShopVersion());
    }

    /**
     * Testing fcpoGetModuleCssPath for coverage
     */
    public function test_fcpoGetModuleCssPath_Coverage() {
        $sMockFile = 'someFile';
        $oTestObject = $this->getMock('fcPayOneViewConf', array('fcpoGetModuleUrl'));
        $oTestObject->expects($this->any())->method('fcpoGetModuleUrl')->will($this->returnValue('http://example.org/modules/'));

        $this->assertEquals('http://example.org/modules/out/src/css/someFile', $oTestObject->fcpoGetModuleCssPath($sMockFile));
    }
    
    /**
     * Testing fcpoGetAbsModuleTemplateFrontendPath for coverage
     */
    public function test_fcpoGetAbsModuleTemplateFrontendPath_Coverage() {
        $sMockFile = 'someFile';
        $oTestObject = $this->getMock('fcPayOneViewConf', array('fcpoGetModulePath'));
        $oTestObject->expects($this->any())->method('fcpoGetModulePath')->will($this->returnValue('someValue/'));

        $this->assertEquals('someValue/application/views/frontend/tpl/someFile', $oTestObject->fcpoGetAbsModuleTemplateFrontendPath($sMockFile));
    }
    
    /**
     * Testing fcpoGetHostedPayoneJs for coverage
     */
    public function test_fcpoGetHostedPayoneJs_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $this->assertEquals('https://secure.pay1.de/client-api/js/v1/payone_hosted_min.js', $oTestObject->fcpoGetHostedPayoneJs());
    }


    /**
     * Testsing fcpoGetIframeMappings for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetIframeMappings_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $aExistingMappings = array('mapping1', 'mapping2');
        $oMockErrorMapping = $this->getMock('fcpoerrormapping', array('fcpoGetExistingMappings'));
        $oMockErrorMapping->expects($this->any())->method('fcpoGetExistingMappings')->will($this->returnValue($aExistingMappings));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('getFactoryObject')->will($this->returnValue($oMockErrorMapping));

        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals($aExistingMappings, $oTestObject->fcpoGetIframeMappings());
    }

    /**
     * Testsing fcpoGetLangAbbrById for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetLangAbbrById_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockLang = $this->getMock('oxLang', array('getLanguageAbbr'));
        $oMockLang->expects($this->any())->method('getLanguageAbbr')->will($this->returnValue('de'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetLang')->will($this->returnValue($oMockLang));

        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals('de', $oTestObject->fcpoGetLangAbbrById('someId'));
    }


    /**
     * Returns if amazonpay is active and though button can be displayed
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoCanDisplayAmazonPayButton_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockPayment = $this->getMock('oxPayment', array('load'));
        $oMockPayment->expects($this->any())->method('load')->will($this->returnValue(true));
        $oMockPayment->oxpayments__oxactive = new oxField('1');

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('getFactoryObject')->will($this->returnValue($oMockPayment));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(true, $oTestObject->fcpoCanDisplayAmazonPayButton());
    }

    /**
     * Testing fcpoGetAmazonWidgetsUrl for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetAmazonWidgetsUrl_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockPayment = $this->getMock('oxPayment', array('load'));
        $oMockPayment->expects($this->any())->method('load')->will($this->returnValue(true));
        $oMockPayment->oxpayments__fcpolivemode = new oxField('1');

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('getFactoryObject')->will($this->returnValue($oMockPayment));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $sExpect = 'https://static-eu.payments-amazon.com/OffAmazonPayments/eur/lpa/js/Widgets.js';

        $this->assertEquals($sExpect, $oTestObject->fcpoGetAmazonWidgetsUrl());
    }

    /**
     * Testing fcpoGetAmazonPayClientId for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetAmazonPayClientId_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockConfig = $this->getMock('oxConfig', array('getConfigParam'));
        $oMockConfig->expects($this->any())->method('getConfigParam')->will($this->returnValue('someClientId'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetConfig')->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals('someClientId', $oTestObject->fcpoGetAmazonPayClientId());
    }

    /**
     * Testing fcpoGetAmazonPaySellerId for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetAmazonPaySellerId_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockConfig = $this->getMock('oxConfig', array('getConfigParam'));
        $oMockConfig->expects($this->any())->method('getConfigParam')->will($this->returnValue('someSellerId'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetConfig')->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals('someSellerId', $oTestObject->fcpoGetAmazonPayClientId());
    }

    /**
     * Testing fcpoGetAmazonPayReferenceId or coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetAmazonPayReferenceId_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetSessionVariable')->will($this->returnValue('someReferenceId'));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals('someReferenceId', $oTestObject->fcpoGetAmazonPayReferenceId());
    }

    /**
     * Testing fcpoGetAmazonPayButtonType for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetAmazonPayButtonType_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockConfig = $this->getMock('oxConfig', array('getConfigParam'));
        $oMockConfig->expects($this->any())->method('getConfigParam')->will($this->returnValue('someButtonType'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetConfig')->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals('someButtonType', $oTestObject->fcpoGetAmazonPayButtonType());
    }

    /**
     * Testing fcpoGetAmazonPayButtonColor for coverage
     *
     * @param void
     * @return void
     * @throws exception
     */
    public function test_fcpoGetAmazonPayButtonColor_Coverage() {
        $oTestObject = oxNew('fcPayOneViewConf');
        $oMockConfig = $this->getMock('oxConfig', array('getConfigParam'));
        $oMockConfig->expects($this->any())->method('getConfigParam')->will($this->returnValue('someButtonColor'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetConfig')->will($this->returnValue($oMockConfig));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals('someButtonColor', $oTestObject->fcpoGetAmazonPayButtonType());
    }

}
