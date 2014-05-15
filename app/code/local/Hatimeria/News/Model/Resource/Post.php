<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 4:01 PM
 */

class Hatimeria_News_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Product to website linkage table
     *
     * @var string
     */

    protected function _construct()
    {
        $this->_init('hnews/post', 'post_id');
    }
} 