<?php
class eComCharge_QueryByTrackingId extends eComCharge_Api {
  protected $_tracking_id;

  protected function endpoint() {
    return $this->_service_url . '/tracking_id/' . $this->getTrackingId();
  }
  public function setTrackingId($tracking_id) {
    $this->_tracking_id = $tracking_id;
  }
  public function getTrackingId() {
    return $this->_tracking_id;
  }
  protected function build_request_message() {
    return '';
  }
}
?>
