<?php
class eComCharge_PaymentTest extends eComCharge_AuthorizationTest {

  public function test_endpoint() {

    $auth = $this->getTestObjectInstance();

    $reflection = new ReflectionClass('eComCharge_Payment');
    $method = $reflection->getMethod('endpoint');
    $method->setAccessible(true);
    $url = $method->invoke($auth, 'endpoint');

    $this->assertEqual($url, 'https://processing.ecomcharge.com/transactions/payments');

  }

  public function test_build_request_message() {
    $auth = $this->getTestObject();
    $arr = array(
      'request' => array(
        'amount' => 1233,
        'currency' => 'EUR',
        'description' => 'test',
        'tracking_id' => 'my_custom_variable',
        'notification_url' => '',
        'return_url' => '',
        'credit_card' => array(
          'number' => '4200000000000000',
          'verification_value' => '123',
          'holder' => 'John Doe',
          'exp_month' => '01',
          'exp_year' => '2030',
          'token' => '',
          'skip_three_d_secure_verification' => '',
        ),

        'customer' => array(
          'ip' => '127.0.0.1',
          'email' => 'john@example.com',
        ),

        'billing_address' => array(
          'first_name' => 'John',
          'last_name' => 'Doe',
          'country' => 'LV',
          'city' => 'Riga',
          'state' => '',
          'zip' => 'LV-1082',
          'address' => 'Demo str 12',
          'phone' => ''
        )
      )
    );

    $reflection = new ReflectionClass( 'eComCharge_Payment');
    $method = $reflection->getMethod('build_request_message');
    $method->setAccessible(true);

    $request = $method->invoke($auth, 'build_request_message');

    $this->assertEqual($arr, $request);
  }


  public function test_failed_request() {
    $auth = $this->getTestObject();

    $amount = rand(0,10000) / 100;

    $auth->money->setAmount($amount);
    $cents = $auth->money->getCents();
    $auth->card->setCardExpMonth(10);

    $response = $auth->submit();

    $this->assertTrue($response->is_valid());
    $this->assertTrue($response->is_failed());
    $this->assertEqual($response->getMessage(), 'Payment was declined');
    $this->assertNotNull($response->getUid());
    $this->assertEqual($response->getStatus(), 'failed');
    $this->assertEqual($cents, $response->getResponse()->transaction->amount);

  }

  protected function getTestObjectInstance($threed = false) {
    authorizeFromEnv();

    $id = eComCharge_TestData::getShopId();
    $key =  eComCharge_TestData::getShopKey();

    if ($threed) {
      $id = eComCharge_TestData::getShopId3d();
      $key =  eComCharge_TestData::getShopKey3d();
    }

    return new eComCharge_Payment($id, $key);
  }


}
?>


