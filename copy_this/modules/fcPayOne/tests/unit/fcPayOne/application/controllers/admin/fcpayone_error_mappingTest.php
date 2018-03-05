<?php
/**
 * Created by PhpStorm.
 * User: andrefatchip
 * Date: 05.03.18
 * Time: 22:21
 */

class Unit_fcPayOne_Application_Controllers_Admin_fcpayone_error_mapping extends OxidTestCase {
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
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
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
     * Testing getMappings for coverage
     */
    public function test_getMappings_Coverage() {
        $aMockMappings = array('some', 'mappings');

        $oTestObject = $this->getMock('fcpayone_error_mapping', array(
            '_fcpoGetExistingMappings',
            '_fcpoAddNewMapping',
        ));
        $oTestObject
           ->expects($this->any())
           ->method('_fcpoGetExistingMappings')
           ->will($this->returnValue($aMockMappings));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoAddNewMapping')
            ->will($this->returnValue(null));

        $this->assertEquals($aMockMappings, $oTestObject->getMappings());
    }

    /**
     * Testing getMappings for coverage
     */
    public function test_getIframeMappings_Coverage() {
        $aMockMappings = array('some', 'iframemappings');

        $oTestObject = $this->getMock('fcpayone_error_mapping', array(
            '_fcpoGetExistingIframeMappings',
            '_fcpoAddNewIframeMapping',
        ));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetExistingMappings')
            ->will($this->returnValue($aMockMappings));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoAddNewMapping')
            ->will($this->returnValue(null));

        $this->assertEquals($aMockMappings, $oTestObject->getIframeMappings());
    }

    /**
     * Testing fcpoGetPayoneErrorMessages for coverage
     */
    public function test_fcpoGetPayoneErrorMessages_Coverage() {
        $oTestObject = oxNew('fcpayone_error_mapping');
        $aMockErrorCodes = array('some', 'error', 'codes');

        $oErrorMapping = $this->getMockBuilder('fcpoerrormapping')->disableOriginalConstructor()->getMock();
        $oErrorMapping->expects($this->any())->method('fcpoGetAvailableErrorCodes')->will($this->returnValue($aMockErrorCodes));
        $this->invokeSetAttribute($oTestObject, '_oFcpoErrorMapping', $oErrorMapping);

        $this->assertEquals($aMockErrorCodes, $oTestObject->fcpoGetPayoneErrorMessages());
    }

    /**
     * Testing getLanguages for coverage
     */
    public function test_getLanguages_Coverage() {
        $oTestObject = oxNew('fcpayone_error_mapping');
        $aMockLangArray = array('someLanguage', 'someOtherLanguage');
        $oMockLang = $this->getMock('oxLang', array('getLanguageArray'));
        $oMockLang->expects($this->any())->method('getLanguageArray')->will($this->returnValue($aMockLangArray));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetLang')->will($this->returnValue($oMockLang));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals($aMockLangArray, $oTestObject->getLanguages());
    }

    /**
     * Testiong fcpoAddNewMapping for coverage
     */
    public function test_fcpoAddNewMapping_Coverage() {
        $oTestObject = oxNew('fcpayone_error_mapping');

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetRequestParameter')->will($this->returnValue('1'));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $oExpect = new stdClass();
        $oExpect->sOxid = 'new';
        $oExpect->sErrorCode = '';
        $oExpect->sMappedMessage = '';
        $oExpect->sLangId = '';
        $aExpect[] = $oExpect;

        $aMockExistingMappings = array();

        $this->assertEquals($aExpect, $oTestObject->fcpoAddNewMapping($aMockExistingMappings));
    }

    /**
     * Testiong _fcpoAddNewIframeMapping for coverage
     */
    public function test__fcpoAddNewIframeMapping_Coverage() {
        $oTestObject = oxNew('fcpayone_error_mapping');

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetRequestParameter')->will($this->returnValue('1'));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $oExpect = new stdClass();
        $oExpect->sOxid = 'new';
        $oExpect->sErrorCode = '';
        $oExpect->sMappedMessage = '';
        $oExpect->sLangId = '';
        $aExpect[] = $oExpect;
        $aMockExistingMappings = array();

        $this->assertEquals($aExpect, $oTestObject->_fcpoAddNewIframeMapping($aMockExistingMappings));
    }

    /**
     * Testing _fcpoGetExistingMappings for coverage
     */
    public function test__fcpoGetExistingMappings_Coverage() {
        $oTestObject = oxNew('fcpayone_error_mapping');

        $aMockMappings = array('some', 'mappings');
        $oErrorMapping = $this->getMockBuilder('fcpoerrormapping')->disableOriginalConstructor()->getMock();
        $oErrorMapping->expects($this->any())->method('fcpoGetExistingMappings')->will($this->returnValue($aMockMappings));
        $this->invokeSetAttribute($oTestObject, '_oFcpoErrorMapping', $oErrorMapping);

        $this->assertEquals($aMockMappings, $oTestObject->_fcpoGetExistingMappings());
    }

    /**
     * Testing _fcpoGetExistingIframeMappings for coverage
     */
    public function test__fcpoGetExistingIframeMappings_Coverage() {
        $oTestObject = oxNew('fcpayone_error_mapping');

        $aMockMappings = array('some', 'mappings');
        $oErrorMapping = $this->getMockBuilder('fcpoerrormapping')->disableOriginalConstructor()->getMock();
        $oErrorMapping->expects($this->any())->method('fcpoGetExistingMappings')->will($this->returnValue($aMockMappings));
        $this->invokeSetAttribute($oTestObject, '_oFcpoErrorMapping', $oErrorMapping);

        $this->assertEquals($aMockMappings, $oTestObject->_fcpoGetExistingIframeMappings());
    }

    /**
     * Testing save for coverage
     */
    public function test_save_Coverage() {
        $oMockErrorMapping = $this->getMock('fcpoerrormapping', array('fcpoUpdateMappings'));
        $oMockErrorMapping->expects($this->any())->method('fcpoUpdateMappings')->will($this->returnValue(null));

        $oTestObject = $this->getMock('fcpayone_error_mapping', array('fcpoGetInstance'));
        $oTestObject->expects($this->any())->method('fcpoGetInstance')->will($this->returnValue($oMockErrorMapping));

        $aMockGeneralMappings = array('some', 'general', 'mappings');

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetRequestParameter')->will($this->returnValue($aMockGeneralMappings));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(null, $oTestObject->save());
    }

    /**
     * Testing saveIframe for coverage
     */
    public function test_saveIframe_Coverage() {
        $oMockErrorMapping = $this->getMock('fcpoerrormapping', array('fcpoUpdateMappings'));
        $oMockErrorMapping->expects($this->any())->method('fcpoUpdateMappings')->will($this->returnValue(null));

        $oTestObject = $this->getMock('fcpayone_error_mapping', array('fcpoGetInstance'));
        $oTestObject->expects($this->any())->method('fcpoGetInstance')->will($this->returnValue($oMockErrorMapping));

        $aMockGeneralMappings = array('some', 'general', 'mappings');

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetRequestParameter')->will($this->returnValue($aMockGeneralMappings));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $this->assertEquals(null, $oTestObject->saveIframe());
    }
}