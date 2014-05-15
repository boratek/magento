<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 4:01 PM
 */

class Hatimeria_Info_Model_Person extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('hinfo/person');
    }

    public function getFullName()
    {
        return $this->getName() . ' ' . $this->getLastname() . ' ';
    }

    public function _prepareCollection()
    {
        die('ok _prepareCollection()');
        $person = Mage::getModel('hinfo/person');
        $personresource = $person->getResource();
        $collection = $person->getCollection();
        $collection = Mage::getResourceModel('hinfo/person_collection');
        $collection->addAttributeToSelect(array('name', 'description'));
        $collection->addAttributeToSelect('*');

        $person->load(1);
        $person->getFullName();

        $collection->addFieldToFilter('name', 10);
        $collection->load();

        return $collection;

        foreach($collection as $p) {
            echo $p->getFullName();
        }
    }
} 