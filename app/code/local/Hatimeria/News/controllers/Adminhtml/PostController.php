<?php

/**
 * Hatimeria Post pages controller
 *
 * @category   Hatimeria
 * @package    Hatimeria_News
 */
class Hatimeria_News_Adminhtml_PostController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Hatimeria_News_Adminhtml_PostController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('hnews/post')
            ->_addBreadcrumb(Mage::helper('hnews')->__('Post Control'), Mage::helper('hnews')->__('Post Control'))
            ->_addBreadcrumb(Mage::helper('hnews')->__('Post'), Mage::helper('hnews')->__('Post'));



        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('News'))->_title($this->__('Post'));
        $this->loadLayout();
        $h = $this->getLayout()->getAllBlocks();

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('News'))->_title($this->__('Post'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('post_id');
        $model = Mage::getModel('hnews/post');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hnews')->__('This entity no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Post'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ic_post', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('hnews')->__('Edit Post') : Mage::helper('hnews')->__('New Post'),
                $id ? Mage::helper('hnews')->__('Edit Post') : Mage::helper('hnews')->__('New Post'))
            ->renderLayout();
    }

    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('post_id');
            $model = Mage::getModel('hnews/post')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hnews')->__('This entity no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('hnews')->__('The Post has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('post_id' => $model->getId()));
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
                $this->_redirect('*/*/edit', array('post_id' => $this->getRequest()->getParam('post_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
}