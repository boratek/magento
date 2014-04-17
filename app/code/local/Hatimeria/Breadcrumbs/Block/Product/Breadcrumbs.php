<?php
/**
 * Breadcrumbs
 */

class Hatimeria_Breadcrumbs_Block_Product_Breadcrumbs extends Mage_Page_Block_Html_Breadcrumbs
{
    /**
     * Preparing layout
     *
     * @return Mage_Catalog_Block_Breadcrumbs
     */
    protected function _prepareLayout()
    {
        $this->addCrumb('home', array(
            'label'=>Mage::helper('catalog')->__('Home'),
            'title'=>Mage::helper('catalog')->__('Go to Home Page'),
            'link'=>Mage::getBaseUrl()
        ));

        $title = array();
        $path  = Mage::helper('catalog')->getBreadcrumbPath();

        array_pop($path);

        foreach ($path as $name => $breadcrumb) {
            $this->addCrumb($name, $breadcrumb);
            $title[] = $breadcrumb['label'];
        }

        // jak utworzyć w locie i wyrenderować blok:
        // $html = $this->getLayout()->createBlock('hbreadcrumbs/product_breadcrumbs')->toHtml();

        return parent::_prepareLayout();
    }

}