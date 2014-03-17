<?
class eComCharge_Card {
  protected $card_number;
  protected $card_holder;
  protected $card_exp_month;
  protected $card_exp_year;
  protected $card_cvc;
  protected $card_token = null;
  protected $card_skip_threed_secure = false;


  public function setCardNumber($number) {
    $this->card_number = $number;
  }
  public function getCardNumber() {
    return $this->card_number;
  }

  public function setCardHolder($holder) {
    $this->card_holder = $holder;
  }
  public function getCardHolder() {
    return $this->card_holder;
  }

  public function setCardExpMonth($exp_month) {
    try {
      $this->card_exp_month = sprintf('%02d', (int)$exp_month);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
  public function getCardExpMonth() {
    return $this->card_exp_month;
  }

  public function setCardExpYear($exp_year) {
    $this->card_exp_year = $exp_year;
  }
  public function getCardExpYear() {
    return $this->card_exp_year;
  }

  public function setCardCvc($cvc) {
    $this->card_cvc = $cvc;
  }
  public function getCardCvc() {
    return $this->card_cvc;
  }

  public function setCardToken($token) {
    $this->card_token = $token;
  }
  public function getCardToken() {
    return $this->card_token;
  }

  public function setSkip3D(bool $skip) {
    $this->card_skip_threed_secure = $skip;
  }
  public function getSkip3D() {
    return $this->card_skip_threed_secure;
  }
}
?>
