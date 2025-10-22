<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$json = [];
$json["status"] = false;
$json["refresh"] = false;
try {
    if (!(include_once "../includes/imperiamucmsajax.php")) {
        throw new Exception("Could not load the AJAX configurations file.");
    }
    $Auction = new Auction();
    $auctions = $Auction->getActiveAuctions($_GET["pg"], $_GET["limit"]);
    if (isset($auctions)) {
        if (0 < count($auctions)) {
            $json["refresh"] = true;
        }
        $json["status"] = true;
    } else {
        throw new Exception("Auctions not found");
    }
} catch (Exception $e) {
    $json["error"] = @$e->getMessage();
    echo @json_encode($json);
}

?>