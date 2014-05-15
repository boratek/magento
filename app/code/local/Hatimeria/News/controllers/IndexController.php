<?php

/**
 * Hatimeria News index controller
 *
 * @category   Hatimeria
 * @package    Hatimeria_News
 */

class Hatimeria_News_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
