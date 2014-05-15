<?php

class Hatimeria_Info_Model_Observer
{
    public function addInfoToProductsCollection(Varien_Event_Observer $observer)
    {

        $collection = $observer->getCollection();

        foreach ($collection as $item){
            $hinfo = $item->getHinfo();
            $html = Mage::app()->getLayout()->createBlock('cms/block')->setBlockId('product_' . $hinfo)->toHtml();
            $item->setBlockInfo($html);
        }
    }

    public function addInfoToProduct(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();

        $hinfo = $product->getHinfo();
        $html = Mage::app()->getLayout()->createBlock('cms/block')->setBlockId('product_' . $hinfo)->toHtml();
                //->getBlockHtml('product_' . $hinfo);
        $product->setBlockInfo($html);
    }

    public function addToTopmenu(Varien_Event_Observer $observer)
    {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $node = new Varien_Data_Tree_Node(array(
            'name'   => 'Categories',
            'id'     => 'categories',
            'url'    => Mage::getUrl(), // point somewhere
        ), 'id', $tree, $menu);
        $menu->addChild($node);

        // Children menu items
        $collection = Mage::getResourceModel('catalog/category_collection')
            ->setStore(Mage::app()->getStore())
            ->addIsActiveFilter()
            ->addNameToResult()
            ->setPageSize(12);

        foreach ($collection as $category) {
            $tree = $node->getTree();
            $data = array(
                'name'   => $category->getName(),
                'id'     => 'category-node-'.$category->getId(),
                'url'    => $category->getUrl(),
            );
            $subNode = new Varien_Data_Tree_Node($data, 'id', $tree, $node);
            $node->addChild($subNode);
        }
    }
}