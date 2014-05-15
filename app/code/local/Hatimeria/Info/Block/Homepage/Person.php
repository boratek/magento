<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 10:13 AM
 */

//bloki dziedziczą po blokach

class Hatimeria_Info_Block_Homepage_Person extends Mage_Core_Block_Template
{

    /**
     *
     * @return string
     */

    public function getPersons()
    {
        return Mage::getModel('hinfo/person')->getCollection();
    }

}