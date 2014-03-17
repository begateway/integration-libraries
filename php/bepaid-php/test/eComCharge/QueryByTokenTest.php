<?php
class eComCharge_QueryByTokenTest extends UnitTestCase {

  public function test_setToken() {
    $q = $this->getTestObjectInstance();

    $q->setToken('123456');

    $this->assertEqual($q->getToken(), '123456');
  }

  public function test_endpoint() {

    $q = $this->getTestObjectInstance();
    $q->setToken('1234');

    $reflection = new ReflectionClass('eComCharge_QueryByToken');
    $method = $reflection->getMethod('endpoint');
    $method->setAccessible(true);
    $url = $method->invoke($q, 'endpoint');

    $this->assertEqual($url, 'https://checkout.ecomcharge.com/ctp/api/checkouts/1234');

  }

  public function test_query_request() {
    $amount = rand(0,10000);

    $parent = $this->runParentTransaction($amount);

    $q = $this->getTestObjectInstance();

    $q->setToken($parent->getToken());

    $response = $q->submit();

    $this->assertTrue($response->is_valid());
    $this->assertNotNull($response->getToken(), $parent->getToken());

  }

  public function test_query_response_for_unknown_uid() {
    $q = $this->getTestObjectInstance();

    $q->setToken('1234567890qwerty');

    $response = $q->submit();

    $this->assertTrue($response->is_valid());

    $this->assertEqual($response->getMessage(), 'Record not found');
  }

  protected function runParentTransaction($amount = 10.00 ) {
    authorizeFromEnv();

    $transaction = new eComCharge_GetPaymentPageToken(eComCharge_TestData::getShopId(), eComCharge_TestData::getShopKey());

    $url = 'http://www.example.com';

    $transaction->money->setAmount($amount);
    $transaction->money->setCurrency('EUR');
    $transaction->setAuthorizationTransactionType();
    $transaction->setDescription('test');
    $transaction->setTrackingId('my_custom_variable');
    $transaction->setNotificationUrl($url . '/n' );
    $transaction->setCancelUrl($url . '/c' );
    $transaction->setSuccessUrl($url . '/s' );
    $transaction->setDeclineUrl($url . '/d' );
    $transaction->setFailUrl($url . '/f' );

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

    return new eComCharge_QueryByToken($id, $key);
  }
}
?>
