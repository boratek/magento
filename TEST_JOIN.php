<?php
//
/**
 * Jak zrobić joina? - 1. -> Model_collection, bo to działanie na bazie
 * 2. jesteś w modelu shipping, więc tylko $this
 * 3. model shipping, więc od razu deklarujesz drugą tabelę: 'ohst' => $this->getTable('ffdxshippingbox/track'))
 * 4. ustalasz identyczne kolumny: 'main_table.shipment_id = ohst.shipment_id'
 * 5. ustawiasz alias, bo obie tabele mają kolumnę id, jako PK, więc byłyby konflikty: array('tracking_id' => 'ohst.id')
 * 6. podajesz warunek dla where: where('track_number = ?', $referenceNumber);
 * 7. echo $collection->getSelect(); - pokaż całe zapytanie
 */

//class FFDX_ShippingBox_Model_Resource_Shipping_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
//{
//    protected function _construct()
//    {
//        $this->_init('ffdxshippingbox/shipping');
//    }
//
//    /**
//     * @param $referenceNumber
//     * @return $this
//     */
//    public function loadByTracking($referenceNumber)
//    {
//        $this->getSelect()
//            ->join(array('ohst' => $this->getTable('ffdxshippingbox/track')), 'main_table.shipment_id = ohst.shipment_id', array('tracking_id' => 'ohst.id'))
//            ->where('track_number = ?', $referenceNumber);
//
//        return $this;
//    }
//}

// echo $collection->getSelect();