<html>
<head>
<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/small-business.css" rel="stylesheet">    
    
<script src="js/jquery.min.js"></script>
<script src="js/jquery.Jcrop.js"></script>

<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" href="css/demo.css" type="text/css" />

    
    




<style>
    .right{
        position:absolute;
        right:0px;
        
    } 
    .bottom{
        position:absolute;
        bottom:0px;
        
    }
    .pixel{
        display: inline-block;
        width:20px; height: 20px;  
        border:1px solid #333;
    }
    .yellow{ background:RGB(255,220,0 ) ; }
    .navy{ background:RGB(0,31,63 ) ; }
    .aqua{ background:RGB(127,219,255) ; }
    .olive{ background:RGB(61,153,112) ; }
    .lime{ background:RGB(1,255,112) ; }
    .orange{ background:RGB(255,133,27) ; }
    .maroon{ background:RGB(133,20,75) ; }
    .purple{ background:RGB(177,13,201) ; }
    .gray{ background:RGB(170,170,170) ; }
    .blue{ background:RGB(0,116,217) ; }
    .teal{ background:RGB(57,204,204) ; }
    .green{ background:RGB(46,204,64) ; }
    .red{ background:RGB(250, 15, 46) ; }
    .fuchsia{ background:RGB(240,18,190) ; }
    .black{ background:RGB(17,17,17) ; }
    .silver{ background:RGB(221,221,221) ; }
    .white{ background:RGB(255,255,255) ; }
 
 
    
    
    ul#bg li {display:inline;}
    td{  width:80px; height:30px; cursor: pointer;  margin:5px; border: 1px solid #FFF;}
    table#colorTable {
    border-collapse:collapse;
}
</style>

<?php


$width = 0;
$height = 0;
$status = '';
$tempName = '';
$new_file = '';
$url_file = '';
$max_width = 853;
$max_height = 480;
$new_file_path = '';


$crop_img_default =  (isset($_COOKIE["tmp_photo"])?$_COOKIE["tmp_photo"]:null);
    
if (!empty($crop_img_default)) {
    $status = 'uploaded';
    $tempName = $crop_img_default;
    
    $imginfo = getImageSize($crop_img_default);
}

$crop_img_width  = (isset($imginfo[0])?$imginfo[0]:0);
$crop_img_height = (isset($imginfo[1])?$imginfo[1]:0);
 
    
$setW =360;
$setH = 340;
$getscalling = 1;    
if(isset($_GET['scall']) && $_GET['scall'] ==2 ){
    $getscalling = 2;   
    $setW =458;
    $setH = 300;
}else{
    $setW =360;
    $setH = 340;
} 

    
    

    
$marleft = ceil( (550-$setW)/2);
$martop = ceil( (360-$setH)/2);
?>  
<script language="Javascript">
            
            var get_w = "<?=$crop_img_width;?>";
            var get_h = "<?=$crop_img_height;?>";            
    
            var set_x = "<?= $setW ?>";
            var set_y = "<?= $setH ?>";
        
            
             var jcrop_api ;
    
            $(function(){     
                
                

             jcrop_api = $('#cropbox').Jcrop({
                    onSelect: updateCoords, 
                    onChange: updateCoords, 
                     aspectRatio: set_x/set_y,
                
                   trueSize:[<?=$crop_img_width ?>,<?=$crop_img_height?> ],
                });
                
            
         
            });



            
            function updateCoords(c) {                
             
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);

                var rx = set_x / c.w;
                var ry = set_y / c.h;
             
                $('#preview').css({
                    width: Math.round(rx * get_w) + 'px',
                    height: Math.round(ry * get_h) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });

                $('#xx').val(c.x);
                $('#yy').val(c.y);
                $('#xx2').val(c.x2);
                $('#yy2').val(c.y2);
                $('#ww').val(c.w);
                $('#hh').val(c.h);
            };      

            function checkCoords() {
                if (!parseInt($('#w').val())) {
                    alert('กำหนดพื้นที่ภาพที่ต้องการ crop.');
                    return false;
                }else{
                 
                    var frmcrop = new FormData(document.getElementById("savecorp"));
                    frmcrop.append("label", "WEBUPLOAD");                  
                    $.ajax({
                        type: "POST",
                        url : "savecrop.php",
                        data :frmcrop,
                        enctype: 'multipart/form-data',
                        processData: false,  // tell jQuery not to process the data
                        contentType: false ,  // tell jQuery not to set contentType
                        success: function(data) {
                            //console.log(data); return false;
                            if(data != 'fail'){
                              top.location.href='showimg.php';
                            }
                               
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                        }
                    });
                }
            }

function checkUpload() {             


var frm = new FormData(document.getElementById("upload_form"));
frm.append("label", "WEBUPLOAD");
$.ajax({
    type: "POST",
    url : "process.php",
    data :frm,
    enctype: 'multipart/form-data',
    processData: false,  // tell jQuery not to process the data
    contentType: false ,  // tell jQuery not to set contentType
    success: function(data) {               
    
    if(data == '1'){
    top.location.href='crop.php?path=&setW=<?=$setW ?>&setH=<?=$setH?>&action=upload&resize=0';
    }else{
    alert('upload fail');
    }
    }
});

}

            

function insertImage() {
if ($('#file_upload').val() != "") {
    document.getElementById("hide_insert").value = "insert";
    document.forms["formInsert"].submit();
    return true;
} else {
    alert('เลือกภาพอัพโหลด.');
    return false;
}               
}
    
function swcolor(e){
    console.log(e);
    $('#previewbg').css('background-color', 'rgba('+e+')');
    $('#frmbg').val(e);
}
function swscalling(e){
    console.log(e);
     
top.location.href="crop.php?scall="+e
    
    
       // initJcrop();
		
	
    
    
}
</script>
    
    </head>

    <body>
        
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
<div class="container">
<a class="navbar-brand" href="#">Crop Image</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarResponsive">
<ul class="navbar-nav ml-auto">
<li class="nav-item active">
<a class="nav-link" href="#">Home
<span class="sr-only">(current)</span>
</a>
</li>

</ul>
</div>
</div>
</nav>

  <!-- Page Content -->
    <div class="container">
        
   <div class="row my-4"> 
    <?php
    if(empty($status)) {
    ?>
    <div id="outer">
    <div class="jcExample">
    <div class="article">
        
        <!-- This is the form that our event handler fills -->
        <form id="upload_form" enctype="multipart/form-data" >
            <input type="file"   name="upload" id="upload" />   
            <input type="button" value="อัพโหลดรูปนี้" onclick="checkUpload()"/>
            <input type="hidden" name="action" id="action" value="upload" />
            <input type="hidden" id="setW" name="setW" value="<?=$setW; ?>" />
            <input type="hidden" id="setH" name="setH" value="<?=$setH; ?>" />
      
         
            <br />
            <label>ชื่อภาพต้องเป็นภาษาอังกฤษเท่านั้น.</label>
        </form>
    </div>
    </div>
    </div>
    <?php
    } else {
    ?>

    <div id="outer">
    <div class="jcExample">
    <div class="article">
        
        
        
        <div style=" margin-top: 20px;">
            <div style="float:left; margin:10px;"> 
            <div style="cursor:pointer;width:80px; height:80px; border:1px solid #333; background:#EEE;" onclick="swscalling('1')"></div>
            <input type="radio" name="scalling"  value="1"  <?=($getscalling==1?'checked':'')?>    onchange="swscalling(this.value)" /> <br>
            </div>
           <div style="float:left; margin:10px;">
               <div style="cursor:pointer; width:120px; height:80px; border:1px solid #333;  background:#EEE;"  onclick="swscalling('2')" ></div>
            <input type="radio" name="scalling"  value="2"     <?=($getscalling==2?'checked':'')?>  onchange="swscalling(this.value)"   /> <br>
            </div>
            <div style="clear:both;"></div>
              
        </div>
        
        
        
        <!-- This is the image we're attaching Jcrop to -->
        <div style="display: block;" >
            <img src="<?= $crop_img_default  ?>" id="cropbox" alt="Crop Image" title="Crop Image" border="0"  style="width:1000px;"/>
        </div>
        
        <div style="display: block; margin-top: 20px;">
            <div  style="display: block; font-family : Tahoma; font-size : 12px; color : #333333; font-weight : bold;">Preview Image Crop</div> <div  id="previewbg" style="width:550px; height:360px; padding:<?=$martop?>px <?=$marleft?>px; background:RGB(254,  186,   26 ); float:left;" >  
            <div style="width:<?=$setW ?>px; height:<?=$setH ?>px; overflow:hidden;">
                <img src="<?= $crop_img_default  ?>" id="preview" alt="Preview Image" title="Preview Image" border="0"  />              
            </div>
            </div>
            
            <div style="float:left; margin-left:20px;">
                <table id="colorTable">
                    <tr>
                        <td  class="yellow"     onclick="swcolor('255,220,0')" >                    YELLOW      
                            <!--<input type="radio" checked  name="colorbg" onchange="swcolor(this.value)" value="254,186,26">-->
                        </td>
                        <td class="navy"   onclick="swcolor('0,31,63')">
                            NAVY
                            <!--<input type="radio"  name="colorbg" onchange="swcolor(this.value)"  value=" 244,66,66">-->
                        </td>
                    
                    </tr>
                    
                    <tr>
                        <td  class="aqua"     onclick="swcolor('127,219,255')" >            AQUA
                        </td>
                        <td class="olive"   onclick="swcolor('61,153,112')">  
                            OLIVE
                        </td>
                    </tr>
                    <tr>
                    <td  class="lime"     onclick="swcolor('1,255,112')" >LIME
                    </td>
                    <td class="orange"   onclick="swcolor('255,133,27')">                ORANGE
                    </td>
                    </tr>
                    
                    <tr>
                    <td  class="maroon"  onclick="swcolor('133,20,75')" >MAROON
                    </td>
                    <td class="purple"   onclick="swcolor('177,13,201')"> PURPLE
                    </td>
                    </tr>
                    
                    <tr>
                    <td  class="gray"  onclick="swcolor('170,170,170')" >GRAY
                    </td>
                    <td class="blue"   onclick="swcolor('0,116,217')"> BLUE
                    </td>
                    </tr>
                    
                    <tr>
                    <td  class="teal"  onclick="swcolor('57,204,204')" >TEAL
                    </td>
                    <td class="green"   onclick="swcolor('46,204,64')"> GREEN
                    </td>
                    </tr>
                    <tr>
                    <td  class="red"  onclick="swcolor('250, 15, 46')" >RED
                    </td>
                    <td class="fuchsia"   onclick="swcolor('240,18,190')"> FUCHSIA
                    </td>
                    </tr>
                     <tr>
                    <td  class="black"  onclick="swcolor('17,17,17')" >BLACK
                    </td>
                    <td class="silver"   onclick="swcolor('221,221,221')"> SILVER
                    </td>
                    </tr>
                    <tr>
                    <td  class="white"  onclick="swcolor('255,255,255')" >WHITE
                    </td>
                    <td class="white"   onclick="swcolor('255,255,255')"> 
                    </td>
                    </tr>
                    
                    
                </table>
            </div>
            <div style="clear:both;"></div>
        </div>

     
        <div style=" margin-top: 20px;">
           <ul  id="bg">
               <li><span class="pixel orenge"></span> <input type="radio" checked  name="colorbg" onchange="swcolor(this.value)" value="254,186,26"></li>
               <li><span class="pixel red"></span> <input type="radio"  name="colorbg" onchange="swcolor(this.value)"  value=" 244,66,66"></li>
               <li><span class="pixel white"></span> <input type="radio" name="colorbg" onchange="swcolor(this.value)" value="255,255,255"></li>
               <li><span class="pixel black"></span> <input type="radio" name="colorbg" onchange="swcolor(this.value)"  value="0,0,0"></li>
           </ul>
        </div>
        
   

        
        
      
        

    <!-- This is the form that our event handler fills -->
        <form  id="savecorp" >
         
            <input type="hidden" id="x" name="x" value="0" />
            <input type="hidden" id="y" name="y" value="0" />
            <input type="hidden" id="w" name="w" value="0" />          
            <input type="hidden" id="h" name="h" value="0" />
            <input type="hidden" id="src" name="src" value="<?= $crop_img_default ?>" />
            <input type="hidden" id="setW" name="setW" value="<?=$setW ?>" />
            <input type="hidden" id="setH" name="setH" value="<?= $setH ?>" />
            <input type="hidden" id="action" name="action" value="crop" />
            <input type="hidden" id="frmbg" name="bgcolor" value="254,186,26" />
            <input type="hidden"  name="scalling" value="<?=$getscalling?>" />
            <input type="button" name="CropBT" id="CropBT" value="บันทึกรูปภาพ"  onclick="checkCoords()"/>
        </form>
                
        
        
        
        <!-- This is the form that our event handler fills -->
       
        <div class="col-md-8 mb-4 card ">
               <form id="upload_form" enctype="multipart/form-data" >
            <input type="file"   name="upload" id="upload" />
          
            <input type="hidden" name="action" id="action" value="upload" />
            <input type="hidden" id="setW" name="setW" value="<?=$setW; ?>" />
            <input type="hidden" id="setH" name="setH" value="<?=$setH; ?>" />
            <input type="hidden" id="path" name="path" value="<?=$path; ?>" />
            <input type="button" value="อัพโหลดรูปนี้" onclick="checkUpload()"/>
            <br />
            <label>ชื่อภาพต้องเป็นภาษาอังกฤษเท่านั้น.</label>
        </form> 
        </div>
       
       
    </div>
    </div>
    </div>
    <?php
    }
    ?>
        
   </div>      
   </div>      
        
    </body>
</html>