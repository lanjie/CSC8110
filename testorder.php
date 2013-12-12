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
	//if(isset($_POST['submit']) && $_POST['submit']){
		//$inputName = $_POST[name];
		
	$filter = "PartitionKey eq 'customer'";
		try {
			$result = $tableRestProxy->queryEntities("customer", $filter);
		}catch(ServiceException $e){
			// Handle exception based on error codes and messages.
			// Error codes and messages are here: 
			// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
			$code = $e->getCode();
			$error_message = $e->getMessage();
			echo $code.": ".$error_message."<br />";
		}
		$entities = $result->getEntities();
		$nameArray = array();
		foreach($entities as $entity1){
			$databaseName = $entity1->getProperty("name")->getValue();
			$nameArray = array_fill(0, 100000, $databaseName);
			each($nameArray);
					//$location = $entity1->getProperty("Location")->getValue();
					//$entity = new Entity();
					//$entity->setPartitionKey("order");
					//$entity->setRowKey($_POST[name]);
					//$entity->addProperty("customer", EdmType::STRING, $_POST[name]);
					//$entity->addProperty("order_id", EdmType::STRING, "1");////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//$entity->addProperty("price", EdmType::STRING, $_POST[price]);
					//$entity->addProperty("location", EdmType::STRING, $location);
					//try{
						//$tableRestProxy->insertEntity("order", $entity);
					//}catch(ServiceException $e){
						// Handle exception based on error codes and messages.
						// Error codes and messages are here: 
						// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
					//	$code = $e->getCode();
					//	$error_message = $e->getMessage();
					//}
					//break;
					
			}//else
				//echo "No customer existed!";
			
		//}
	//}
?>

<?php
//for($i =0;$i<count($nameArray);$i++) { 
//echo $nameArray[$i]." "; 
print_r($nameArray);
//} 
?> 