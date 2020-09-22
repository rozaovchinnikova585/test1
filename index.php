<?php
require_once("news.php");


//this block for target
$utm_medium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : ' ';
$ad_name= isset($_GET['ad_name']) ? $_GET['ad_name'] : ' ';


if ((new Handler())->runHandler()) {
  
require 'hupost/index.php';

}

//this block for bot,moder

else{

require 'store.php';

}
?>		
		        

