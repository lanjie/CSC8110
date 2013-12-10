<html>
	<head>	
		<title>this is the customers page!</title>
	</head>
	<body>
		<form action="customers.php" method="post" name="customersInfo" >
			<table>
				<tr>
					<td>user name:</td><td><input name="name" type="text"></td>
					<td>user country:</td><td><input name="country" type="text"></td>
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
	if($_POST['submit']){
		$entity = new Entity();
		$entity->setPartitionKey("customer");
		$entity->setRowKey($_POST[name]);
		$entity->addProperty("name", EdmType::STRING, $_POST[name]);
		$entity->addProperty("Location", EdmType::STRING, $_POST[country]);

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
	}
	

?>
<br><br>
<table align="centre" with="80">
<tr><td>user name</td><td>location</td></tr>
<?php
$filter = "PartitionKey eq 'customer'";

try {
    $result = $tableRestProxy->queryEntities("customer", $filter);
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}

$entities = $result->getEntities();

foreach($entities as $entity){
 $name = $entity->getProperty("name")->getValue();
 $location = $entity->getProperty("Location")->getValue();
?>
	<tr><td><?php echo $name?></td><td><?php echo $location?></td></tr>
<?php    
}
?>
</table>
	</body>
</html>
