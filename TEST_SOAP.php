<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 5/30/14
 * Time: 10:40 AM
 */

include(__DIR__ . '/app/Mage.php');

$app = Mage::app();

/**
 * @var this Hatimeria_Info_Model_Api_Server_Handler
 */

var_dump($this);

//$api_url_v2 = "http://magento.dev/api/v2_soap/?wsdl=1";
//$username = 'admin';
//$password = 'admin123';
//$cli = new SoapClient($api_url_v2);
////retreive session id from login
//$session_id = $cli->login($username, $password);
////call customer.list method
//$result = $cli->call($session_id, 'customer.list', array(array()));

$proxy = new SoapClient('http://magento.dev/api/soap/?wsdl');

$proxy->startSession();
$sessionId = $proxy->login('admin', 'admin123');

//$resources = $proxy->resources($sessionId);
//print_r($resources) ;
//
////call hinfo_customer.list method
//$hcustomers = $proxy->call($sessionId, 'hinfo_customer.list', array(array()));
//print_r($hcustomers);
//
//$categories = $proxy->call($sessionId, 'catalog_category_attribute.list', array(array()));
//print_r($categories);


//$filters = array(
//    'status' => array( '=' => 1 ),
//    'type_id' => array( '=' => 'simple' ),
//    'sku' => array( 'like' => '013%' ),
//);
//$products = $proxy->call($sessionId, 'catalog_product.list', array($filters));
//print_r($products);
//
//$calls = array(
//    array( 'catalog_product.info', 60 ),
//    array( 'catalog_product.info', 61 ),
//    array( 'catalog_product.info', 62 ),
//);
//$selectedProducts = $proxy->multiCall( $sessionId, $calls );
//print_r($selectedProducts);


$calls = array(
    array( 'catalog_product.list' ),
    array( 'customer.list' ),
    array( 'directory_country.list' ),
);

try {
    $results = $proxy->multiCall( $sessionId, $calls );
} catch (SoapFault $fault) {
    echo $fault->getMessage();
}

var_dump($results);
//$message = 'ok';
//$logFileName = 'soap.log';
//
//Mage::log('Success2');

//data fior new customer
//$newCustomer = array(
//    'firstname'  => 'pete',
//    'lastname'   => 'linz',
//    'email'      => 'petinz@example.com',
//    //for my version of magento (1.3.2.4) you SHOULD NOT
//    // hash the password, as in:
//    // 'password_hash' => 'password'
//    'password_hash'   => md5('pete'),
//    // password hash can be either regular or salted md5:
//    // $hash = md5($password);
//    // $hash = md5($salt.$password).':'.$salt;
//    // both variants are valid
//    'store_id'   => 0,
//    'website_id' => 0
//);

//$orders = $proxy->call($sessionId, 'sales_order.list');
//print_r($orders);
//
//print_r($proxy->call($sessionId, 'core_magento.info'));
//
//if(($postData = file_get_contents('php://input'))) {
//    // DOMDocument
//    $apiDomDocument = new DOMDocument('1.0');
//    //$currentCustomerImploded = implode($currentCustomer);
//    // Remove white space
//    $apiDomDocument->preserveWhiteSpace = false;
//
//    // Format output for logging into file
//    $apiDomDocument->formatOutput = true;
//
//    // Load XML
////$currentCustomerImploded = '<' . $currentCustomerImploded;
//    $apiDomDocument->loadXML($postData);
//
//    if($apiDomDocument->loadXML($postData)) {
//        $this->logMessage($apiDomDocument->saveXML(), 'soap.log');
//    }
//}
//
//$message = print_r($currentCustomer);
//
//function logMessage($message, $logFileName)
//{
//    Mage::log(
//        $message,
//        null,
//        $logFileName
//    );
//}



//$newCustomerId = $proxy->call($sessionId, 'hinfo_customer.create', array($newCustomer));

// Get new customer info
//var_dump($proxy->call($sessionId, 'hinfo_customer.info', $newCustomerId));

// Update customer
//$update = array('firstname'=>'test');
//$proxy->call($sessionId, 'hinfo_customer.update', array(1, $update));
//
//var_dump($proxy->call($sessionId, 'hinfo_customer.info', $currentCustomer));



// Delete customer
//$proxy->call($sessionId, 'customer.delete', $newCustomerId);

//$calatog = $proxy->call($sessionId, 'catalog')
//$result = $proxy->catalogCategoryCurrentStore($sessionId);

exit(0);