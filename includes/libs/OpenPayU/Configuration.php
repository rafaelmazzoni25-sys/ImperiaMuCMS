<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Configuration
{
    private static $sender = "Generic";
    private static $_availableEnvironment = ["custom", "secure", "sandbox"];
    private static $_availableHashAlgorithm = ["SHA", "SHA-256", "SHA-384", "SHA-512"];
    private static $env = "secure";
    private static $merchantPosId = "";
    private static $signatureKey = "";
    private static $oauthGrantType = OauthGrantType::CLIENT_CREDENTIAL;
    private static $oauthClientId = "";
    private static $oauthClientSecret = "";
    private static $oauthEmail = "";
    private static $oauthExtCustomerId = NULL;
    private static $oauthEndpoint = "";
    private static $oauthTokenCache = NULL;
    private static $proxyHost = NULL;
    private static $proxyPort = NULL;
    private static $proxyUser = NULL;
    private static $proxyPassword = NULL;
    private static $serviceUrl = "";
    private static $hashAlgorithm = "SHA-256";
    const API_VERSION = "2.1";
    const COMPOSER_JSON = "/composer.json";
    const DEFAULT_SDK_VERSION = "PHP SDK 2.2.9";
    const OAUTH_CONTEXT = "pl/standard/user/oauth/authorize";
    public static function getApiVersion()
    {
        return "2.1";
    }
    public static function setHashAlgorithm($value)
    {
        if (!in_array($value, self::$_availableHashAlgorithm)) {
            throw new OpenPayU_Exception_Configuration("Hash algorithm \"" . $value . "\"\" is not available");
        }
        self::$hashAlgorithm = $value;
    }
    public static function getHashAlgorithm()
    {
        return self::$hashAlgorithm;
    }
    public static function setEnvironment($environment = "secure", $domain = "payu.com", $api = "api/", $version = "v2_1/")
    {
        $environment = strtolower($environment);
        $domain = strtolower($domain) . "/";
        if (!in_array($environment, self::$_availableEnvironment)) {
            throw new OpenPayU_Exception_Configuration($environment . " - is not valid environment");
        }
        self::$env = $environment;
        if ($environment == "secure") {
            self::$serviceUrl = "https://" . $environment . "." . $domain . $api . $version;
            self::$oauthEndpoint = "https://" . $environment . "." . $domain . "pl/standard/user/oauth/authorize";
        } else {
            if ($environment == "sandbox") {
                self::$serviceUrl = "https://secure.snd." . $domain . $api . $version;
                self::$oauthEndpoint = "https://secure.snd." . $domain . "pl/standard/user/oauth/authorize";
            } else {
                if ($environment == "custom") {
                    self::$serviceUrl = $domain . $api . $version;
                    self::$oauthEndpoint = $domain . "pl/standard/user/oauth/authorize";
                }
            }
        }
    }
    public static function getServiceUrl()
    {
        return self::$serviceUrl;
    }
    public static function getOauthEndpoint()
    {
        return self::$oauthEndpoint;
    }
    public static function getEnvironment()
    {
        return self::$env;
    }
    public static function setMerchantPosId($value)
    {
        self::$merchantPosId = trim($value);
    }
    public static function getMerchantPosId()
    {
        return self::$merchantPosId;
    }
    public static function setSignatureKey($value)
    {
        self::$signatureKey = trim($value);
    }
    public static function getSignatureKey()
    {
        return self::$signatureKey;
    }
    public static function getOauthGrantType()
    {
        return self::$oauthGrantType;
    }
    public static function setOauthGrantType($oauthGrantType)
    {
        if ($oauthGrantType !== OauthGrantType::CLIENT_CREDENTIAL && $oauthGrantType !== OauthGrantType::TRUSTED_MERCHANT) {
            throw new OpenPayU_Exception_Configuration("Oauth grand type \"" . $oauthGrantType . "\"\" is not available");
        }
        self::$oauthGrantType = $oauthGrantType;
    }
    public static function getOauthClientId()
    {
        return self::$oauthClientId;
    }
    public static function getOauthClientSecret()
    {
        return self::$oauthClientSecret;
    }
    public static function setOauthClientId($oauthClientId)
    {
        self::$oauthClientId = trim($oauthClientId);
    }
    public static function setOauthClientSecret($oauthClientSecret)
    {
        self::$oauthClientSecret = trim($oauthClientSecret);
    }
    public static function getOauthEmail()
    {
        return self::$oauthEmail;
    }
    public static function setOauthEmail($oauthEmail)
    {
        self::$oauthEmail = $oauthEmail;
    }
    public static function getOauthExtCustomerId()
    {
        return self::$oauthExtCustomerId;
    }
    public static function setOauthExtCustomerId($oauthExtCustomerId)
    {
        self::$oauthExtCustomerId = $oauthExtCustomerId;
    }
    public static function getOauthTokenCache()
    {
        return self::$oauthTokenCache;
    }
    public static function setOauthTokenCache($oauthTokenCache)
    {
        if (!$oauthTokenCache instanceof OauthCacheInterface) {
            throw new OpenPayU_Exception_Configuration("Oauth token cache class is not instance of OauthCacheInterface");
        }
        self::$oauthTokenCache = $oauthTokenCache;
    }
    public static function getProxyHost()
    {
        return self::$proxyHost;
    }
    public static function setProxyHost($proxyHost)
    {
        self::$proxyHost = $proxyHost;
    }
    public static function getProxyPort()
    {
        return self::$proxyPort;
    }
    public static function setProxyPort($proxyPort)
    {
        self::$proxyPort = $proxyPort;
    }
    public static function getProxyUser()
    {
        return self::$proxyUser;
    }
    public static function setProxyUser($proxyUser)
    {
        self::$proxyUser = $proxyUser;
    }
    public static function getProxyPassword()
    {
        return self::$proxyPassword;
    }
    public static function setProxyPassword($proxyPassword)
    {
        self::$proxyPassword = $proxyPassword;
    }
    public static function setSender($sender)
    {
        self::$sender = $sender;
    }
    public static function getSender()
    {
        return self::$sender;
    }
    public static function getFullSenderName()
    {
        return sprintf("%s@%s", $this::getSender(), $this::getSdkVersion());
    }
    public static function getSdkVersion()
    {
        $composerFilePath = $this::getComposerFilePath();
        if (file_exists($composerFilePath)) {
            $fileContent = file_get_contents($composerFilePath);
            $composerData = json_decode($fileContent);
            if (isset($composerData->version) && isset($composerData->extra[0]->engine)) {
                return sprintf("%s %s", $composerData->extra[0]->engine, $composerData->version);
            }
        }
        return "PHP SDK 2.2.9";
    }
    private static function getComposerFilePath()
    {
        return realpath(dirname(__FILE__)) . "/../../" . "/composer.json";
    }
}

?>