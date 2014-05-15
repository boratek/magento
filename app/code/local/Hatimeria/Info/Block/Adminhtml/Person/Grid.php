<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/29/14
 * Time: 2:10 PM
 */

class Hatimeria_Info_Block_Adminhtml_Person_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('person_grid');
        $this->setDefaultSort('person_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('hinfo/person')->getCollection();
        $collection->onlyMyName();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('person_id', array(
            'header'    => Mage::helper('hinfo')->__('person_id'),
            'align'     => 'left',
            'index'     => 'person_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('hinfo')->__('name'),
            'align'     => 'left',
            'index'     => 'name'
        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('hinfo')->__('lastname'),
            'align'     => 'left',
            'index'     => 'lastname',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('hinfo')->__('email'),
            'align'     => 'left',
            'index'     => 'email',
        ));

        $this->addColumn('enable', array(
            'header'    => Mage::helper('hinfo')->__('active'),
            'align'     => 'left',
            'index'     => 'active',
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
        return $this->getUrl('*/*/edit', array('person_id' => $row->getId()));
    }
}