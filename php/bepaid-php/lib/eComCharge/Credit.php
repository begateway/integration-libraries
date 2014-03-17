<?php
class eComCharge_Credit extends eComCharge_Api {
  public $card;
  public $money;
  protected $_description;
  protected $_tracking_id;

  public function __construct($shop_id, $shop_key) {
    $this->money = new eComCharge_Money();
    $this->card = new eComCharge_Card();

    parent::__construct($shop_id, $shop_key);
  }

  public function setDescription($description) {
    $this->_description = $description;
  }
  public function getDescription() {
    return $this->_description;
  }

  public function setTrackingId($tracking_id) {
    $this->_tracking_id = $tracking_id;
  }
  public function getTrackingId() {
    return $this->_tracking_id;
  }

  protected function build_request_message() {
    $request = array(
      'request' => array(
        'amount' => $this->money->getCents(),
        'currency' => $this->money->getCurrency(),
        'description' => $this->getDescription(),
        'tracking_id' => $this->getTrackingId(),
        'credit_card' => array(
          'token' => $this->card->getCardToken(),
        ),
      )
    );

    eComCharge_Logger::getInstance()->to_log($request, eComCharge_Logger::DEBUG, get_class() . '::' . __FUNCTION__);

    return $request;
  }

}
?>

