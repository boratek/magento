<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'hnews/post'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('hnews/post'))
    ->addColumn('post_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Block ID')
    ->addColumn('visible', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
    ), 'Block Visibility')
    ->addColumn('author', Varien_Db_Ddl_Table::TYPE_VARCHAR, 16, array(
        'nullable'  => false,
    ), 'Block Author Name')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 16, array(
        'nullable'  => false,
    ), 'Block Title')
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'Block Text')
    ->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ), 'Block Date')
    ->setComment('Hatimeria Post Block Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();