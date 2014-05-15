<?php
/**
 * Homepage Info
 */

class Hatimeria_Info_Block_Homepage_Widget
    extends Mage_Core_Block_Abstract
    implements Mage_Widget_Block_Inte
{

    protected function _toHtml()
    {
        $pageTitle = '';
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $pageTitle = $headBlock->getTitle();
        }

        $html = 'Widget Test';

        return $html;
    }
}