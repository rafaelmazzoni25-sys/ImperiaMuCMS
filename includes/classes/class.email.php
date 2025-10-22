<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Email
{
    private $mail = NULL;
    private $_active = false;
    private $_smtp = false;
    private $_from = NULL;
    private $_name = NULL;
    private $_templates = [];
    private $_templatesPath = __PATH_EMAILS__;
    private $_smtpHost = NULL;
    private $_smtpPort = NULL;
    private $_smtpUser = NULL;
    private $_smtpPass = NULL;
    private $_smtpSecure = NULL;
    private $_template = NULL;
    private $_message = NULL;
    private $_to = [];
    private $_subject = NULL;
    private $_variables = [];
    private $_values = [];
    public function __construct()
    {
        $configs = gconfig("email", true);
        if (!is_array($configs)) {
            throw new Exception("Could not load email configurations.");
        }
        $this->_active = $configs["active"];
        $this->_smtp = $configs["smtp_active"];
        $this->_from = $configs["send_from"];
        $this->_name = $configs["send_name"];
        $this->_smtpHost = $configs["smtp_host"];
        $this->_smtpPort = $configs["smtp_port"];
        $this->_smtpUser = $configs["smtp_user"];
        $this->_smtpPass = $configs["smtp_pass"];
        if (is_string($configs["smtp_secure"])) {
            $this->_smtpSecure = strtolower($configs["smtp_secure"]);
        } else {
            $this->_smtpSecure = "";
        }
        if (!is_array($configs["email_templates"]["template"])) {
            throw new Exception();
        }
        $templates = [];
        foreach ($configs["email_templates"]["template"] as $template) {
            $templates[$template["filename"]] = $template["subject"];
        }
        $this->_templates = $templates;
        $this->mail = new PHPMailer\PHPMailer\PHPMailer();
    }
    public function setMessage($message)
    {
        $this->_message = $message;
    }
    public function setTemplate($template)
    {
        if (!array_key_exists($template, $this->_templates)) {
            throw new Exception("Could not load email template.");
        }
        $this->_template = $template;
        $this->_subject = $this->_templates[$template];
    }
    public function addVariable($variable, $value)
    {
        $this->_variables[] = $variable;
        $this->_values[] = $value;
    }
    public function addAddress($email)
    {
        if (!Validator::Email($email)) {
            throw new Exception("Email address invalid, cannot send email.");
        }
        $this->_to[] = $email;
    }
    public function send()
    {
        if (!$this->_active) {
            throw new Exception(lang("error_48", true));
        }
        if (!$this->_message && !$this->_template) {
            throw new Exception("You did not set a template.");
        }
        if (!is_array($this->_to)) {
            throw new Exception("You did not add any address.");
        }
        $this->mail->Host = $this->_smtpHost;
        $this->mail->Port = $this->_smtpPort;
        if ($this->_smtp) {
            $this->mail->IsSMTP();
            if ($this->_smtpSecure == "none") {
                $this->mail->SMTPAuth = false;
            } else {
                $this->mail->SMTPAuth = true;
                $this->mail->Username = $this->_smtpUser;
                $this->mail->Password = $this->_smtpPass;
                if ($this->_smtpSecure == "ssl") {
                    $this->mail->SMTPSecure = "ssl";
                } else {
                    if ($this->_smtpSecure == "tls") {
                        $this->mail->SMTPSecure = "tls";
                    } else {
                        $this->mail->SMTPSecure = "";
                    }
                }
            }
        }
        $this->mail->SetFrom($this->_from, $this->_name);
        foreach ($this->_to as $address) {
            $this->mail->AddAddress($address);
        }
        $this->mail->Subject = $this->_subject;
        if (!$this->_message) {
            $this->mail->MsgHTML($this->_prepareTemplate());
        } else {
            $this->mail->MsgHTML($this->_message);
        }
        if ($this->mail->Send()) {
            return true;
        }
        return false;
    }
    private function _prepareTemplate()
    {
        return str_replace($this->_variables, $this->_values, $this->_loadTemplate());
    }
    private function _loadTemplate()
    {
        if (!$this->_template) {
            throw new Exception("You did not set a template.");
        }
        if (!file_exists($this->_templatesPath . $this->_template . ".txt")) {
            throw new Exception("Could not load email template.");
        }
        return file_get_contents($this->_templatesPath . $this->_template . ".txt");
    }
}

?>