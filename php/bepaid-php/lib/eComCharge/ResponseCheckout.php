<?php
class eComCharge_ResponseCheckout extends eComCharge_ResponseBase {

  public function is_success() {
    return is_object($this->getResponse()->checkout);
  }

  public function is_error() {
    return parent::is_error() || $this->getResponse()->checkout->status == 'error';
  }

  public function getMessage() {
    if (isset($this->getResponse()->message)) {
      return $this->getResponse()->message;
    }elseif (isset($this->getResponse()->response) && isset($this->getResponse()->response->message)) {
      return $this->getResponse()->response->message;
    }elseif ($this->is_error()) {
      return $this->compileErrors();
    }else{
      return '';
    }
  }

  public function getToken() {
    return $this->getResponse()->checkout->token;
  }

  private function compileErrors() {
    return 'there are errors in request parameters';
  }

}
?>
