<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

include "../includes/imperiamucms.php";
loadModuleConfigs("donation.pagseguro");
if (!mconfig("active")) {
    exit;
}
require_once "../includes/PagSeguroLibrary/PagSeguroLibrary.php";
NotificationListener::main();
class NotificationListener
{
    public static function main()
    {
        $code = isset($_POST["notificationCode"]) && trim($_POST["notificationCode"]) !== "" ? trim($_POST["notificationCode"]) : NULL;
        $type = isset($_POST["notificationType"]) && trim($_POST["notificationType"]) !== "" ? trim($_POST["notificationType"]) : NULL;
        if ($code && $type) {
            $notificationType = new PagSeguroNotificationType($type);
            $strType = $notificationType->getTypeFromValue();
            switch ($strType) {
                case "TRANSACTION":
                    $this::transactionNotification($code);
                    break;
                default:
                    LogPagSeguro::error("Unknown notification type [" . $notificationType->getValue() . "]");
            }
        } else {
            LogPagSeguro::error("Invalid notification parameters.");
            $this::printLog();
        }
    }
    private static function transactionNotification($notificationCode)
    {
        $credentials = new PagSeguroAccountCredentials(mconfig("pgseguro_email"), mconfig("pagseguro_token"));
        try {
            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);
            $donationStatus = $transaction->getStatus();
            $donationCode = $transaction->getCode();
            $donationUser = $transaction->GetReference();
            $donationAmount = $transaction->getGrossAmount();
            $totalCredits = floor($donationAmount * mconfig("pgseguro_conversion_rate"));
            try {
                $user_id = $common->retrieveUserID($donationUser);
                if (!Validator::UnsignedNumber($user_id)) {
                    throw new Exception("invalid userid");
                }
                $accountInfo = $common->accountInformation($user_id);
                if (!is_array($accountInfo)) {
                    throw new Exception("invalid account");
                }
                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                $creditSystem->setConfigId(mconfig("credit_config"));
                $configSettings = $creditSystem->showConfigs(true);
                switch ($configSettings["config_user_col_id"]) {
                    case "userid":
                        $creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
                        break;
                    case "username":
                        $creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
                        break;
                    case "email":
                        $creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
                        $_GET["page"] = "api";
                        $_GET["subpage"] = "pagseguro";
                        $creditSystem->addCredits($totalCredits);
                        addpagsegurolog($user_id, $totalCredits, $donationCode, $donationAmount);
                        break;
                    default:
                        throw new Exception("invalid identifier");
                }
            } catch (Exception $ex) {
                exit($ex->getMessage());
            }
        } catch (PagSeguroServiceException $e) {
            exit($e->getMessage());
        }
    }
    private static function printLog($strType = NULL)
    {
        $count = 4;
        echo "<h2>Receive notifications</h2>";
        if ($strType) {
            echo "<h4>notifcationType: " . $strType . "</h4>";
        }
        echo "<p>Last <strong>" . $count . "</strong> items in <strong>log file:</strong></p><hr>";
        echo LogPagSeguro::getHtml($count);
    }
}
function addPagSeguroLog($account, $amount, $code, $gross)
{
    $logFile = __PATH_INCLUDES__ . "PagSeguroLibrary/log/donationslog/";
    $logFile .= "ps-" . date("Y-m-d") . ".txt";
    $fp = fopen($logFile, "a+");
    fwrite($fp, time() . "|");
    fwrite($fp, $account . "|");
    fwrite($fp, $amount . "|");
    fwrite($fp, $code . "|");
    fwrite($fp, $gross . ";\r\n");
    fclose($fp);
}

?>