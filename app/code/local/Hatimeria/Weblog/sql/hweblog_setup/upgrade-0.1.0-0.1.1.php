<?php

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()->newTable($installer->getTable('weblog/blogpost'))
    ->addColumn('blogpost_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
    ), 'Blogpost ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Blogpost Title')
    ->addColumn('post', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ), 'Blogpost Body')
    ->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
    ), 'Blogpost Date')
    ->addColumn('timestamp', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Timestamp')
    ->setComment('Magentotutorial weblog/blogpost entity table');
$installer->getConnection()->createTable($table);

$installer->endSetup();