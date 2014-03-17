<?php
class eComCharge_QueryByUidTest extends UnitTestCase {
  public function test_setUid() {
    $q = $this->getTestObjectInstance();

    $q->setUid('123456');

    $this->assertEqual($q->getUid(), '123456');
  }

  public function test_endpoint() {

    $q = $this->getTestObjectInstance();
    $q->setUid('1234');

    $reflection = new ReflectionClass('eComCharge_QueryByUid');
    $method = $reflection->getMethod('endpoint');
    $method->setAccessible(true);
    $url = $method->invoke($q, 'endpoint');

    $this->assertEqual($url, 'https://processing.ecomcharge.com/transactions/1234');

  }

  public function test_query_request() {
    $amount = rand(0,10000);

    $parent = $this->runParentTransaction($amount);

    $q = $this->getTestObjectInstance();

    $q->setUid($parent->getUid());

    $response = $q->submit();

    $this->assertTrue($response->is_valid());
    $this->assertTrue($response->is_success());
    $this->assertNotNull($response->getUid());
    $this->assertEqual($parent->getUid(), $response->getUid());
  }

  public function test_query_response_for_unknown_uid() {
    $q = $this->getTestObjectInstance();

    $q->setUid('1234567890qwerty');

    $response = $q->submit();

    $this->assertTrue($response->is_valid());

    $this->assertEqual($response->getMessage(), 'Record not found');
  }

  protected function runParentTransaction($amount = 10.00 ) {
    authorizeFromEnv();

    $transaction = new eComCharge_Payment(eComCharge_TestData::getShopId(), eComCharge_TestData::getShopKey());

    $transaction->money->setAmount($amount);
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

    return $transaction->submit();
  }

  protected function getTestObjectInstance() {
    authorizeFromEnv();

    $id = eComCharge_TestData::getShopId();
    $key =  eComCharge_TestData::getShopKey();

    return new eComCharge_QueryByUid($id, $key);
  }
}
?>
