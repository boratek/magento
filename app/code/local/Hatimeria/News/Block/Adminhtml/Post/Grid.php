<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/29/14
 * Time: 2:10 PM
 */

class Hatimeria_News_Block_Adminhtml_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('post_grid');
        $this->setDefaultSort('post_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('hnews/post')->getCollection();
        //$collection->onlyMyName();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('post_id', array(
            'header'    => Mage::helper('hnews')->__('post_id'),
            'align'     => 'left',
            'index'     => 'post_id'
        ));

        $this->addColumn('visible', array(
            'header'    => Mage::helper('hnews')->__('active'),
            'align'     => 'left',
            'index'     => 'active'
        ));

        $this->addColumn('author', array(
            'header'    => Mage::helper('hnews')->__('author'),
            'align'     => 'left',
            'index'     => 'author',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('hnews')->__('title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        $this->addColumn('text', array(
            'header'    => Mage::helper('hnews')->__('text'),
            'align'     => 'left',
            'index'     => 'text',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('hinfo')->__('email'),
            'align'     => 'left',
            'index'     => 'email',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('post_id' => $row->getId()));
    }
}