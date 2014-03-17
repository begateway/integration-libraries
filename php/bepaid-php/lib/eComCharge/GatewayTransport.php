<?php
class eComCharge_GatewayTransport {

    public static function submit($shop_id, $shop_key, $host, $t_request) {

        $process = curl_init($host);
        $json = json_encode($t_request);

        eComCharge_Logger::getInstance()->to_log("Request to $host", eComCharge_Logger::DEBUG, get_class() );
        eComCharge_Logger::getInstance()->to_log("with Shop Id $shop_id & Shop key $shop_key", eComCharge_Logger::DEBUG, get_class() );
        eComCharge_Logger::getInstance()->to_log("with message" .  $json, eComCharge_Logger::DEBUG, get_class());

        if (!empty($t_request)) {
          curl_setopt($process, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-type: application/json'));
          curl_setopt($process, CURLOPT_POST, 1);
          curl_setopt($process, CURLOPT_POSTFIELDS, $json);
        }
        curl_setopt($process, CURLOPT_URL, $host);
        curl_setopt($process, CURLOPT_USERPWD, $shop_id . ":" . $shop_key);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($process);
        $error = curl_error($process);
        curl_close($process);

        if ($response === false) {
          throw new Exception("cURL error " . $error);
        }

        eComCharge_Logger::getInstance()->to_log("Response $response", eComCharge_Logger::DEBUG, get_class() );
        return $response;
    }
}
?>
