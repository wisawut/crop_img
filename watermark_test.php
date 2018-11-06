<?php
include('watermark.php');
$watermark = new Zubrag_watermark();

                        $watermark->setImagePath( 'img/test2.jpg' ) ;
						$watermark->ApplyWatermark( 'img/Sale-PNG.png' );
						$watermark->SaveAsFile( 'img/test.png' );
						$watermark->Free();	


?>