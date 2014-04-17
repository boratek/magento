<?php

/**
 * Hatimeria Info index controller
 *
 * @category   Hatimeria
 * @package    Hatimeria_Info
 * @var $this Hatimeria_Info_Block_Homepage_Info
 */

class Hatimeria_Info_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //$this->_redirect('/');

        $this->loadLayout();
        $this->renderLayout();
    }

}
