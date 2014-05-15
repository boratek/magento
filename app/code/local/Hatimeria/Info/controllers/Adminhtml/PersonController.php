<?php

/**
 * Hatimeria Person pages controller
 *
 * @category   Hatimeria
 * @package    Hatimeria_Info
 */
class Hatimeria_Info_Adminhtml_PersonController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Hatimeria_Info_Adminhtml_PersonController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('hinfo/person')
            ->_addBreadcrumb(Mage::helper('hinfo')->__('Person Control'), Mage::helper('hinfo')->__('Person Control'))
            ->_addBreadcrumb(Mage::helper('hinfo')->__('Person'), Mage::helper('hinfo')->__('Person'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Info'))->_title($this->__('Person'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Info'))->_title($this->__('Person'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('person_id');
        $model = Mage::getModel('hinfo/person');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hinfo')->__('This entity no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Person'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ic_person', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('hinfo')->__('Edit Person') : Mage::helper('hinfo')->__('New Person'), $id ? Mage::helper('hinfo')->__('Edit Person') : Mage::helper('hinfo')->__('New Person'))
            ->renderLayout();
    }

    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('person_id');
            $model = Mage::getModel('hinfo/person')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hinfo')->__('This entity no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            // init model and set data

            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hinfo')->__('The Person has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('person_id' => $model->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('person_id' => $this->getRequest()->getParam('person_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
}