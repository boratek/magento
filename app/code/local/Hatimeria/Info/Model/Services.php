<?php
class Hatimeria_Info_Model_Services
{
    /**
     * Provide available options as a value/label array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'widget_info', 'label' => 'Test'),
        );
    }
} 