<?php
/**
 * Override for Magento's Customer/Customer API V2
 *
 */
class Hatimeria_Info_Model_Customer_Customer_Api_V2 extends Mage_Customer_Model_Customer_Api_V2 {

    public function hinfoItems($filters)
    {
        //let's log a message from here
        Mage::log('Hello from extended API call', null, true, 'success.log');
    }
}