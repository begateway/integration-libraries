<?php
class eComCharge_Customer {
  protected $customer_ip;
  protected $customer_email;

  protected $customer_first_name;
  protected $customer_last_name;
  protected $customer_address;
  protected $customer_city;
  protected $customer_country;
  protected $customer_state;
  protected $customer_zip;
  protected $customer_phone;

  public function setIP($ip) {
    $this->customer_ip = $ip;
  }
  public function getIP() {
    return $this->customer_ip;
  }

  public function setEmail($email) {
    $this->customer_email = $email;
  }
  public function getEmail() {
    return $this->customer_email;
  }

  public function setFirstName($first_name) {
    $this->customer_first_name = $first_name;
  }
  public function getFirstName() {
    return $this->customer_first_name;
  }

  public function setLastName($last_name) {
    $this->customer_last_name = $last_name;
  }
  public function getLastName() {
    return $this->customer_last_name;
  }

  public function setAddress($address) {
    $this->customer_address = $address;
  }

  public function getAddress() {
    return $this->customer_address;
  }

  public function setCity($city) {
    $this->customer_city = $city;
  }
  public function getCity() {
    return $this->customer_city;
  }

  public function setCountry($country) {
    $this->customer_country = $country;
  }
  public function getCountry() {
    return $this->customer_country;
  }

  public function setState($state) {
    $this->customer_state = $state;
  }
  public function getState() {
    return (in_array($this->customer_country, array( 'US', 'CA'))) ? $this->customer_state : null;
  }

  public function setZip($zip) {
    $this->customer_zip = $zip;
  }
  public function getZip() {
    return $this->customer_zip;
  }

  public function setPhone($phone) {
    $this->customer_phone = $phone;
  }
  public function getPhone() {
    return $this->customer_phone;
  }
}
