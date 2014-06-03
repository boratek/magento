<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 6/2/14
 * Time: 3:00 PM
 */

include(__DIR__ . '/app/Mage.php');

$app = Mage::app();


$callbackUrl = "http://magento.dev/oauth_admin.php";
$temporaryCredentialsRequestUrl = "http://magento.dev/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
$adminAuthorizationUrl = 'http://magento.dev/admin/oauth_authorize';
$accessTokenRequestUrl = 'http://magento.dev/oauth/token';
$apiUrl = 'http://magento.dev/api/rest';
$consumerKey = '3977df3e6666b915e91592a944733eb7';
$consumerSecret = '9d4c72499bb6496506d107427e6dc328';

session_start();
if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
    $_SESSION['state'] = 0;
}
try {
    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
    $oauthClient->enableDebug();

    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
        $_SESSION['state'] = 1;
        header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
        exit;
    } else if ($_SESSION['state'] == 1) {
        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
        $_SESSION['state'] = 2;
        $_SESSION['token'] = $accessToken['oauth_token'];
        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
        header('Location: ' . $callbackUrl);
        exit;
    } else {
        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);
        $resourceUrl = "$apiUrl/products";
        $productData = json_encode(array(
            'type_id'           => 'simple',
            'attribute_set_id'  => 4,
            'sku'               => 'simple' . uniqid(),
            'weight'            => 1,
            'status'            => 1,
            'visibility'        => 4,
            'name'              => 'My Product Name',
            'description'       => 'My Product Description',
            'short_description' => 'My Products Short Description',
            'price'             => 6.99,
            'tax_class_id'      => 0,
        ));
        $headers = array('Content-Type' => 'application/json');
        $oauthClient->fetch($resourceUrl, $productData, OAUTH_HTTP_METHOD_POST, $headers);
        print_r($oauthClient->getLastResponseInfo());
    }
} catch (OAuthException $e) {
    print_r($e);
}


exit(0);