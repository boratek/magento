<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 4/24/14
 * Time: 10:13 AM
 */

class Hatimeria_Info_Block_Homepage_News extends Mage_Catalog_Block_Product_New
{
    /**
     * Get method to display products: grid (1) or list (0)
     *
     * @return string
     */

    public function getDisplayMethod()
    {
        $result = Mage::getStoreConfig('hinfo/hinfo/enabled');

        return $result;
    }
}