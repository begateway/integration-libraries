<?php
abstract class eComCharge_ResponseBase {

  protected $_response;

  public function __construct($message){
    $this->_response = json_decode($message);
  }
  public abstract function is_success();

  public function is_error() {
    if (!is_object($this->getResponse()))
      return true;

    if (isset($this->getResponse()->errors))
      return true;

    if (isset($this->getResponse()->response))
      return true;

    return false;
  }

  public function is_valid() {
    return !($this->_response === false || $this->_response == null);
  }

  public function getResponse() {
    return $this->_response;
  }

}
?>

