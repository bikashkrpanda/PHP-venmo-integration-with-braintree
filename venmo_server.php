<?php
require_once ('braintree-php-3.30.0/lib/Braintree.php');

  $gateway = new Braintree_Gateway([
  'environment' => 'sandbox',
  'merchantId' => 'dgg5x66vptdfnbtb',
  'publicKey' => 'kqx2gkjpwj59gdqz',
  'privateKey' => '4ce889ab9cbd4e0f15b13fe6d22399f2'
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