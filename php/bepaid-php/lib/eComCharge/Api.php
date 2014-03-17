<?php
abstract class eComCharge_Api {
  protected $_shop_id;

  protected $_shop_key;

  protected $_service_url;
  protected $_pp_service_url;

  public function __construct($shop_id, $shop_key) {
    $this->_shop_id = $shop_id;
    $this->_shop_key = $shop_key;

    $this->_service_url = 'https://processing.ecomcharge.com/transactions';
    $this->_pp_service_url = 'https://checkout.ecomcharge.com';
  }

  protected abstract function build_request_message();

  public function submit() {
    return new eComCharge_Response($this->remote_request());
  }

  protected function remote_request() {
    return eComCharge_GatewayTransport::submit( $this->_shop_id, $this->_shop_key, $this->endpoint(), $this->build_request_message() );
  }

  protected function endpoint() {
    return $this->_service_url . '/' . $this->getTransactionType();
  }

  protected function getTransactionType() {
    list($module,$klass) = explode('_', get_class($this));
    $klass = strtolower($klass) . 's';
    return $klass;
  }

}
?>
