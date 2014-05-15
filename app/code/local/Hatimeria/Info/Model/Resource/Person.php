<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 4:01 PM
 */

class Hatimeria_Info_Model_Resource_Person extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Product to website linkage table
     *
     * @var string
     */

    public function _construct()
    {
      $this->_init('hinfo/person', 'person_id');
    }
} 