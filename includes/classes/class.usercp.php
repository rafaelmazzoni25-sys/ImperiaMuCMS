<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class UserCP
{
    private $xmlPath = NULL;
    private $xml = NULL;
    public function __construct()
    {
        $this->xmlPath = __PATH_MODULE_CONFIGS__ . "usercp.xml";
    }
    private function LoadXml()
    {
        $this->xml = simplexml_load_file($this->xmlPath);
    }
    private function SaveXml()
    {
        return $this->xml->asXML($this->xmlPath);
    }
    public function SaveActive($active)
    {
        $this->LoadXml();
        $this->xml->active = $active;
        return $this->SaveXml();
    }
    public function SaveSection($section_names, $section_active)
    {
        print_r_formatted($section_names);
        print_r_formatted($section_active);
        if (!is_array($section_names) || !is_array($section_active)) {
            return false;
        }
        $this->LoadXml();
        foreach ($section_names as $id => $s) {
            if (isset($this->xml->main_menu->section[$id]["name"])) {
                $this->xml->main_menu->section[$id]["name"] = strval($s);
            }
        }
        foreach ($section_active as $id => $s) {
            if (isset($this->xml->main_menu->section[$id]["active"])) {
                $this->xml->main_menu->section[$id]["active"] = $s == 1 ? "true" : "false";
            }
        }
        return $this->SaveXml();
    }
    public function SaveModules($default_modules)
    {
        if (!is_array($default_modules)) {
            return false;
        }
        $this->LoadXml();
        foreach ($default_modules as $sid => $s) {
            foreach ($s as $id => $c) {
                if (isset($this->xml->main_menu->section[$sid]->module[$id]["hidden"])) {
                    $this->xml->main_menu->section[$sid]->module[$id]["hidden"] = $c == 1 ? "true" : "false";
                }
            }
        }
        return $this->SaveXml();
    }
    public function SaveQuickModules($quickModules)
    {
        if (!is_array($quickModules)) {
            return false;
        }
        $this->LoadXml();
        foreach ($quickModules as $id => $q) {
            if (isset($this->xml->quick_menu->module[$id]["hidden"])) {
                $this->xml->quick_menu->module[$id]["hidden"] = $q == 1 ? "true" : "false";
            }
        }
        return $this->SaveXml();
    }
    public function AddSection($name)
    {
        if (empty($name)) {
            return false;
        }
        $this->LoadXml();
        if (isset($this->xml->main_menu)) {
            $s = $this->xml->main_menu->addChild("section");
            $s->addAttribute("name", $name);
            $s->addAttribute("active", "true");
        }
        return $this->SaveXml();
    }
    public function AddModule(UserCPModule $module, $sid)
    {
        if (!is_a($module, "UserCPModule")) {
            return false;
        }
        $this->LoadXml();
        if (isset($this->xml->main_menu->section[$sid])) {
            $m = $this->xml->main_menu->section[$sid]->addChild("module");
            $module->AddAttributes($m);
        }
        return $this->SaveXml();
    }
    public function AddQuickModule(UserCPQuickModul $quickModule)
    {
        if (!is_a($quickModule, "UserCPQuickModul")) {
            return false;
        }
        $this->LoadXml();
        if (isset($this->xml->quick_menu)) {
            $m = $this->xml->quick_menu->addChild("module");
            $quickModule->AddAttributes($m);
        }
        return $this->SaveXml();
    }
    public function DeleteSection($id)
    {
        if (!is_int($id)) {
            return false;
        }
        $delete = false;
        $this->LoadXml();
        if (isset($this->xml->main_menu->section[$id]) && $this->xml->main_menu->section[$id]->count() == 0) {
            unset($this->xml->main_menu->section[$id]);
            $delete = $this->SaveXml();
        }
        return $delete;
    }
    public function DeleteModule($id, $sid)
    {
        if (!is_int($id) || !is_int($sid)) {
            return false;
        }
        $delete = false;
        $this->LoadXml();
        if (isset($this->xml->main_menu->section[$sid]->module[$id]) && $this->xml->main_menu->section[$sid]->module[$id]["custom"] == "true") {
            unset($this->xml->main_menu->section[$sid]->module[$id]);
            $delete = $this->SaveXml();
        }
        return $delete;
    }
    public function DeleteQuickModule($id)
    {
        if (!is_int($id)) {
            return false;
        }
        $delete = false;
        $this->LoadXml();
        if (isset($this->xml->quick_menu->module[$id]) && $this->xml->quick_menu->module[$id]["custom"] == "true") {
            unset($this->xml->quick_menu->module[$id]);
            $delete = $this->SaveXml();
        }
        return $delete;
    }
    public function create_section($xml_Section, $id)
    {
        $section = [];
        $section["id"] = $id;
        $section["active"] = $xml_Section["@attributes"]["active"] == "true" ? 1 : 0;
        $section["name"] = $xml_Section["@attributes"]["name"];
        $section["modules"] = [];
        $module_id = 0;
        if (isset($xml_Section["module"])) {
            if (!isset($xml_Section["module"][0])) {
                $modul_id = $id . "_0";
                $modul = $this->create_main_module($xml_Section["module"], 0);
                $section["modules"][] = $modul;
            } else {
                $i = 0;
                foreach ($xml_Section["module"] as $m) {
                    $modul = $this->create_main_module($m, $i++);
                    $section["modules"][] = $modul;
                }
            }
        }
        return $section;
    }
    public function create_main_module($xml_module, $id)
    {
        $m = [];
        $m["id"] = $id;
        $m["name"] = $xml_module["@attributes"]["name"];
        $m["desc"] = $xml_module["@attributes"]["desc"];
        $m["custom"] = $xml_module["@attributes"]["custom"] == "true" ? 1 : 0;
        $m["hidden"] = $xml_module["@attributes"]["hidden"] == "true" ? 1 : 0;
        $m["icon"] = $xml_module["@attributes"]["icon"];
        $m["module"] = $xml_module["@attributes"]["module"];
        $m["config"] = $xml_module["@attributes"]["config"];
        return $m;
    }
    public function create_quick_module($xml_module, $id)
    {
        $m = [];
        $m["id"] = $id;
        $m["name"] = $xml_module["@attributes"]["name"];
        $m["class"] = $xml_module["@attributes"]["class"];
        $m["custom"] = $xml_module["@attributes"]["custom"] == "true" ? 1 : 0;
        $m["hidden"] = $xml_module["@attributes"]["hidden"] == "true" ? 1 : 0;
        $m["module"] = $xml_module["@attributes"]["module"];
        $m["config"] = $xml_module["@attributes"]["config"];
        return $m;
    }
    public function create_main_manu($main_menu_xml)
    {
        $main_menu_sections = [];
        if (isset($main_menu_xml["section"])) {
            if (!isset($main_menu_xml["section"][0])) {
                $section = $this->create_section($main_menu_xml["section"], 0);
                $main_menu_sections[] = $section;
            } else {
                $section_id = 0;
                foreach ($main_menu_xml["section"] as $s) {
                    $section = $this->create_section($s, $section_id++);
                    $main_menu_sections[] = $section;
                }
            }
        }
        return $main_menu_sections;
    }
    public function create_quick_menu($quick_menu_xml)
    {
        $quick_menu_modules = [];
        if (isset($quick_menu_xml["module"])) {
            if (!isset($quick_menu_xml["module"][0])) {
                $modul = $this->create_quick_module($quick_menu_xml["module"], 0);
                $quick_menu_modules[] = $modul;
            } else {
                $modul_id = 0;
                foreach ($quick_menu_xml["module"] as $m) {
                    $modul = $this->create_quick_module($m, $modul_id++);
                    $quick_menu_modules[] = $modul;
                }
            }
        }
        return $quick_menu_modules;
    }
}
class UserCPModule
{
    public $name = NULL;
    public $desc = NULL;
    public $module = NULL;
    public $icon = NULL;
    public $config = NULL;
    public $custom = NULL;
    public $hidden = NULL;
    public function __construct()
    {
        $this->custom = "true";
        $this->hidden = "false";
    }
    public function AddAttributes(SimpleXMLElement $module)
    {
        $module->addAttribute("name", $this->name);
        $module->addAttribute("desc", $this->desc);
        $module->addAttribute("module", $this->module);
        $module->addAttribute("icon", $this->icon);
        $module->addAttribute("config", $this->config);
        $module->addAttribute("hidden", $this->hidden);
        $module->addAttribute("custom", $this->custom);
    }
}
class UserCPQuickModul
{
    public $name = NULL;
    public $module = NULL;
    public $config = NULL;
    public $class = NULL;
    public $custom = NULL;
    public $hidden = NULL;
    public function __construct()
    {
        $this->custom = "true";
        $this->hidden = "false";
    }
    public function AddAttributes(SimpleXMLElement $module)
    {
        $module->addAttribute("name", $this->name);
        $module->addAttribute("module", $this->module);
        $module->addAttribute("class", $this->class);
        $module->addAttribute("config", $this->config);
        $module->addAttribute("hidden", $this->hidden);
        $module->addAttribute("custom", $this->custom);
    }
}

?>