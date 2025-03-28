<?php

	$CommunityName = $_POST['CommunityName'];
	$About = $_POST['About'];
    $Category = $_POST['Category'];
	$email = $_POST['email'];
	$PhoneNumber = $_POST['PhoneNumber'];
	$Requirments = $_POST['Requirments'];

	// Database connection
	$conn = new mysqli('localhost','root','','test3');
	
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
		
	} else {
		
		$stmt = $conn->prepare("insert into host(CommunityName, About, Category, email, PhoneNumber, Requirments) values(?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $CommunityName, $About, $Category, $email, $PhoneNumber, $Requirments);
		$execval = $stmt->execute();
		echo $execval;
		echo "Registration successfully...";
		$stmt->close();
		$conn->close();
		
		// Redirect to a success page after successful registration
		header("Location: host.php?success=1");
		exit();
	}
?>