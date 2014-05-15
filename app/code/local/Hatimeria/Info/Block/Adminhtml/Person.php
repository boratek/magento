<?php
/**
 * Person Container
 */
class Hatimeria_Info_Block_Adminhtml_Person extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_blockGroup = 'hinfo';

    public function __construct()
    {
        $this->_controller = 'adminhtml_person';
        $this->_headerText = Mage::helper('hinfo')->__('Hatimeria Info Person');
        $this->_addButtonLabel = Mage::helper('hinfo')->__('Add new Person');
        parent::__construct();
    }
} 