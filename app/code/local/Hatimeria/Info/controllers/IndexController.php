<?php

/**
 * Hatimeria Info index controller
 *
 * @category   Hatimeria
 * @package    Hatimeria_Info
 */

class Hatimeria_Info_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function personsAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
