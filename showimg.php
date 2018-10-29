<?php
$img =  $_COOKIE["photo"];

?>

<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/small-business.css" rel="stylesheet">    

        
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
<a class="nav-link" href="crop.php">Home

</a>
</li>

</ul>
</div>
</div>
</nav>


<!-- Page Content -->
<div class="container">
<div class="row my-4">
<img src="<?=$img?>" />

</div>
</div>