<?php
class eComCharge_Money {
  protected $amount;
  protected $currency;

  public function __construct($amount = 0, $currency = 'USD') {
    $this->amount = $amount;
    $this->currency = $currency;
  }

  public function getCents() {
    return (int)($this->amount * $this->currency_multiplyer($this->currency));
  }

  public function setAmount($amount){
    $this->amount = (float)$amount;
  }
  public function getAmount() {
    return (float)$this->amount;
  }

  public function setCurrency($currency){
    $this->currency = $currency;
  }
  public function getCurrency() {
    return $this->currency;
  }

  private function currency_multiplyer($order_currency) {
    //array currency code => mutiplyer
    $exceptions = array(
        'BIF' => 1,
        'BYR' => 1,
        'CLF' => 1,
        'CLP' => 1,
        'CVE' => 1,
        'DJF' => 1,
        'GNF' => 1,
        'IDR' => 1,
        'IQD' => 1,
        'IRR' => 1,
        'ISK' => 1,
        'JPY' => 1,
        'KMF' => 1,
        'KPW' => 1,
        'KRW' => 1,
        'LAK' => 1,
        'LBP' => 1,
        'MMK' => 1,
        'PYG' => 1,
        'RWF' => 1,
        'SLL' => 1,
        'STD' => 1,
        'UYI' => 1,
        'VND' => 1,
        'VUV' => 1,
        'XAF' => 1,
        'XOF' => 1,
        'XPF' => 1,
        'MOP' => 10,
        'BHD' => 1000,
        'JOD' => 1000,
        'KWD' => 1000,
        'LYD' => 1000,
        'OMR' => 1000,
        'TND' => 1000
    );
    $multiplyer = 100; //default value
    foreach ($exceptions as $key => $value) {
        if (($order_currency == $key)) {
            $multiplyer = $value;
            break;
        }
    }
    return $multiplyer;
}
}
?>
