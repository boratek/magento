<?php
/**
 * Person Edit
 */
class Hatimeria_News_Block_Adminhtml_Post_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_objectId = 'post_id';
    protected $_blockGroup = 'hnews';

    public function __construct()
    {
        $this->_objectId = 'post_id';
        $this->_controller = 'adminhtml_post';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('hnews')->__('Save'));
        $this->removeButton('delete');

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        if (Mage::registry('ic_post')->getActive()) {
            $this->_addButton('deactivate', array(
                'label'     => Mage::helper('adminhtml')->__('Deactivate'),
                'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/deactivate', array($this->_objectId => $this->getRequest()->getParam($this->_objectId))) . '\')',
                'class'     => 'delete',
            ), -100);
        }

        $this->_formScripts[] = "function saveAndContinueEdit() { editForm.submit($('edit_form').action+'back/edit/'); }";
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('ic_post')->getId()) {
            return Mage::helper('hnews')->__("Edit Post '%s'", $this->htmlEscape(Mage::registry('ic_post')->getName()));
        }
        else {
            return Mage::helper('hnews')->__('New Post');
        }
    }
} 