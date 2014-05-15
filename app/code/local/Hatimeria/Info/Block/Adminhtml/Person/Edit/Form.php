<?php
/**
 * Person Edit Form
 */
class Hatimeria_Info_Block_Adminhtml_Person_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('person_form');
        $this->setTitle(Mage::helper('hinfo')->__('Person'));
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ic_person');
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $form->setHtmlIdPrefix('person_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('hinfo')->__('General Information'),
            'class'     => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField('person_id', 'hidden', array(
                'name'  => 'person_id',
            ));
        }

        $fieldset->addField('active', 'select', array(
            'name'      => 'active',
            'label'     => Mage::helper('hinfo')->__('Active'),
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('hinfo')->__('Enabled'),
                '0' => Mage::helper('hinfo')->__('Disabled'),
            ),
        ));

        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('hinfo')->__('Name'),
            'title'     => Mage::helper('hinfo')->__('Name'),
            'required'  => true,
        ));

        $fieldset->addField('lastname', 'text', array(
            'name'      => 'lastname',
            'label'     => Mage::helper('hinfo')->__('Lastname'),
            'title'     => Mage::helper('hinfo')->__('Lastname'),
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'email',
            'label'     => Mage::helper('hinfo')->__('Email'),
            'title'     => Mage::helper('hinfo')->__('Email'),
            'required'  => true,
        ));




        if (!$model->getId()) {
            $model->setData('active', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
} 