<?php
    
    /*
		Title Function That Echo The Page Title In Case The Page Has The Variable $pageTitle And Echo Default Title For Other Pages
	*/

	function getTitle()
	{
		global $pageTitle;
		if(isset($pageTitle))
			echo $pageTitle.' | Aerobook Func';
		else
			echo "Aerobook|func";
	}

    function countItems($item,$table)
	{
		global $con;
		$stat_ = $con->prepare("SELECT COUNT($item) FROM $table");
		$stat_->execute();
		
		return $stat_->fetchColumn();
	}

	function checkItem($select, $from, $value)
	{
		global $con;
		$statment = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
		$statment->execute(array($value));
		$count = $statment->rowCount();
		
		return $count;
	}

	function test_input($data) 
	{
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}

	if (isset($_POST['car_id'])) {
		$carId = $_POST['car_id'];
	
		// Connect to the database
		include 'car-brands.php'; // Make sure the database connection is correct
	
		$sql = "DELETE FROM cars WHERE car_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $carId);
	
		if ($stmt->execute()) {
			echo "success"; 
			echo "error"; 
		}
	
		$stmt->close();
		$conn->close();
	}
	?>
	



