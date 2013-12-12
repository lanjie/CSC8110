<?php
require_once 'vendor\autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Table\Models\Entity;
use WindowsAzure\Table\Models\EdmType;

// Create table REST proxy.
$connectionString="DefaultEndpointsProtocol=http;AccountName=csc8110one;AccountKey=mXKieL9Ap0id+KhcVQEn5m/Lzpjm9xcHLgTiT9bkHu+6SsaSRyRrm7c/6XQ43jXXjVEIaqnfxcaAvEiiNVzFhQ==";
$tableRestProxy = ServicesBuilder::getInstance()->createTableService($connectionString);

try {
    // Create table.
    $tableRestProxy->createTable("customer");
}
catch(ServiceException $e){
    $code = $e->getCode();
    $error_message = $e->getMessage();
    // Handle exception based on error codes and messages.
    // Error codes and messages can be found here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
}
?>

<?php
function gen_randomstr($n) { 
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, $n);
}

function gen_randomstr1($n) { 
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $n);
}
?>

<?php
	
	for($i = 0; $i < 100; $i++){
	
	$countryArray=array("United Kingdom", "China", "United States");
	$country = $countryArray[rand(0,2)];
	
	$emailArray=array("@gmail.com", "@hotmail.com", "@yahoo.com");
	$emailtail = $emailArray[rand(0,2)];
	$email = gen_randomstr(8) . $emailtail;
	
	$name = gen_randomstr1(1) . gen_randomstr(rand(2,10)) . " " .gen_randomstr1(1) . gen_randomstr(rand(2,10));



	//if(isset($_POST['submit']) && $_POST['submit']){
		$entity = new Entity();
		$entity->setPartitionKey("customer");
		$entity->setRowKey($email);
		$entity->addProperty("name", EdmType::STRING, $name);
		$entity->addProperty("Location", EdmType::STRING, $country);

		try{
			$tableRestProxy->insertEntity("customer", $entity);
		}
		catch(ServiceException $e){
			// Handle exception based on error codes and messages.
			// Error codes and messages are here: 
			// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
			$code = $e->getCode();
			$error_message = $e->getMessage();
		}
	//}
	}

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