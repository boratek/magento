<?php
/* @var $this Mage_Core_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();
$adapter = $installer->getConnection();

$adapter->addColumn($installer->getTable('hinfo/person'), 'email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array(
    'nullable'  => false,
    'default'   => '',
), 'Entity Type ID');

$installer->endSetup();

