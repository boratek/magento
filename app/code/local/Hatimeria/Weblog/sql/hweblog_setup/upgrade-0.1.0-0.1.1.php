<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->changeColumn($installer->getTable('hweblog/blogpost'), 'post', 'post', array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'nullable' => false,
            'comment' => 'Blogpost Body'
        )
    );
$installer->endSetup();