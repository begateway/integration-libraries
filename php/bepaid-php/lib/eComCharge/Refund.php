<?php
class eComCharge_Refund extends eComCharge_ChildTransaction {
  protected $_reason;

  public function setReason($reason) {
    $this->_reason = $reason;
  }

  public function getReason() {
    return $this->_reason;
  }

  protected function build_request_message() {
    $request = parent::build_request_message();

    $request['request']['reason'] = $this->getReason();

    return $request;
  }
}
?>
