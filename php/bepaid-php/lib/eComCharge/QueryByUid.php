<?php
class eComCharge_QueryByUid extends eComCharge_Api {
  protected $_uid;

  protected function endpoint() {
    return $this->_service_url . '/' . $this->getUid();
  }
  public function setUid($uid) {
    $this->_uid = $uid;
  }
  public function getUid() {
    return $this->_uid;
  }
  protected function build_request_message() {
    return '';
  }
}
?>
