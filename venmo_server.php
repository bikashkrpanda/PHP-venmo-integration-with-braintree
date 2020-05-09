<?php
require_once ('braintree-php-3.30.0/lib/Braintree.php');

  $gateway = new Braintree_Gateway([
  'environment' => 'sandbox',
  'merchantId' => 'merchantId_tdfnbtb',
  'publicKey' => 'publicKey_j59gdqz',
  'privateKey' => 'privateKey_bd4e0f15b13fe6d22399f2'
  ]);
    
  $result_venmo = $gateway->transaction()->sale([
    'amount' => $_GET['amount'],
    'paymentMethodNonce' => $_GET['payerID'],
    'options' => [
        'submitForSettlement' => true,
        'venmo' => [
          'profileId' => ''
        ]
    ],
    'deviceData' => urldecode($_GET['deviceData'])
  ]);

echo "Transaction ID:".$paymentID = $result_venmo->transaction->id;

?>
