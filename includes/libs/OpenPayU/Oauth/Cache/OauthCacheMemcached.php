<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OauthCacheMemcached implements OauthCacheInterface
{
    private $memcached = NULL;
    public function __construct($host = "localhost", $port = 11211, $weight = 0)
    {
        if (!class_exists("Memcached")) {
            throw new OpenPayU_Exception_Configuration("PHP Memcached extension not installed.");
        }
        $this->memcached = new Memcached("PayU");
        $this->memcached->addServer($host, $port, $weight);
        $stats = $this->memcached->getStats();
        if ($stats[$host . ":" . $port]["pid"] == -1) {
            throw new OpenPayU_Exception_Configuration("Problem with connection to memcached server [host=" . $host . "] [port=" . $port . "] [weight=" . $weight . "]");
        }
    }
    public function get($key)
    {
        $cache = $this->memcached->get($key);
        return $cache === false ? NULL : unserialize($cache);
    }
    public function set($key, $value)
    {
        return $this->memcached->set($key, serialize($value));
    }
    public function invalidate($key)
    {
        return $this->memcached->delete($key);
    }
}

?>