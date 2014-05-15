<?php
class Hatimeria_News_Block_Widget
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

    protected function _construct()
    {
        $this->setTemplate('hwidget/news_widget.phtml');

    }

}
