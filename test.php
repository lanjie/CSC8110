
<?php
function gen_randomstr($n) { 
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, $n);
}

function gen_randomstr1($n) { 
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $n);
}
?>

<?php
	
	
	
	$countryArray=array("United Kingdom", "China", "United States");
	$country = $countryArray[rand(0,2)];
	
	$emailArray=array("@gmail.com", "@hotmail.com", "@yahoo.com");
	$emailtail = $emailArray[rand(0,2)];
	$email = gen_randomstr(8) . $emailtail;
	
	$name = gen_randomstr1(1) . gen_randomstr(rand(2,10)) . " " .gen_randomstr1(1) . gen_randomstr(rand(2,10));

	$SKU= "SKU" . date("YmdHis") . rand(100,999);
?>

<p><?php
	echo $country;
?></p>
<p>
<?php
	echo $email;
?></p>
<?php
	echo $name;
?></p>

<?php
	echo $SKU;
?></p>