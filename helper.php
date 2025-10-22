<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$cfg["display_border"] = false;
$cfg["min_size"] = 10;
$cfg["max_size"] = 500;
$cfg["def_size"] = 40;
if (isset($_GET["s"])) {
    if (is_numeric($_GET["s"])) {
        if ($cfg["min_size"] <= $_GET["s"] && $_GET["s"] <= $cfg["max_size"]) {
            $size = $_GET["s"];
        } else {
            $size = $cfg["def_size"];
        }
    } else {
        $size = $cfg["def_size"];
    }
} else {
    $size = $cfg["def_size"];
}
$binaryData = isset($_GET["req"]) ? $_GET["req"] : "";
$pixelSize = $size / 8;
$hex = $binaryData;
$y = 0;
while ($y < 8) {
    $x = 0;
    while ($x < 8) {
        $offset = $y * 8 + $x;
        $Cuadrilla8x8[$y][$x] = substr($hex, $offset, 1);
        $x++;
    }
    $y++;
}
$SuperCuadrilla = [];
$y = 1;
while ($y <= 8) {
    $x = 1;
    while ($x <= 8) {
        $bit = $Cuadrilla8x8[$y - 1][$x - 1];
        $repiteY = 0;
        while ($repiteY < $pixelSize) {
            $repite = 0;
            while ($repite < $pixelSize) {
                $translatedY = ($y - 1) * $pixelSize + $repiteY;
                $translatedX = ($x - 1) * $pixelSize + $repite;
                $SuperCuadrilla[$translatedY][$translatedX] = $bit;
                $repite++;
            }
            $repiteY++;
        }
        $x++;
    }
    $y++;
}
$img = ImageCreate($size, $size);
$y = 0;
while ($y < $size) {
    $x = 0;
    while ($x < $size) {
        $bit = $SuperCuadrilla[$y][$x];
        $color = substr(color($bit), 1);
        $r = substr($color, 0, 2);
        $g = substr($color, 2, 2);
        $b = substr($color, 4, 2);
        $superPixel = ImageCreate(1, 1);
        $cl = imageColorAllocateAlpha($superPixel, hexdec($r), hexdec($g), hexdec($b), 0);
        ImageFilledRectangle($superPixel, 0, 0, 1, 1, $cl);
        ImageCopy($img, $superPixel, $x, $y, 0, 0, 1, 1);
        ImageDestroy($superPixel);
        $x++;
    }
    $y++;
}
header("Content-type: image/gif");
if ($cfg["display_border"]) {
    ImageRectangle($img, 0, 0, $size - 1, $size - 1, ImageColorAllocate($img, 0, 0, 0));
} else {
    ImageRectangle($img, 0, 0, $size - 1, $size - 1, ImageColorAllocate($img, 0, 0, 0));
}
imagecolortransparent($img, imagecolorexact($img, 17, 17, 17));
ImageGif($img);
function color($mark)
{
    $mark = is_numeric($mark) ? $mark : strtoupper($mark);
    if (strcmp($mark, "0") == 0) {
        return "#111111";
    }
    if (strcmp($mark, "1") == 0) {
        return "#000000";
    }
    if (strcmp($mark, "2") == 0) {
        return "#808080";
    }
    if (strcmp($mark, "3") == 0) {
        return "#ffffff";
    }
    if (strcmp($mark, "4") == 0) {
        return "#fe0000";
    }
    if (strcmp($mark, "5") == 0) {
        return "#ff7f00";
    }
    if (strcmp($mark, "6") == 0) {
        return "#ffff00";
    }
    if (strcmp($mark, "7") == 0) {
        return "#80ff00";
    }
    if (strcmp($mark, "8") == 0) {
        return "#00ff01";
    }
    if (strcmp($mark, "9") == 0) {
        return "#00fe81";
    }
    if (strcmp($mark, "A") == 0) {
        return "#00ffff";
    }
    if (strcmp($mark, "B") == 0) {
        return "#0080ff";
    }
    if (strcmp($mark, "C") == 0) {
        return "#0000fe";
    }
    if (strcmp($mark, "D") == 0) {
        return "#7f00ff";
    }
    if (strcmp($mark, "E") == 0) {
        return "#ff00fe";
    }
    if (strcmp($mark, "F") == 0) {
        return "#ff0080";
    }
}

?>