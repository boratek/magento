<?php
/**
 * Created by PhpStorm.
 * User: zbychu
 * Date: 21.06.14
 * Time: 16:19
 */

include(dirname(__DIR__) . '/app/Mage.php');

echo 'Cleaning cache parts... ' ;
try {
    $allTypes = Mage::app()->useCache();
    foreach ($allTypes as $type => $cache) {
        Mage::app()->getCacheInstance()->cleanType($type);
        echo strtoupper($type) . ' ';
    }

    echo '[OK]' . PHP_EOL;

    echo "Cleaning Magento Cache... ";
    Mage::app()->getCacheInstance()->flush();
    Mage::dispatchEvent('adminhtml_cache_flush_all');
    echo '[OK]' . PHP_EOL;

    echo "Cleaning Storage Cache... ";
    Mage::app()->cleanCache();
    Mage::dispatchEvent('adminhtml_cache_flush_system');
    echo '[OK]' . PHP_EOL;

} catch (Exception $e) {
    echo sprintf("[ERROR: %s]", $e->getMessage());
}