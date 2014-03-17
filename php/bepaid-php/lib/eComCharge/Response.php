<?php
class eComCharge_Response extends eComCharge_ResponseBase {

  public function is_success() {
    return $this->getStatus() == 'successful';
  }

  public function is_failed() {
    return $this->getStatus() == 'failed';
  }

  public function is_incomplete() {
    return $this->getStatus() == 'incomplete';
  }

  public function is_test() {
    if (isset($this->getResponse()->transaction))
      return $this->getResponse()->transaction->test == true;

    return false;
  }

  public function getStatus() {
    if (is_object($this->getResponse()) && isset($this->getResponse()->transaction)) {
      return $this->getResponse()->transaction->status;
    }elseif ($this->is_error()) {
      return 'error';
    }
    return false;
  }

  public function getUid() {
    if (is_object($this->getResponse()) && isset($this->getResponse()->transaction)) {
      return $this->getResponse()->transaction->uid;
    }else{
      return false;
    }
  }

  public function getMessage() {

    if (!is_object($this->getResponse())) {
      return false;
    }


    if (isset($this->getResponse()->message)) {

      return $this->getResponse()->message;

    }elseif (isset($this->getResponse()->transaction)) {

      return $this->getResponse()->transaction->message;

    }elseif (is_object($this->getResponse()->response)) {

      return $this->getResponse()->response->message;

    }

    return false;

  }
}
?>

