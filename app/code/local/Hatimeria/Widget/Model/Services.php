<?php
class Hatimeria_Widget_Model_Services
{
    /**
     * Provide available options as a value/label array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'digg', 'label' => 'Digg'),
            array('value' => 'delicious', 'label' => 'Delicious'),
            array('value' => 'twitter', 'label' => 'Twitter'),
        );
    }
} 