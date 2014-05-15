<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 4:01 PM
 */

class Hatimeria_News_Model_Post extends Mage_Core_Model_Abstract
{

    protected $_eventPrefix = 'hatimeria_post';

    public function _construct()
    {
        $this->_init('hnews/post');
    }

    public function _prepareCollection()
    {
        $post = Mage::getModel('hnews/post');
        $postresource = $post->getResource();
        $collection = $post->getCollection();
        $collection = Mage::getResourceModel('hnews/post_collection');
        $collection->addAttributeToSelect(array('title', 'description'));
        $collection->addAttributeToSelect('*');

        $post->load(1);

        $collection->addFieldToFilter('title', 10);
        $collection->load();

        return $collection;
    }
}