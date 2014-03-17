<?php
abstract class eComCharge_ChildTransaction extends eComCharge_Api {
  protected $_parent_uid;
  public $money;

  public function __construct($shop_id,$shop_key) {
    $this->money = new eComCharge_Money();
    parent::__construct($shop_id,$shop_key);
  }

  public function setParentUid($uid) {
    $this->_parent_uid = $uid;
  }

  public function getParentUid() {
    return $this->_parent_uid;
  }

  protected function build_request_message() {
    $request = array(
      'request' => array(
        'parent_uid' => $this->getParentUid(),
        'amount' => $this->money->getCents()
      ),
    );

    eComCharge_Logger::getInstance()->to_log($request, eComCharge_Logger::DEBUG, get_class() . '::' . __FUNCTION__);

    return $request;
  }
}
?>
