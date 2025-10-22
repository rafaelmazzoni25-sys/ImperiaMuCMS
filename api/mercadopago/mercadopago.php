<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$GLOBALS["LIB_LOCATION"] = dirname(__FILE__);
class MercadoPagoException extends Exception
{
    public function __construct($message, $code = 500, Exception $previous = NULL)
    {
        $this::__construct($message, $code, $previous);
    }
}
class MP
{
    private $client_id = NULL;
    private $client_secret = NULL;
    private $ll_access_token = NULL;
    private $access_data = NULL;
    private $sandbox = false;
    const version = "0.5.3";
    public function __construct()
    {
        $i = func_num_args();
        if (2 < $i || $i < 1) {
            throw new MercadoPagoException("Invalid arguments. Use CLIENT_ID and CLIENT SECRET, or ACCESS_TOKEN");
        }
        if ($i == 1) {
            $this->ll_access_token = func_get_arg(0);
        }
        if ($i == 2) {
            $this->client_id = func_get_arg(0);
            $this->client_secret = func_get_arg(1);
        }
    }
    public function sandbox_mode($enable = NULL)
    {
        if (!is_null($enable)) {
            $this->sandbox = $enable === true;
        }
        return $this->sandbox;
    }
    public function get_access_token()
    {
        if (isset($this->ll_access_token) && !is_null($this->ll_access_token)) {
            return $this->ll_access_token;
        }
        $app_client_values = ["client_id" => $this->client_id, "client_secret" => $this->client_secret, "grant_type" => "client_credentials"];
        $access_data = MPRestClient::post(["uri" => "/oauth/token", "data" => $app_client_values, "headers" => ["content-type" => "application/x-www-form-urlencoded"]]);
        if ($access_data["status"] != 200) {
            throw new MercadoPagoException($access_data["response"]["message"], $access_data["status"]);
        }
        $this->access_data = $access_data["response"];
        return $this->access_data["access_token"];
    }
    public function get_payment($id)
    {
        $uri_prefix = $this->sandbox ? "/sandbox" : "";
        $request = ["uri" => "/v1/payments/" . $id, "params" => ["access_token" => $this->get_access_token()]];
        $payment_info = MPRestClient::get($request);
        return $payment_info;
    }
    public function get_payment_info($id)
    {
        return $this->get_payment($id);
    }
    public function get_authorized_payment($id)
    {
        $request = ["uri" => "/authorized_payments/" . $id, "params" => ["access_token" => $this->get_access_token()]];
        $authorized_payment_info = MPRestClient::get($request);
        return $authorized_payment_info;
    }
    public function refund_payment($id)
    {
        $request = ["uri" => "/v1/payments/" . $id . "/refunds", "params" => ["access_token" => $this->get_access_token()], "data" => []];
        $response = MPRestClient::post($request);
        return $response;
    }
    public function cancel_payment($id)
    {
        $request = ["uri" => "/v1/payments/" . $id, "params" => ["access_token" => $this->get_access_token()], "data" => ["status" => "cancelled"]];
        $response = MPRestClient::put($request);
        return $response;
    }
    public function cancel_preapproval_payment($id)
    {
        $request = ["uri" => "/preapproval/" . $id, "params" => ["access_token" => $this->get_access_token()], "data" => ["status" => "cancelled"]];
        $response = MPRestClient::put($request);
        return $response;
    }
    public function search_payment($filters, $offset = 0, $limit = 0)
    {
        $filters["offset"] = $offset;
        $filters["limit"] = $limit;
        $uri_prefix = $this->sandbox ? "/sandbox" : "";
        $request = ["uri" => "/v1/payments/search", "params" => array_merge($filters, ["access_token" => $this->get_access_token()])];
        $collection_result = MPRestClient::get($request);
        return $collection_result;
    }
    public function create_preference($preference)
    {
        $request = ["uri" => "/checkout/preferences", "params" => ["access_token" => $this->get_access_token()], "data" => $preference];
        $preference_result = MPRestClient::post($request);
        return $preference_result;
    }
    public function update_preference($id, $preference)
    {
        $request = ["uri" => "/checkout/preferences/" . $id, "params" => ["access_token" => $this->get_access_token()], "data" => $preference];
        $preference_result = MPRestClient::put($request);
        return $preference_result;
    }
    public function get_preference($id)
    {
        $request = ["uri" => "/checkout/preferences/" . $id, "params" => ["access_token" => $this->get_access_token()]];
        $preference_result = MPRestClient::get($request);
        return $preference_result;
    }
    public function create_preapproval_payment($preapproval_payment)
    {
        $request = ["uri" => "/preapproval", "params" => ["access_token" => $this->get_access_token()], "data" => $preapproval_payment];
        $preapproval_payment_result = MPRestClient::post($request);
        return $preapproval_payment_result;
    }
    public function get_preapproval_payment($id)
    {
        $request = ["uri" => "/preapproval/" . $id, "params" => ["access_token" => $this->get_access_token()]];
        $preapproval_payment_result = MPRestClient::get($request);
        return $preapproval_payment_result;
    }
    public function update_preapproval_payment($id, $preapproval_payment)
    {
        $request = ["uri" => "/preapproval/" . $id, "params" => ["access_token" => $this->get_access_token()], "data" => $preapproval_payment];
        $preapproval_payment_result = MPRestClient::put($request);
        return $preapproval_payment_result;
    }
    public function get($request, $params = NULL, $authenticate = true)
    {
        if (is_string($request)) {
            $request = ["uri" => $request, "params" => $params, "authenticate" => $authenticate];
        }
        $request["params"] = isset($request["params"]) && is_array($request["params"]) ? $request["params"] : [];
        if (!isset($request["authenticate"]) || $request["authenticate"] !== false) {
            $request["params"]["access_token"] = $this->get_access_token();
        }
        $result = MPRestClient::get($request);
        return $result;
    }
    public function post($request, $data = NULL, $params = NULL)
    {
        if (is_string($request)) {
            $request = ["uri" => $request, "data" => $data, "params" => $params];
        }
        $request["params"] = isset($request["params"]) && is_array($request["params"]) ? $request["params"] : [];
        if (!isset($request["authenticate"]) || $request["authenticate"] !== false) {
            $request["params"]["access_token"] = $this->get_access_token();
        }
        $result = MPRestClient::post($request);
        return $result;
    }
    public function put($request, $data = NULL, $params = NULL)
    {
        if (is_string($request)) {
            $request = ["uri" => $request, "data" => $data, "params" => $params];
        }
        $request["params"] = isset($request["params"]) && is_array($request["params"]) ? $request["params"] : [];
        if (!isset($request["authenticate"]) || $request["authenticate"] !== false) {
            $request["params"]["access_token"] = $this->get_access_token();
        }
        $result = MPRestClient::put($request);
        return $result;
    }
    public function delete($request, $params = NULL)
    {
        if (is_string($request)) {
            $request = ["uri" => $request, "params" => $params];
        }
        $request["params"] = isset($request["params"]) && is_array($request["params"]) ? $request["params"] : [];
        if (!isset($request["authenticate"]) || $request["authenticate"] !== false) {
            $request["params"]["access_token"] = $this->get_access_token();
        }
        $result = MPRestClient::delete($request);
        return $result;
    }
}
class MPRestClient
{
    const API_BASE_URL = "https://api.mercadopago.com";
    private static function build_request($request)
    {
        if (!extension_loaded("curl")) {
            throw new MercadoPagoException("cURL extension not found. You need to enable cURL in your php.ini or another configuration you have.");
        }
        if (!isset($request["method"])) {
            throw new MercadoPagoException("No HTTP METHOD specified");
        }
        if (!isset($request["uri"])) {
            throw new MercadoPagoException("No URI specified");
        }
        $headers = ["accept: application/json"];
        $json_content = true;
        $form_content = false;
        $default_content_type = true;
        if (isset($request["headers"]) && is_array($request["headers"])) {
            foreach ($request["headers"] as $h => $v) {
                $h = strtolower($h);
                $v = strtolower($v);
                if ($h == "content-type") {
                    $default_content_type = false;
                    $json_content = $v == "application/json";
                    $form_content = $v == "application/x-www-form-urlencoded";
                }
                array_push($headers, $h . ": " . $v);
            }
        }
        if ($default_content_type) {
            array_push($headers, "content-type: application/json");
        }
        $connect = curl_init();
        curl_setopt($connect, CURLOPT_USERAGENT, "MercadoPago PHP SDK v0.5.3");
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($connect, CURLOPT_CAINFO, $GLOBALS["LIB_LOCATION"] . "/cacert.pem");
        curl_setopt($connect, CURLOPT_CUSTOMREQUEST, $request["method"]);
        curl_setopt($connect, CURLOPT_HTTPHEADER, $headers);
        if (isset($request["params"]) && is_array($request["params"]) && 0 < count($request["params"])) {
            $easytoyou_decoder_beta_not_finish .= strpos($request["uri"], "?") === false ? "?" : "&";
            $easytoyou_decoder_beta_not_finish .= $this::build_query($request["params"]);
        }
        curl_setopt($connect, CURLOPT_URL, "https://api.mercadopago.com" . $request["uri"]);
        if (isset($request["data"])) {
            if ($json_content) {
                if (gettype($request["data"]) == "string") {
                    json_decode($request["data"], true);
                } else {
                    $request["data"] = json_encode($request["data"]);
                }
                if (function_exists("json_last_error")) {
                    $json_error = json_last_error();
                    if ($json_error != JSON_ERROR_NONE) {
                        throw new MercadoPagoException("JSON Error [" . $json_error . "] - Data: " . $request["data"]);
                    }
                }
            } else {
                if ($form_content) {
                    $request["data"] = $this::build_query($request["data"]);
                }
            }
            curl_setopt($connect, CURLOPT_POSTFIELDS, $request["data"]);
        }
        return $connect;
    }
    private static function exec($request)
    {
        $connect = $this::build_request($request);
        $api_result = curl_exec($connect);
        $api_http_code = curl_getinfo($connect, CURLINFO_HTTP_CODE);
        if ($api_result === false) {
            throw new MercadoPagoException(curl_error($connect));
        }
        $response = ["status" => $api_http_code, "response" => json_decode($api_result, true)];
        if (400 <= $response["status"]) {
            $message = $response["response"]["message"];
            if (isset($response["response"]["cause"])) {
                if (isset($response["response"]["cause"]["code"]) && isset($response["response"]["cause"]["description"])) {
                    $message .= " - " . $response["response"]["cause"]["code"] . ": " . $response["response"]["cause"]["description"];
                } else {
                    if (is_array($response["response"]["cause"])) {
                        foreach ($response["response"]["cause"] as $causes) {
                            if (is_array($causes)) {
                                foreach ($causes as $cause) {
                                    $message .= " - " . $cause["code"] . ": " . $cause["description"];
                                }
                            } else {
                                $message .= " - " . $causes["code"] . ": " . $causes["description"];
                            }
                        }
                    }
                }
            }
            throw new MercadoPagoException($message, $response["status"]);
        }
        curl_close($connect);
        return $response;
    }
    private static function build_query($params)
    {
        if (function_exists("http_build_query")) {
            return http_build_query($params, "", "&");
        }
        foreach ($params as $name => $value) {
            $elements[] = $name . "=" . urlencode($value);
        }
        return implode("&", $elements);
    }
    public static function get($request)
    {
        $request["method"] = "GET";
        return $this::exec($request);
    }
    public static function post($request)
    {
        $request["method"] = "POST";
        return $this::exec($request);
    }
    public static function put($request)
    {
        $request["method"] = "PUT";
        return $this::exec($request);
    }
    public static function delete($request)
    {
        $request["method"] = "DELETE";
        return $this::exec($request);
    }
}

?>