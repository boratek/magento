<?php
/**
 * Post Container
 */
class Hatimeria_News_Block_Adminhtml_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_blockGroup = 'hnews';

    public function __construct()
    {
        $this->_controller = 'adminhtml_post';
        $this->_headerText = Mage::helper('hnews')->__('Hatimeria News Post');
        $this->_addButtonLabel = Mage::helper('hnews')->__('Add new Post');
        parent::__construct();
    }
} 