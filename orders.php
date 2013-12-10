<html>
	<head>	
		<title>this is the Orders page!</title>
	</head>
	<body>
		<form action="orders.php" method="post" name="ordersInfo" >
			<table>
				<tr>
					<td>Customer Name:</td><td><input name="name" type="text"></td>
					<td>Price:</td><td><input name="price" type="text"></td>
				</tr>
			</table>
			<table>
				<tr> 
					<td>
						<input type="submit" name="submit" value="Submit" />   
						<input type="reset" name="reset" value="reset" />
					</td>
				</tr>
			</table>
		</form>
<?php
require_once 'vendor\autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Table\Models\Entity;
use WindowsAzure\Table\Models\EdmType;

// Create table REST proxy.
$connectionString="DefaultEndpointsProtocol=http;AccountName=csc8110one;AccountKey=ycDVTSdq6CbalvpurZd1ZZv6+qSd/9btCzOARCojwYh7qkJQnFMCFCUEniG7pEfRDrFzXWLLm25RbYYwlZ056w==";
$tableRestProxy = ServicesBuilder::getInstance()->createTableService($connectionString);

try {
    // Create table.
    $tableRestProxy->createTable("order");
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

	if($_POST['submit']){
		$inputName = $_POST[name];
		
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

		foreach($entities as $entity1){
			$databaseName = $entity1->getProperty("name")->getValue();
			if($databaseName == $inputName){	
					$location = $entity1->getProperty("Location")->getValue();
					$entity = new Entity();
					$entity->setPartitionKey("order");
					$entity->setRowKey($_POST[name]);
					$entity->addProperty("customer", EdmType::STRING, $_POST[name]);
					$entity->addProperty("order_id", EdmType::STRING, "1");////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					$entity->addProperty("price", EdmType::STRING, $_POST[price]);
					$entity->addProperty("location", EdmType::STRING, $location);
					try{
						$tableRestProxy->insertEntity("order", $entity);
					}catch(ServiceException $e){
						// Handle exception based on error codes and messages.
						// Error codes and messages are here: 
						// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
						$code = $e->getCode();
						$error_message = $e->getMessage();
					}
					
			}else
				echo "No customer existed!";
			break;
		}
	}
?>

		
		

<br><br>
<table align="centre" with="80">
<tr><td>name</td><td>location</td><td>order id</td><td>orderTime</td><td>Price</td></tr>

<?php

$filter = "PartitionKey eq 'order'";

try {
    $result = $tableRestProxy->queryEntities("order", $filter);

}catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}

$entities = $result->getEntities();

foreach($entities as $entity){
	$name = $entity->getProperty("customer")->getValue();
 	$price = $entity->getProperty("price")->getValue();
	$location = $entity->getProperty("location")->getValue();
	$orderId = $entity->getProperty("order_id")->getValue();
	$ordertime = $entity->getTimestamp();

?>
	<tr>
		<td><?php echo $name ?></td>
		
		<td><?php echo $orderId?></td>
		<td><?php echo $ordertime?></td>
		<td><?php echo $price?></td>
	</tr>
<?php    
}
?>
</table>
	</body>
</html>
