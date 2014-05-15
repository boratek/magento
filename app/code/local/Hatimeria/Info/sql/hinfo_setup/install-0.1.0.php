<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'hatimeria/person'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('hinfo/person'))
    ->addColumn('person_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Block ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 16, array(
        'nullable'  => false,
    ), 'Block Title')
    ->addColumn('lastname', Varien_Db_Ddl_Table::TYPE_VARCHAR, 16, array(
        'nullable'  => false,
    ), 'Block String Identifier')
    ->setComment('Hatimeria Person Block Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();