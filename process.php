<?php
if($_POST){
  //  print_r($_POST);
   // print_r($_FILES);
   
    
    $file_tmp = $_FILES['upload']['tmp_name'];
    $file_type = $_FILES['upload']['type'];
    $file_name = $_FILES['upload']['name'];
    if(copy( $file_tmp, 'img/upload/'.$file_name)){
        setcookie("tmp_photo", 'img/upload/'.$file_name, time()+3600); 
        echo '1';
    }else{
        echo '0';
    }
     exit;
}


header( "Content-type: image/jpeg" );




//$text = "Pizza Hut  ";
//$text2 = " ลดไปเลย 300 บาท ที่ พิซซ่าฮัทเท่านั้น! หน้าแน่น ขอบอร่อย พิซซ่าฮัท 2 ถาด";

$my_img = imagecreate( 550, 360 ); //width & height
$background  = imagecolorallocate( $my_img, 254,  186,   26 );
$text_colour = imagecolorallocate( $my_img, 255, 255, 255 );
$grey = imagecolorallocate($my_img, 128, 128, 128);

//location front full path
$font = 'C:\xampp\htdocs\git_me\crop\crop_img\EkkamaiStandard-Light.ttf';



 
     
     
     
//imagettftext($my_img, 20, 0, 11, 21, $grey, $font, $text);
//imagettftext($my_img, 20, 0, 10, 30, $text_colour, $font, $text);
//imagettftext($my_img, 20, 0, 10, 30, $text_colour, $font, $text);
//imagettftext($my_img, 14, 0, 260, 80, $text_colour, $font, $text2);



$src = imagecreatefrompng('img/test.png');
$src2 = imagecreatefromjpeg('img/test3.jpg');
imagecopymerge($my_img, $src2, 0, 0, 0, 0,250, 260, 100 );





// imagepng( $my_img );
 imagejpeg( $my_img );

imagedestroy($my_img);












?>