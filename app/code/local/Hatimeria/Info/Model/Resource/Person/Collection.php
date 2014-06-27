<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 4:06 PM
 */


class Hatimeria_Info_Model_Resource_Person_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('hinfo/person');
    }

    public function onlyMyName()
    {
        $this->addFieldToFilter('name', array('neq' => 'zbych'));
    }

    public function toNameHash()
    {
        return $this->_toOptionHash('person_id', 'name');
    }

    public function toOptionArray()
    {
        return $this
            ->addFieldToFilter('is_system', 1)
            ->_toOptionArray('person_id', 'name');
    }
}