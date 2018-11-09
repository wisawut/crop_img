<?php
include('watermark.php');
 function imfinfo($originalFile) {

    $info = getimagesize($originalFile);
    $mime = $info['mime'];
    
    switch ($mime) {
            case 'image/jpeg':
                    $rs[0] = 'imagecreatefromjpeg';                   
                    $rs[1] = 'jpg';
                    break;

            case 'image/png':
                     $rs[0]  = 'imagecreatefrompng';                  
                     $rs[1]  = 'png';
                    break;

            case 'image/gif':
                     $rs[0]  = 'imagecreatefromgif';                
                     $rs[1]  = 'gif';
                    break;

            default: 
                    throw new Exception('Unknown image type.');
    }
     return $rs;
 }
    
    
    
    
if($_POST){
 
    header( "Content-type: image/jpeg" );
    
   

  $bg = (isset($_POST['bgcolor'])?$_POST['bgcolor']:'254,186,26');
   
    $image_uploadinfo = imfinfo($_POST['src']);
    if($image_uploadinfo[1] == 'jpg' ){
       $soure_img =  imagecreatefromjpeg($_POST['src']);
    }else if($image_uploadinfo[1] == 'png'){
        $soure_img = imagecreatefrompng($_POST['src']);
    }
     $imagenew = 'img/upload/crop_buff.'.$image_uploadinfo[1];
     $width = '360';
     $height = '360';
    // $ratio = imagesy($soure_img) / imagesx($soure_img);
   //  $height = $width * $ratio;
     $my_img = imagecreatetruecolor($width,$height);  
    //$src = imagecreatefrompng('img/test.png');
   // $src2 = imagecreatefromjpeg('img/test3.jpg');
    imagecopyresampled($my_img,$soure_img, 0, 0, $_POST['x'], $_POST['y'],$width,$height ,$_POST['w'],$_POST['h'] );
  //  imagecopymerge($my_img, $soure_img , 0, 0, 0, 0,0, 0, 100 );
    $soure_img = $my_img;
      if($image_uploadinfo[1] == 'jpg' ){
           imagejpeg($soure_img, $imagenew, 100);
          chmod($imagenew, 0777);
     }else if($image_uploadinfo[1] == 'png'){
            imagepng($soure_img, $imagenew);
          chmod($imagenew, 0777);
    }
    
  

    
    // create image background
   $my_imgbg = imagecreatetruecolor( 550, 360 ); //width & height

   // color from input post
    $setbg = explode(',',$bg);
  

   $background  = imagecolorallocate( $my_imgbg  , $setbg[0], $setbg[1] , $setbg[2]  );    
   imagefill($my_imgbg, 0, 0, $background); 
    $watermark =  @imagecreatefrompng('img/watermark.png');
    imagecopyresampled($my_imgbg, $watermark, 0, 0, 0, 0, 550, 360, 550, 360);
    

    
    if($image_uploadinfo[1] == 'jpg' ){
          $img_crop = imagecreatefromjpeg($imagenew);
     }else if($image_uploadinfo[1] == 'png'){         
        //$img_crop = imagecreatefrompng($imagenew);
        
         $img_crop =  @imagecreatefrompng($imagenew);
        

    }


  
// meach with crop
$imagenew_bg = 'img/upload/'.date('YmdHis').rand('100').'.'.$image_uploadinfo[1];   
    
if($image_uploadinfo[1] == 'png' ){
    $out = imagecreatetruecolor(550, 360);
    imagecopyresampled($out, $my_imgbg, 0, 0, 0, 0, 550, 360, 550, 360);
    imagecopyresampled($out, $img_crop, 95, 10, 0, 0, 360, 340, 360, 340);
   
}else{
  imagecopy($my_imgbg, $img_crop, 95, 10, 0, 0,360, 340);  
    
}
    
    
    
  if($image_uploadinfo[1] == 'jpg' ){
       imagejpeg($my_imgbg, $imagenew_bg, 90);
     }else if($image_uploadinfo[1] == 'png'){   
      imagejpeg($out, $imagenew_bg, 90);
    }
    
 chmod($imagenew_bg, 0777);
 setcookie("photo", $imagenew_bg , time()+3600); 
 unlink('img/upload/crop_buff.jpg');



    
         
}