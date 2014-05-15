<?php
/**
 * Homepage Info
 */

class Hatimeria_Info_Block_Homepage_Info extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {

    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDateTime()
    {
        $now = new DateTime();

        return $now->format('Y/m/d H:i');

    }



}