<?php
/**
 * Created by PhpStorm.
 * User: andrefatchip
 * Date: 07.03.18
 * Time: 14:28
 */

class Unit_fcPayOne_Application_Models_fcpoerrormapping extends OxidTestCase {

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
     * Testing fcpoGetExistingMappings when path is valid
     */
    public function test_fcpoGetExistingMappings_ValidPath() {
        $sMockPathXml = getShopBasePath() . "/modules/fcPayOne/payoneerrors.xml";
        $sMockPathXml = str_replace('//', '/', $sMockPathXml);

        $aMockParsedXml = array('some', 'mappings');

        $oTestObject = $this->getMock('fcpoerrormapping', array('_fcpoGetMappingWhere'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetMappingWhere')
            ->will($this->returnValue('someWhereQueryPart'));

        $aMockRows = array(
            array(
                'oxid'=>'someOxid',
                'fcpo_error_code'=>'someErrorCode',
                'fcpo_lang_id'=>'someLangId',
                'fcpo_mapped_message'=>'someMappedMessage',
            ),
        );

        $oMockDb = $this->getMock('oxDb', array('getAll'));
        $oMockDb->expects($this->any())->method('getAll')->will($this->returnValue($aMockRows));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetDb')->will($this->returnValue($oMockDb));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $oMockMapping = new stdClass();
        $oMockMapping->sOxid = 'someOxid';
        $oMockMapping->sErrorCode = 'someErrorCode';
        $oMockMapping->sLangId = 'someLangId';
        $oMockMapping->sMappedMessage = 'someMappedMessage';
        $aMockMappings[] = $oMockMapping;

        $this->assertEquals($aMockMappings, $oTestObject->fcpoGetExistingMappings());
    }

    /**
     * @expectedException Exception
     */
    public function test_fcpoGetAvailableErrorCodes_Exception() {
        $sMockPathXml = getShopBasePath() . "/payoneerrors.xml";
        $sMockPathXml = str_replace('//', '/', $sMockPathXml);

        $aMockParsedXml = array('some', 'mappings');

        $oTestObject = $this->getMock('fcpoerrormapping', array(
            '_fcpoGetErrorXmlPath',
            '_fcpoParseXml',
        ));

        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetErrorXmlPath')
            ->will($this->returnValue($sMockPathXml));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoParseXml')
            ->will($this->returnValue($aMockParsedXml));

        $this->assertEquals($aMockParsedXml, $oTestObject->fcpoGetAvailableErrorCodes());
    }

    /**
     * Testing fcpoGetAvailableErrorCodes on parsed xml result
     */
    public function test_fcpoGetAvailableErrorCodes_ParsedXml() {
        $sMockPathXml = getShopBasePath() . "/modules/fcPayOne/payoneerrors.xml";
        $sMockPathXml = str_replace('//', '/', $sMockPathXml);

        $aMockParsedXml = array('some', 'mappings');

        $oTestObject = $this->getMock('fcpoerrormapping', array(
            '_fcpoGetErrorXmlPath',
            '_fcpoParseXml',
        ));

        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetErrorXmlPath')
            ->will($this->returnValue($sMockPathXml));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoParseXml')
            ->will($this->returnValue($aMockParsedXml));

        $this->assertEquals($aMockParsedXml, $oTestObject->fcpoGetAvailableErrorCodes());
    }

    /**
     * Testing fcpoUpdateMappings for coverage
     */
    public function test_fcpoUpdateMappings_Coverage() {
        $oMockDb = $this->getMock('oxDb', array('Execute'));
        $oMockDb->expects($this->any())->method('Execute')->will($this->returnValue(null));

        $oTestObject = $this->getMock('fcpoerrormapping', array('_fcpoGetQuery'));
        $oTestObject->expects($this->any())->method('_fcpoGetQuery')->will($this->returnValue('someQuery'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetDb')->will($this->returnValue($oMockDb));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $aMockMappings = array('index1'=>array('some','mappings'));
        $sMockType = 'someType';

        $this->assertEquals(null, $oTestObject->fcpoUpdateMappings($aMockMappings, $sMockType));
    }

    /**
     * Testing fcpoFetchMappedErrorMessage for coverage
     */
    public function test_fcpoFetchMappedErrorMessage_Coverage() {
        $oTestObject = $this->getMock('fcpoerrormapping', array('_fcpoGetSearchQuery'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetSearchQuery')
            ->will($this->returnValue('someSearchQuery'));

        $oMockDb = $this->getMock('oxDb', array('GetOne'));
        $oMockDb->expects($this->any())->method('GetOne')->will($this->returnValue('someMappedMessage'));

        $oMockUBase = $this->getMock('oxUBase', array('getActiveLangAbbr'));
        $oMockUBase
            ->expects($this->any())
            ->method('getActiveLangAbbr')
            ->will($this->returnValue('de'));

        $oLangEntry = new stdClass();
        $oLangEntry->abbr = 'de';
        $oLangEntry->id = 'someId';
        $aMockLangArray = array($oLangEntry);

        $oMockLang = $this->getMock('oxLang', array('getLanguageArray'));
        $oMockLang
            ->expects($this->any())
            ->method('getLanguageArray')
            ->will($this->returnValue($aMockLangArray));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('getFactoryObject')->will($this->returnValue($oMockUBase));
        $oHelper->expects($this->any())->method('fcpoGetLang')->will($this->returnValue($oMockLang));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);
        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $this->assertEquals('someMappedMessage', $oTestObject->fcpoFetchMappedErrorMessage('someErrorCode'));
    }

    /**
     * Testing _fcpoGetErrorXmlPath for coverage
     */
    public function test__fcpoGetErrorXmlPath_Coverage() {
        $oTestObject = oxNew('fcpoerrormapping');
        // always changing
        $sExpect = $sResponse = $oTestObject->_fcpoGetErrorXmlPath('iframe');

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetMappingWhere for coverage
     */
    public function test__fcpoGetMappingWhere_Coverage() {
        $oTestObject = oxNew('fcpoerrormapping');
        $sExpect = "WHERE fcpo_error_type='general'";

        $this->assertEquals($sExpect, $oTestObject->_fcpoGetMappingWhere('general'));
    }

    /**
     * Testing _fcpoParseXml for coverage
     */
    public function test__fcpoParseXml_Coverage() {
        $oTestObject = oxNew('fcpoerrormapping');

        $oMockUBase = $this->getMock('oxUBase', array('getActiveLangAbbr'));
        $oMockUBase
            ->expects($this->any())
            ->method('getActiveLangAbbr')
            ->will($this->returnValue('de'));


        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('getFactoryObject')->will($this->returnValue($oMockUBase));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $oMockXmlEntry = new stdClass();
        $oMockXmlEntry->error_code = 'someErrorCode';
        $oMockXmlEntry->error_message_de = 'someErrorMessage';

        $oMockXml = new stdClass();
        $oMockXml->entry = array($oMockXmlEntry);

        $oMockEntry = new stdClass();
        $oMockEntry->sErrorCode = 'someErrorCode';
        $oMockEntry->sErrorMessage = 'someErrorMessage';

        $aExpect = array($oMockEntry);

        $this->assertEquals($aExpect, $oTestObject->_fcpoParseXml($oMockXml));
    }

    /**
     * Testing _fcpoGetQuery for coverage
     */
    public function test__fcpoGetQuery_Coverage() {
        $oTestObject = $this->getMock('fcpoerrormapping', array('_fcpoGetUpdateQuery'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoGetUpdateQuery')
            ->will($this->returnValue('someUpdateQuery'));

        $oMockDb = $this->getMock('oxDb', array('quote'));
        $oMockDb->expects($this->any())->method('quote')->will($this->returnValue('someId'));

        $oHelper = $this->getMockBuilder('fcpohelper')->disableOriginalConstructor()->getMock();
        $oHelper->expects($this->any())->method('fcpoGetDb')->will($this->returnValue($oMockDb));
        $this->invokeSetAttribute($oTestObject, '_oFcpoHelper', $oHelper);

        $sExpect = "DELETE FROM fcpoerrormapping WHERE oxid = 'someId'";

        $aMockData = array('delete'=>'someStuff');

        $this->assertEquals($sExpect, $oTestObject->_fcpoGetQuery('someId', $aMockData, 'someType'));
    }

    /**
     * Testing _fcpoGetUpdateQuery for coverage
     */
    public function test__fcpoGetUpdateQuery_Coverage() {
        $oTestObject = $this->getMock('fcpoerrormapping', array('_fcpoIsValidNewEntry'));
        $oTestObject
            ->expects($this->any())
            ->method('_fcpoIsValidNewEntry')
            ->will($this->returnValue(true));

        $oMockDb = $this->getMock('oxDb', array('quote'));
        $oMockDb->expects($this->any())->method('quote')->will($this->returnValue('someId'));

        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $aMockData  = array(
            'sErrorCode'=>'someErrorCode',
            'sLangId'=>'someLangId',
            'sMappedMessage'=>'someMappedMessage',
        );

        // simply a query string
        $sExpect = $sResponse = $oTestObject->_fcpoGetUpdateQuery('someId', $aMockData, 'someType');

        $this->assertEquals($sExpect, $sResponse);
    }

    /**
     * Testing _fcpoGetSearchQuery for coverage
     */
    public function test__fcpoGetSearchQuery_Coverage() {
        $oTestObject = oxNew('fcpoerrormapping');
        $oMockDb = $this->getMock('oxDb', array('quote'));
        $oMockDb->expects($this->any())->method('quote')->will($this->returnValue('someId'));

        $sMockErrorCode = 'someErrorCode';
        $sMockLangId = 'someLangId';
        $sExpect = "
            SELECT fcpo_mapped_message FROM fcpoerrormapping 
            WHERE 
            fcpo_error_code = '{$sMockErrorCode}' AND
            fcpo_lang_id = '{$sMockLangId}'
            LIMIT 1
        ";

        $this->invokeSetAttribute($oTestObject, '_oFcpoDb', $oMockDb);

        $this->assertEquals($sExpect, $oTestObject->_fcpoGetSearchQuery($sMockErrorCode, $sMockLangId));
    }

    /**
     * Testing _fcpoIsValidNewEntry for coverage
     */
    public function test__fcpoIsValidNewEntry_Coverage() {
        $oTestObject = oxNew('fcpoerrormapping');
        $sMockMappingId = 'new';
        $sMockErrorCode = 'someErrorCode';
        $sMockLangId  = 'someLangId';
        $sMockMappedMessage = 'someMappedMessage';

        $this->assertEquals(
            true,
            $oTestObject->_fcpoIsValidNewEntry(
                $sMockMappingId,$sMockErrorCode,$sMockLangId, $sMockMappedMessage)
        );
    }

}