<html>
<head><script src="js/jquery.min.js"></script>
<script src="js/jquery.Jcrop.js"></script>

<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" href="css/demos.css" type="text/css" />

<style>
    .right{
        position:absolute;
        right:0px;
        
    } 
    .bottom{
        position:absolute;
        bottom:0px;
        
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



if (!empty($crop_img_default)) {
    $status = 'uploaded';
    $tempName = $crop_img_default;
}

$crop_img_width  = (isset($crop_img_width)?$crop_img_width:0);
$crop_img_height = (isset($crop_img_height)?$crop_img_height:0);
?>  

        <script language="Javascript">
            
            var get_w = "<?=$crop_img_width;?>";
            var get_h = "<?=$crop_img_height;?>";
            
    
            var set_x = "{{ $setW }}";
            var set_y = "{{ $setH }}";
            

            
            
            $(function(){              
                $('#cropbox').Jcrop({
                    onSelect: updateCoords, 
                    onChange: updateCoords, 
                    aspectRatio: set_x/set_y,
                      trueSize:[{{$crop_img_width}},{{$crop_img_height}}],
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
                    var resize = $('input[name=resize]:checked').val();
                    var frmcrop = new FormData(document.getElementById("savecorp"));
                    frmcrop.append("label", "WEBUPLOAD");
                    frmcrop.append("resize", resize);
                    $.ajax({
                        type: "POST",
                        url : "<?=$cur_url;?>/Backend/main/cropsave",
                        data :frmcrop,
                        enctype: 'multipart/form-data',
                        processData: false,  // tell jQuery not to process the data
                        contentType: false ,  // tell jQuery not to set contentType
                        success: function(data) {
                            console.log(data); 
                            if(data != 'fail'){
                                var img = "<img src='"+data+"' alt='' border='0' />";
                                opener.document.getElementById('show<?=$setW;?>').innerHTML = img;
                                opener.document.getElementById('crop<?=$setW;?>').value = data;
                                self.close();
                            }
                               
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                        }
                    });
                }
            }

            function checkUpload() {               
                console.log(1);
                return false;
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
                      //top.location.href='crop.php?path={{$path}}&setW={{ $setW }}&setH={{$setH}}&action=upload&resize={{$resize}}';
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

        </script>

    </head>

    <body>

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
            <input type="hidden" id="path" name="path" value="<?=$path; ?>" />
         
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
            <img src="{{ $crop_img_fullpath  }}" id="cropbox" alt="Crop Image" title="Crop Image" border="0"  style="width:1000px;"/>
        </div>
        
        <div style="display: block; margin-top: 20px;">
            <div style="display: block; font-family : Tahoma; font-size : 12px; color : #333333; font-weight : bold;">Preview Image Crop</div>          
            <div style="width:{{ $setW }}px; height:{{ $setH }}px; overflow:hidden;">
                <img src="{{ $crop_img_fullpath  }}" id="preview" alt="Preview Image" title="Preview Image" border="0"  />              
            </div>
        </div>

        <div style="display: block; margin-top: 20px;">
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">X1: <input type="text" size="4" id="xx" name="xx" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">Y1: <input type="text" size="4" id="yy" name="yy" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">X2: <input type="text" size="4" id="xx2" name="xx2" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">Y2: <input type="text" size="4" id="yy2" name="yy2" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">W: <input type="text" size="4" id="ww" name="ww" /></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">H: <input type="text" size="4" id="hh" name="hh" /></label>
        </div>
        
        <div style="display: block; margin-top: 20px;">
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">Resize  </label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">ON    <input type="radio" value="1" name="resize" <?=($resize == "1"?"checked":"")?> ></label>
            <label style="font-family : Tahoma; font-size : 11px; color : #333333; font-weight : normal;">OFF   <input type="radio" value="2" name="resize" <?=($resize == "2"?"checked":"")?> > </label>
            
        </div>
        

    <!-- This is the form that our event handler fills -->
        <form  id="savecorp" >
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" id="x" name="x" value="0" />
            <input type="hidden" id="y" name="y" value="0" />
            <input type="hidden" id="w" name="w" value="0" />
           <input type="hidden" id="path" name="path" value="<?=$path; ?>" />
            <input type="hidden" id="h" name="h" value="0" />
            <input type="hidden" id="src" name="src" value="{{ $crop_img_default }}" />
            <input type="hidden" id="setW" name="setW" value="{{ $setW }}" />
            <input type="hidden" id="setH" name="setH" value="{{ $setH }}" />
            <input type="hidden" id="action" name="action" value="crop" />
            <input type="button" name="CropBT" id="CropBT" value="บันทึกรูปภาพ"  onclick="checkCoords()"/>
        </form>
                
        
        
        
        <!-- This is the form that our event handler fills -->
        <form id="upload_form" enctype="multipart/form-data" >
            <input type="file"   name="upload" id="upload" />
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
    <?php
    }
    ?>
    </body>
</html>