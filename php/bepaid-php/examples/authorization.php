<?php

require_once __DIR__ . '/../lib/ecomcharge.php';
require_once __DIR__ . '/test_shop_data.php';

eComCharge_Logger::getInstance()->setLogLevel(eComCharge_Logger::DEBUG);

$transaction = new eComCharge_Authorization(SHOP_ID, SHOP_SECRET_KEY);

$transaction->money->setAmount(12.33);
$transaction->money->setCurrency('EUR');
$transaction->setDescription('test');
$transaction->setTrackingId('my_custom_variable');

$transaction->card->setCardNumber('4200000000000000');
$transaction->card->setCardHolder('John Doe');
$transaction->card->setCardExpMonth(1);
$transaction->card->setCardExpYear(2030);
$transaction->card->setCardCvc('123');

$transaction->customer->setFirstName('John');
$transaction->customer->setLastName('Doe');
$transaction->customer->setCountry('LV');
$transaction->customer->setAddress('Demo str 12');
$transaction->customer->setCity('Riga');
$transaction->customer->setZip('LV-1082');
$transaction->customer->setIp('127.0.0.1');
$transaction->customer->setEmail('john@example.com');


$response = $transaction->submit();

print("Transaction message: " . $response->getMessage() . PHP_EOL);
print("Transaction status: " . $response->getStatus(). PHP_EOL);

if ($response->is_success() || $response->is_failed() ) {
  print("Transaction UID: " . $response->getUid() . PHP_EOL);
}
?>
