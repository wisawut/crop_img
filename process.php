<?php
if($_POST){
    print_r($_POST);
}


header( "Content-type: image/png" );




$text = "Pizza Hut  ";
$text2 = " ลดไปเลย 300 บาท ที่ พิซซ่าฮัทเท่านั้น! หน้าแน่น ขอบอร่อย พิซซ่าฮัท 2 ถาด";

$my_img = imagecreate( 550, 360 ); //width & height
$background  = imagecolorallocate( $my_img, 254,  186,   26 );
$text_colour = imagecolorallocate( $my_img, 255, 255, 255 );
$grey = imagecolorallocate($my_img, 128, 128, 128);

//location front full path
$font = 'C:\xampp\htdocs\git_me\crop\crop_img\EkkamaiStandard-Light.ttf';



 
     
     
     
//imagettftext($my_img, 20, 0, 11, 21, $grey, $font, $text);

imagettftext($my_img, 20, 0, 10, 30, $text_colour, $font, $text);

imagettftext($my_img, 14, 0, 260, 80, $text_colour, $font, $text2);



$src = imagecreatefrompng('img/test.png');
imagecopymerge($my_img, $src, 10,50, 0, 0, 250, 250, 100);





 imagepng( $my_img );

imagedestroy($my_img);












?>