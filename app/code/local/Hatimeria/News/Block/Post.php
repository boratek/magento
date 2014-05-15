<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 10:13 AM
 */

class Hatimeria_News_Block_Post extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {

    }

    public function getPosts()
    {
        return Mage::getModel('hnews/post')->getCollection();
    }

    public function getFliesPosts()
    {
        $html = $this->getLayout()->createBlock('hnews/post')->toHtml();

        return parent::_prepareLayout();
        //return $html;
        //Mage::getModel('eav/entity_type')->getCollection();

    }
//zwraca blok, którego nazwę podaje się funkcji getBlockHtml()
    public function getHead()
    {
        return $this->getLayout()->createBlock('hnews/post')->getBlockHtml('top.links');
    }

    public function getSth()
    {
        return $this->getLayout()->getBlock('left')->getChild('07894a99ae7ba5ca8853fc1f5d08575f')->toHtml();
            //->createBlock('hinfo/homepage_widget');


    }
}