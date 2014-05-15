<?php
/**
 * Person Edit
 */
class Hatimeria_Info_Block_Adminhtml_Person_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_objectId = 'person_id';
    protected $_blockGroup = 'hinfo';

    public function __construct()
    {
        $this->_objectId = 'person_id';
        $this->_controller = 'adminhtml_person';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('hinfo')->__('Save'));
        $this->removeButton('delete');

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        if (Mage::registry('ic_person')->getActive()) {
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
        if (Mage::registry('ic_person')->getId()) {
            return Mage::helper('hinfo')->__("Edit Person '%s'", $this->htmlEscape(Mage::registry('ic_person')->getName()));
        }
        else {
            return Mage::helper('hinfo')->__('New Person');
        }
    }
} 