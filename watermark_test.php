<?php
include('watermark.php');
$watermark = new Zubrag_watermark();

                        $watermark->setImagePath( 'img/test2.jpg' ) ;
						$watermark->ApplyWatermark( 'img/watermark.png' );
						$watermark->SaveAsFile( 'img/test.png' );
						$watermark->Free();	


?>