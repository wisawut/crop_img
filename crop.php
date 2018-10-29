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
    .orenge{ background:RGB(254,  186,   26 ) ; }
    .black { background:RGB(0,  0,   0 ) ; }
    .white { background:RGB(255,  255,  255 ) ; }
    .red   { background:RGB( 244,  66,  66 ) ; }
    ul#bg li {
    display:inline;
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
?>  
<script language="Javascript">
            
            var get_w = "<?=$crop_img_width;?>";
            var get_h = "<?=$crop_img_height;?>";            
    
            var set_x = "<?= $setW ?>";
            var set_y = "<?= $setH ?>";
            

            
            
            $(function(){              
                $('#cropbox').Jcrop({
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
        
        <!-- This is the image we're attaching Jcrop to -->
        <div style="display: block;">
            <img src="<?= $crop_img_default  ?>" id="cropbox" alt="Crop Image" title="Crop Image" border="0"  style="width:1000px;"/>
        </div>
        
        <div style="display: block; margin-top: 20px;">
            <div  style="display: block; font-family : Tahoma; font-size : 12px; color : #333333; font-weight : bold;">Preview Image Crop</div>        <div  id="previewbg" style="width:550px; height:360px; padding:10px 95px; background:RGB(254,  186,   26 )  ;">  
            <div style="width:<?=$setW ?>px; height:<?=$setH ?>px; overflow:hidden;">
                <img src="<?= $crop_img_default  ?>" id="preview" alt="Preview Image" title="Preview Image" border="0"  />              
            </div>
            </div>
        </div>

        <div style="display: none; margin-top: 20px;">
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">X1: <input type="text" size="4" id="xx" name="xx" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">Y1: <input type="text" size="4" id="yy" name="yy" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">X2: <input type="text" size="4" id="xx2" name="xx2" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">Y2: <input type="text" size="4" id="yy2" name="yy2" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">W: <input type="text" size="4" id="ww" name="ww" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">H: <input type="text" size="4" id="hh" name="hh" /></label>
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
            <input type="button" name="CropBT" id="CropBT" value="บันทึกรูปภาพ"  onclick="checkCoords()"/>
        </form>
                
        
        
        
        <!-- This is the form that our event handler fills -->
       
        <div class="col-md-4 mb-4 card ">
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