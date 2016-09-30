<?php
require_once 'lib/dipandu.php';

session_start();
header("Content-type: image/jpg");

function RandomCode($max){
    
$char = array("A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y",
"Z","a","b","c","d","e","f","g","h","j","k","l","m","n","p","q","r","s","t","u","v","w","x",
"y","z","1","2","3","4","5","6","7","8","9");

$keys = array();

while(count($keys) < $max) {
    $x = mt_rand(0, count($char)-1);
    if(!in_array($x, $keys)) {
        $keys[] = $x; 
    } 
}
$random='';
foreach($keys as $key => $val){
    $random .= $char[$val]; 
}
    return $random;
}
$font='./fonts/OpenSans-Regular.ttf';
$images='./img/bg.jpg';
$im = imagecreatefromjpeg("$images")or die("Cannot Initialize new GD image stream");
$text_color = imagecolorallocate($im, 45, 220, 45); 

$text=RandomCode(6);

$_SESSION['generated_captcha']=$text;

imagettftext($im, 38, 5, 20, 60, $text_color, $font, $text);
imagejpeg($im);
imagedestroy($im);
?>

