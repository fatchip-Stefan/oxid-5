<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 16.01.18
 * Time: 11:27
 */

class fcpouserflag extends oxBase {

    /**
     * Object core table name
     *
     * @var string
     */
    protected $_sCoreTbl = 'fcpouserflags';

    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'fcpouserflag';

    /**
     * Helper object for dealing with different shop versions
     * @var object
     */
    protected $_oFcpoHelper = null;

    /**
     * Centralized Database instance
     * @var object
     */
    protected $_oFcpoDb = null;

    /**
     * The timestamp that should be used to determine penalty times
     * @var string
     */
    protected $_sTimeStamp = null;

    /**
     * List of blocked paymentids
     * @var array
     */
    protected $_aBlockedPaymentIds = array();

    /**
     * Init needed data
     */
    public function __construct() {
        parent::__construct();
        $this->_oFcpoHelper = oxNew('fcpohelper');
        $this->_oFcpoDb = oxDb::getDb();
        $this->init($this->_sCoreTbl);
    }

    /**
     * Overloaded method to automatically set effects
     *
     * @return mixed
     */
    public function load($sOXID) {
        $mReturn = parent::load($sOXID);
        if ($mReturn !== false) {
            $this->_fcpoSetEffects();
        }

        return $mReturn;
    }

    /**
     * Setter for timestamp of when the user received the flag
     *
     * @param string $sTimeStamp
     * @return void
     */
    public function fcpoSetTimeStamp($sTimeStamp) {
        $this->_sTimeStamp = $sTimeStamp;
    }

    /**
     * Returns an array of paymentids which are currently
     *
     * @param void
     * @return array
     */
    public function fcpoGetBlockedPaymentIds() {
        $aReturn = array();
        $blFlagActive = $this->_fcpoFlagIsActive();

        if ($blFlagActive) {
            $aReturn = $this->_aBlockedPaymentIds;
        }

        return $aReturn;
    }

    /**
     * Returns translation string for current frontend message
     *
     * @param void
     * @return string
     */
    public function fcpoGetFrontendUserMessage() {
        $sEffectCode = $this->fcpouserflags__fcpoeffect->value;
        switch($sEffectCode) {
            case 'RPB':
                // case ratpay payments are blocked
                $sReturn = 'FCPO_MESSAGE_RATEPAY_TEMPORARY_BLOCKED';
        }

        return $sReturn;
    }

    /**
     * Checks if this userflag is active related to timestamp of flag assigment
     * and its set duration. Setting a duration of 0 means infinite active state
     *
     * @param void
     * @return bool
     */
    protected function _fcpoFlagIsActive() {
        $iDurationHours =  $this->fcpouserflags__fcpoflagduration->value;
        $iTimeStampActiveUntil = $this->_fcpoGetTimeStampActiveUntil();
        $iTimeStampNow = time();
        $blReturn = ($iTimeStampActiveUntil >= $iTimeStampNow || $iDurationHours === 0);

        return $blReturn;
    }

    /**
     * Returns the time until flag is active
     *
     * @param void
     * @return int
     */
    protected function _fcpoGetTimeStampActiveUntil() {
        $iDurationHours =  $this->fcpouserflags__fcpoflagduration->value;
        $iTimeStampFlagAssigned = strtotime($this->_sTimeStamp);
        $sTimeStringDuration = '+ '.$iDurationHours.' hours';
        $iTimeStampActiveUntil = strtotime($sTimeStringDuration ,$iTimeStampFlagAssigned);
        $iTimeStampActiveUntil = (int) $iTimeStampActiveUntil;

        return $iTimeStampActiveUntil;
    }

    /**
     * Sets effects by effect-code
     *
     * @param void
     * @return void
     */
    protected function _fcpoSetEffects() {
        $this->_fcpoSetPaymentsBlocked();
    }

    /**
     * Set blocked payments
     *
     * @param void
     * @return void
     */
    protected function _fcpoSetPaymentsBlocked() {
        $sEffectCode = $this->fcpouserflags__fcpoeffect->value;

        switch($sEffectCode) {
            case 'RPR':
                // case ratpay payments are blocked
                $this->_fcpoAddBlockedPayment('fcporp_bill');
                break;
        }
    }

    /**
     * Adds a payment id to blocked payments
     *
     * @param $sPaymentId
     * @return void
     */
    protected function _fcpoAddBlockedPayment($sPaymentId) {
        $this->_aBlockedPaymentIds[] = $sPaymentId;
    }
}