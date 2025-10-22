<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class CreditSystem
{
    private $_configId = NULL;
    private $_identifier = NULL;
    private $_configTitle = NULL;
    private $_configDatabase = NULL;
    private $_configTable = NULL;
    private $_configCreditsCol = NULL;
    private $_configUserCol = NULL;
    private $_configUserColId = NULL;
    private $_configCheckOnline = true;
    private $_allowedUserColId = ["userid", "username", "email", "character"];
    public function __construct(common $common, Character $character, dB $muonline, dB $me_muonline = NULL)
    {
        $this->common = $common;
        $this->character = $character;
        $this->muonline = $muonline;
        if ($me_muonline) {
            $this->memuonline = $me_muonline;
        }
    }
    public function setIdentifier($input)
    {
        if (!$this->_configId) {
            throw new Exception("You have not set a configuration id.");
        }
        $config = $this->showConfigs(true);
        switch ($config["config_user_col_id"]) {
            case "userid":
                $this->_setUserid($input);
                break;
            case "username":
                $this->_setUsername($input);
                break;
            case "email":
                $this->_setEmail($input);
                break;
            case "character":
                $this->_setCharacter($input);
                break;
            default:
                throw new Exception("invalid identifier.");
        }
    }
    public function showConfigs($singleConfig = false)
    {
        if ($singleConfig) {
            if (!$this->_configId) {
                throw new Exception("You have not set a configuration id.");
            }
            return $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$this->_configId]);
        }
        $result = $this->muonline->query_fetch("SELECT * FROM IMPERIAMUCMS_CREDITS_CONFIG ORDER BY config_id ASC");
        if ($result) {
            return $result;
        }
        return false;
    }
    private function _setUserid($input)
    {
        if (!Validator::UnsignedNumber($input)) {
            throw new Exception("The userid entered is not valid.");
        }
        $this->_identifier = $input;
    }
    private function _setUsername($input)
    {
        if (!Validator::AlphaNumeric($input)) {
            throw new Exception("The username entered contains non-allowed characters.");
        }
        if (!Validator::UsernameLength($input)) {
            throw new Exception("The username entered is not valid.");
        }
        $this->_identifier = $input;
    }
    private function _setEmail($input)
    {
        if (!Validator::Email($input)) {
            throw new Exception("The email entered is not valid.");
        }
        $this->_identifier = $input;
    }
    private function _setCharacter($input)
    {
        if (!Validator::AlphaNumeric($input)) {
            throw new Exception("The character name entered is not valid.");
        }
        $this->_identifier = $input;
    }
    public function addCredits($input)
    {
        if (!Validator::UnsignedNumber($input)) {
            throw new Exception("The amount of credits to add must be an unsigned number.");
        }
        if (!$this->_configId) {
            throw new Exception("You have not set a configuration id.");
        }
        if (!$this->_identifier) {
            throw new Exception("You have not set the user identifier.");
        }
        $config = $this->showConfigs(true);
        if ($config["config_checkonline"] && $this->_isOnline($config["config_user_col_id"])) {
            throw new Exception("Your account is online, please disconnect.");
        }
        $database = $config["config_database"] == "MuOnline" ? $this->muonline : $this->memuonline;
        $data = ["credits" => $input, "identifier" => $this->_identifier];
        $variables = ["{TABLE}", "{COLUMN}", "{USER_COLUMN}"];
        $values = [$config["config_table"], $config["config_credits_col"], $config["config_user_col"]];
        $query = str_replace($variables, $values, "UPDATE {TABLE} SET {COLUMN} = {COLUMN} + :credits WHERE {USER_COLUMN} = :identifier");
        $addCredits = $database->query($query, $data);
        if (!$addCredits) {
            throw new Exception("There was an error adding the credits, check for database errors.");
        }
        $this->_addLog($config["config_title"], $input, "add");
    }
    private function _isOnline($input)
    {
        if (!$this->_identifier) {
            throw new Exception("Identifier not set, cannot check online status.");
        }
        switch ($input) {
            case "userid":
                $accountInfo = $this->common->accountInformation($this->_identifier);
                if (!$accountInfo) {
                    throw new Exception("Could not retrieve account information.");
                }
                return $this->common->accountOnline($accountInfo[_CLMN_USERNM_]);
                break;
            case "username":
                $accountInfo = $this->common->accountInformation($this->_identifier);
                return $this->common->accountOnline($accountInfo[_CLMN_USERNM_]);
                break;
            case "email":
                $userId = $this->common->retrieveUserIDbyEmail($this->_identifier);
                if (!$userId) {
                    throw new Exception("Could not retrieve account information (email).");
                }
                $accountInfo = $this->common->accountInformation($userId);
                if (!$accountInfo) {
                    throw new Exception("Could not retrieve account information.");
                }
                return $this->common->accountOnline($accountInfo[_CLMN_USERNM_]);
                break;
            case "character":
                $characterData = $this->character->CharacterData($this->_identifier);
                if (!$characterData) {
                    throw new Exception("Could not retrieve account information (character).");
                }
                return $this->common->accountOnline($characterData[_CLMN_CHR_ACCID_]);
                break;
            default:
                throw new Exception("Invalid identifier set, cannot check online status.");
        }
    }
    private function _addLog($configTitle = "unknown", $credits = 0, $transaction = "unknown")
    {
        $inadmincp = defined("admincp") ? 1 : 0;
        if ($inadmincp == 1) {
            $module = $_GET["module"];
        } else {
            $module = $_GET["page"] . "/" . $_GET["subpage"];
        }
        $ip = check_value($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "0.0.0.0";
        $data = ["config" => $configTitle, "identifier" => $this->_identifier, "credits" => $credits, "transaction" => $transaction, "timestamp" => time(), "inadmincp" => $inadmincp, "module" => $module, "ip" => $ip];
        $query = "INSERT INTO IMPERIAMUCMS_CREDITS_LOGS (log_config, log_identifier, log_credits, log_transaction, log_date, log_inadmincp, log_module, log_ip) VALUES (:config, :identifier, :credits, :transaction, :timestamp, :inadmincp, :module, :ip)";
        $saveLog = $this->muonline->query($query, $data);
    }
    public function subtractCredits($input)
    {
        if (!Validator::UnsignedNumber($input)) {
            throw new Exception("The amount of credits to subtract must be an unsigned number.");
        }
        if (!$this->_configId) {
            throw new Exception("You have not set a configuration id.");
        }
        if (!$this->_identifier) {
            throw new Exception("You have not set the user identifier.");
        }
        $config = $this->showConfigs(true);
        if ($config["config_checkonline"] && $this->_isOnline($config["config_user_col_id"])) {
            throw new Exception("Your account is online, please disconnect.");
        }
        $database = $config["config_database"] == "MuOnline" ? $this->muonline : $this->memuonline;
        $data = ["credits" => $input, "identifier" => $this->_identifier];
        $check = $database->query_fetch_single("SELECT " . $config["config_credits_col"] . " FROM " . $config["config_table"] . " WHERE " . $config["config_user_col"] . " = ?", [$this->_identifier]);
        if ($check[$config["config_credits_col"]] < $input) {
            throw new Exception("Not enough " . $config["config_title"] . ".");
        }
        $variables = ["{TABLE}", "{COLUMN}", "{USER_COLUMN}"];
        $values = [$config["config_table"], $config["config_credits_col"], $config["config_user_col"]];
        $query = str_replace($variables, $values, "UPDATE {TABLE} SET {COLUMN} = {COLUMN} - :credits WHERE {USER_COLUMN} = :identifier");
        $addCredits = $database->query($query, $data);
        if (!$addCredits) {
            throw new Exception("There was an error subtracting the credits, check for database errors.");
        }
        $this->_addLog($config["config_title"], $input, "subtract");
    }
    public function setConfigId($input)
    {
        if (!Validator::UnsignedNumber($input)) {
            throw new Exception("Invalid configuration id.");
        }
        if (!$this->_configurationExists($input)) {
            throw new Exception("Invalid configuration id.");
        }
        $this->_configId = $input;
    }
    private function _configurationExists($input)
    {
        $check = $this->muonline->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$input]);
        if ($check) {
            return true;
        }
        return false;
    }
    public function setConfigTitle($input)
    {
        if (!Validator::Chars($input, ["a-z", "A-Z", "0-9", " "])) {
            throw new Exception("The title can only contain alphanumeric characters and spaces.");
        }
        $this->_configTitle = $input;
    }
    public function setConfigDatabase($input)
    {
        if (!Validator::Chars($input, ["a-z", "A-Z", "0-9", "_"])) {
            throw new Exception("The database entered contains non-allowed characters.");
        }
        $this->_configDatabase = $input;
    }
    public function setConfigTable($input)
    {
        if (!Validator::Chars($input, ["a-z", "A-Z", "0-9", "_"])) {
            throw new Exception("The table entered contains non-allowed characters.");
        }
        $this->_configTable = $input;
    }
    public function setConfigCreditsColumn($input)
    {
        if (!Validator::Chars($input, ["a-z", "A-Z", "0-9", "_"])) {
            throw new Exception("The credits column entered contains non-allowed characters.");
        }
        $this->_configCreditsCol = $input;
    }
    public function setConfigUserColumn($input)
    {
        if (!Validator::Chars($input, ["a-z", "A-Z", "0-9", "_"])) {
            throw new Exception("The user column entered contains non-allowed characters.");
        }
        $this->_configUserCol = $input;
    }
    public function setConfigUserColumnId($input)
    {
        if (!Validator::AlphaNumeric($input)) {
            throw new Exception("The user column identifier is not valid, please select one of the following: userid, username, email or character.");
        }
        if (!in_array($input, $this->_allowedUserColId)) {
            throw new Exception("The user column identifier is not valid, please select one of the following: userid, username, email or character.");
        }
        $this->_configUserColId = $input;
    }
    public function setConfigCheckOnline($input)
    {
        $this->_configCheckOnline = $input ? 1 : 0;
    }
    public function saveConfig()
    {
        if (!$this->_configTitle) {
            throw new Exception("You need to set a title to the configuration.");
        }
        if (!$this->_configDatabase) {
            throw new Exception("You need to set a database to the configuration.");
        }
        if (!$this->_configTable) {
            throw new Exception("You need to set a table to the configuration.");
        }
        if (!$this->_configCreditsCol) {
            throw new Exception("You need to set a credits column to the configuration.");
        }
        if (!$this->_configUserCol) {
            throw new Exception("You need to set a user column to the configuration.");
        }
        if (!$this->_configUserColId) {
            throw new Exception("You need to set a user column identifier to the configuration.");
        }
        $data = ["title" => $this->_configTitle, "database" => $this->_configDatabase, "table" => $this->_configTable, "creditscol" => $this->_configCreditsCol, "usercol" => $this->_configUserCol, "usercolid" => $this->_configUserColId, "checkonline" => $this->_configCheckOnline];
        $query = "INSERT INTO IMPERIAMUCMS_CREDITS_CONFIG (config_title, config_database, config_table, config_credits_col, config_user_col, config_user_col_id, config_checkonline) VALUES (:title, :database, :table, :creditscol, :usercol, :usercolid, :checkonline)";
        $saveConfig = $this->muonline->query($query, $data);
        if (!$saveConfig) {
            throw new Exception("There has been an error adding the configuration to the database, check for database errors.");
        }
    }
    public function editConfig()
    {
        if (!$this->_configId) {
            throw new Exception("You have not set a configuration id.");
        }
        if (!$this->_configTitle) {
            throw new Exception("You need to set a title to the configuration.");
        }
        if (!$this->_configDatabase) {
            throw new Exception("You need to set a database to the configuration.");
        }
        if (!$this->_configTable) {
            throw new Exception("You need to set a table to the configuration.");
        }
        if (!$this->_configCreditsCol) {
            throw new Exception("You need to set a credits column to the configuration.");
        }
        if (!$this->_configUserCol) {
            throw new Exception("You need to set a user column to the configuration.");
        }
        if (!$this->_configUserColId) {
            throw new Exception("You need to set a user column identifier to the configuration.");
        }
        $data = ["id" => $this->_configId, "title" => $this->_configTitle, "database" => $this->_configDatabase, "table" => $this->_configTable, "creditscol" => $this->_configCreditsCol, "usercol" => $this->_configUserCol, "usercolid" => $this->_configUserColId, "checkonline" => $this->_configCheckOnline];
        $query = "UPDATE IMPERIAMUCMS_CREDITS_CONFIG SET config_title = :title, config_database = :database, config_table = :table, config_credits_col = :creditscol, config_user_col= :usercol, config_user_col_id = :usercolid,config_checkonline = :checkonline WHERE config_id = :id";
        $editConfig = $this->muonline->query($query, $data);
        if (!$editConfig) {
            throw new Exception("There has been an error editing the configuration, check for database errors.");
        }
    }
    public function deleteConfig()
    {
        if (!$this->_configId) {
            throw new Exception("You have not set a configuration id.");
        }
        if (!$this->muonline->query("DELETE FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$this->_configId])) {
            throw new Exception("There has been an error deleting the configuration, check for database errors.");
        }
    }
    public function buildSelectInput($name = "creditsconfig", $default = 1, $class = "")
    {
        $selectName = Validator::Chars($name, ["a-z", "A-Z", "0-9", "_"]) ? $name : "creditsconfig";
        $selectedOption = Validator::UnsignedNumber($default) ? $default : 1;
        $configs = $this->showConfigs();
        if (is_array($configs)) {
            $return = $class ? "<select name=\"" . $selectName . "\" class=\"" . $class . "\">" : "<select name=\"" . $selectName . "\">";
            foreach ($configs as $config) {
                if ($selectedOption == $config["config_id"]) {
                    $return .= "<option value=\"" . $config["config_id"] . "\" selected>" . $config["config_title"] . "</option>";
                } else {
                    $return .= "<option value=\"" . $config["config_id"] . "\">" . $config["config_title"] . "</option>";
                }
            }
            $return .= "</select>";
            return $return;
        }
    }
    public function getAllCreditsLogs()
    {
        $result = $this->muonline->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_CREDITS_LOGS");
        return $result["total"];
    }
}

?>