<?php
class eComCharge_CreditTest extends UnitTestCase {

 public function test_setDescription() {

    $auth = $this->getTestObjectInstance();

    $description = 'Test description';

    $auth->setDescription($description);

    $this->assertEqual($auth->getDescription(), $description);
  }

  public function test_setTrackingId() {

    $auth = $this->getTestObjectInstance();

    $tracking_id = 'Test tracking_id';

    $auth->setTrackingId($tracking_id);
    $this->assertEqual($auth->getTrackingId(), $tracking_id);
  }

  public function test_build_request_message() {
    $transaction = $this->getTestObject();
    $arr = array(
      'request' => array(
        'amount' => 1256,
        'currency' => 'RUB',
        'description' => 'description',
        'tracking_id' => 'tracking',
        'credit_card' => array(
          'token' => '12345'
        )
      )
    );

    $reflection = new ReflectionClass( 'eComCharge_Credit' );
    $method = $reflection->getMethod('build_request_message');
    $method->setAccessible(true);

    $request = $method->invoke($transaction, 'build_request_message');

    $this->assertEqual($arr, $request);
  }

  public function test_endpoint() {

    $auth = $this->getTestObjectInstance();

    $reflection = new ReflectionClass('eComCharge_Credit');
    $method = $reflection->getMethod('endpoint');
    $method->setAccessible(true);
    $url = $method->invoke($auth, 'endpoint');

    $this->assertEqual($url, 'https://processing.ecomcharge.com/transactions/credits');

  }

  public function test_success_request() {

    $amount = rand(0,10000);

    $parent = $this->runParentTransaction($amount);

    $transaction = $this->getTestObjectInstance();

    $transaction->money->setAmount($amount * 2);
    $transaction->money->setCurrency('EUR');
    $transaction->setDescription('test description');
    $transaction->setTrackingId('tracking_id');
    $transaction->card->setCardToken($parent->getResponse()->transaction->credit_card->token);

    $t_response = $transaction->submit();

    $this->assertTrue($t_response->is_valid());
    $this->assertTrue($t_response->is_success());
    $this->assertNotNull($t_response->getUid());
    $this->assertEqual($t_response->getMessage(),'Successfully processed');

  }

  public function test_error_request() {
    $amount = rand(0,10000);

    $parent = $this->runParentTransaction($amount);

    $transaction = $this->getTestObjectInstance();

    $transaction->money->setAmount($amount * 2);
    $transaction->money->setCurrency('EUR');
    $transaction->setDescription('test description');
    $transaction->setTrackingId('tracking_id');
    $transaction->card->setCardToken('12345');

    $t_response = $transaction->submit();

    $this->assertTrue($t_response->is_valid());
    $this->assertTrue($t_response->is_error());
    $this->assertTrue(preg_match('/Reason can\'t be blank./', $t_response->getMessage()));

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

  protected function getTestObject() {
    $transaction = $this->getTestObjectInstance();

    $transaction->money->setAmount(12.56);
    $transaction->money->setCurrency('RUB');
    $transaction->card->setCardToken('12345');
    $transaction->setDescription('description');
    $transaction->setTrackingId('tracking');

    return $transaction;

  }

  protected function getTestObjectInstance() {
    authorizeFromEnv();

    $id = eComCharge_TestData::getShopId();
    $key =  eComCharge_TestData::getShopKey();

    return new eComCharge_Credit($id, $key);
  }
}
?>


