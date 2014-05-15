<?php
/**
 * Post Edit Form
 */
class Hatimeria_News_Block_Adminhtml_Post_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('post_form');
        $this->setTitle(Mage::helper('hnews')->__('Post'));
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ic_post');
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $form->setHtmlIdPrefix('post_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('hnews')->__('General Information'),
            'class'     => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField('post_id', 'hidden', array(
                'name'  => 'post_id',
            ));
        }

        $fieldset->addField('visible', 'select', array(
            'name'      => 'visible',
            'label'     => Mage::helper('hnews')->__('Visible'),
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('hnews')->__('Enabled'),
                '0' => Mage::helper('hnews')->__('Disabled'),
            ),
        ));

        $fieldset->addField('author', 'text', array(
            'name'      => 'author',
            'label'     => Mage::helper('hnews')->__('Author'),
            'title'     => Mage::helper('hnews')->__('Author'),
            'required'  => true,
        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('hnews')->__('Title'),
            'title'     => Mage::helper('hnews')->__('Title'),
            'required'  => true,
        ));

        $fieldset->addField('text', 'text', array(
            'name'      => 'text',
            'label'     => Mage::helper('hnews')->__('Text'),
            'title'     => Mage::helper('hnews')->__('Text'),
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'email',
            'label'     => Mage::helper('hnews')->__('Email'),
            'title'     => Mage::helper('hnews')->__('Email'),
            'required'  => true,
        ));

        $fieldset->addField('date', 'text', array(
            'name'      => 'date',
            'label'     => Mage::helper('hnews')->__('Date'),
            'title'     => Mage::helper('hnews')->__('Date'),
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