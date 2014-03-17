<?php
class eComCharge_QueryByToken extends eComCharge_Api {
  protected $_token;

  protected function endpoint() {
    return $this->_pp_service_url . '/ctp/api/checkouts/' . $this->getToken();
  }
  public function setToken($token) {
    $this->_token = $token;
  }
  public function getToken() {
    return $this->_token;
  }
  protected function build_request_message() {
    return '';
  }

  public function submit() {
    return new eComCharge_ResponseCheckout($this->remote_request());
  }
}
?>
