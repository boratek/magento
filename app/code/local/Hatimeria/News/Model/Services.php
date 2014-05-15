<?php
class Hatimeria_News_Model_Services
{
    /**
     * Provide available options as a value/label array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'news', 'label' => 'Test Widget News'),
        );
    }
} 