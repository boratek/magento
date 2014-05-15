<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 4:06 PM
 */


class Hatimeria_News_Model_Resource_Post_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('hnews/post');
    }

    public function toTitleHash()
    {
        return $this->_toOptionHash('post_id', 'title');
    }

    public function toOptionArray()
    {
        return $this
            ->addFieldToFilter('is_system', 1)
            ->_toOptionArray('post_id', 'title');
    }
}