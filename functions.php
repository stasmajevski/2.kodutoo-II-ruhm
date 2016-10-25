<?php
require("../../config.php");
  
	//!!!!!!!!!!
	// see file peab olema koigil lehtedel kus tahan kasutada SESSION muutujat
	session_start();
	
	
	
	function signUp($email,$password,$birthday,$gender)
	{
		// UHENDUS
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli rida
		$stmt = $mysqli->prepare("INSERT INTO login (email,password,birthday,gender) VALUES (?,?,?,?)");
		
		
		echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		$stmt->bind_param("ssss",$email,$password,$birthday,$gender); // sest on email ja password VARCHAR - STRING , ehk siis email - s, password - sa
		
		//täida käsku
		if($stmt->execute())
		{
			echo "salvsestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		//panen ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}
	
	function saveCar($carNumber,$carColor)
	{
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli rida
		$stmt = $mysqli->prepare("INSERT INTO car_and_colors (plate,color) VALUES (?,?)");
		
		
		echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		$stmt->bind_param("ss",$carNumber,$carColor); // sest on email ja password VARCHAR - STRING , ehk siis email - s, password - sa
		
		//täida käsku
		if($stmt->execute())
		{
			echo "salvsestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		//panen ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}
	
	
	function saveProject($project,$customer,$deadline,$contact)
	{
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$mysqli->set_charset("utf8");
		// sqli rida
		$stmt = $mysqli->prepare("INSERT INTO project_details (project,customer,deadline,contact) VALUES (?,?,?,?)");
		
		
		echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		$stmt->bind_param("ssss",$project,$customer,$deadline,$contact);
		
		//täida käsku
		if($stmt->execute())
		{
			echo "salvsestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		//panen ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	function login ($email,$password)
	{
		$error = "";
		
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli rida
		$stmt = $mysqli->prepare("SELECT id,email,password FROM login WHERE email = ?");
		
		
		echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
		
		// asenad kusimargi
		$stmt ->bind_param("s",$email);
		
		//maaran vaartused muutujatesse
		$stmt ->bind_result($id,$emailFromDb,$passwordFromDb);
		// tehakse paring
		$stmt ->execute();
		
		// kas tulid andmed andmebaasist voi mitte
		// on toene kui on vahemalt uks vaste
		if($stmt->fetch())
		{
			// oli sellise meiliga kasutaja
			
			//password millega kasutaja tahab sise logida
			$hash = hash("sha512",$password); // sha512 algoritm
			
			if($hash == $passwordFromDb && $email == $emailFromDb)
			{
				echo "Kasutaja logis sisse ".$id;
				
				//maaran sessiooni muutujad, millele saan ligi teestelt lehtedelt
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				exit();
				
			}
			else
			{
				$error = "vale email või parool";
			}
		}
		else
		{
			// ei leidnud kasutajat selle meiliga
			$error = "vale email voi parool";
		}
		
		return $error;
	}
	
	
	function getAllCars()
	{
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli rida
		$stmt = $mysqli->prepare("SELECT id,plate,color FROM car_and_colors");
		
		//maaran vaartused muutujatesse
		
		$stmt ->bind_result($id,$plate,$color);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result=array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		//fetch annab andmeid uhe rea kaupa
		while($stmt->fetch())
		{
			//tekitan objekti
			$car = new StdClass();
			
			$car->id = $id;
			$car->plate = $plate;
			$car->carColor = $color;
			
			//echo $plate."<br>";
			//iga kord massiivi lisan juurde nr. m2rgi
			array_push($result,$car);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function deleteProject()
	{
			$database = "if16_stanislav";
				$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
				$mysqli->set_charset("utf8");
				// sqli rida
				$dealID = $_GET['remove'];
				$stmt = $mysqli->prepare("UPDATE  project_details SET deleted=NOW() WHERE id = '$dealID'");
				
				
				echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
				
				
				//täida käsku
				if($stmt->execute())
				{
					echo "salvsestamine õnnestus";
				}
				else
				{
					echo "ERROR ".$stmt->error;
				}
				
				//panen ühenduse kinni
				$stmt->close();
				$mysqli->close();
		
	}
	function updateProject($project,$customer,$deadline,$contact)
	{
		
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$mysqli->set_charset("utf8");
		// sqli rida
		$dealID = $_GET['edit'];
		
		$stmt = $mysqli->prepare("UPDATE  project_details SET project='$project', customer='$customer', deadline='$deadline',contact='$contact' WHERE id = '$dealID'");
		
		echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
				
				
				//täida käsku
				if($stmt->execute())
				{
					echo "salvsestamine õnnestus";
				}
				else
				{
					echo "ERROR ".$stmt->error;
				}
				
				//panen ühenduse kinni
				$stmt->close();
				$mysqli->close();
	}
	
	function getAllProjectDetails()
	{
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		$mysqli->set_charset("utf8");
		
		// sqli rida
		$stmt = $mysqli->prepare("SELECT id,project,customer,deadline,contact FROM project_details WHERE deleted IS NULL ORDER BY deadline ASC");
		
		//maaran vaartused muutujatesse
		
		$stmt ->bind_result($id,$project,$customer,$deadline,$contact);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result=array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		//fetch annab andmeid uhe rea kaupa
		while($stmt->fetch())
		{
			//tekitan objekti
			$proj = new StdClass();
			
			$proj->id = $id;
			$proj->project = $project;
			$proj->customer = $customer;
			$proj->deadline = $deadline;
			$proj->contact = $contact;
			
			//echo $plate."<br>";
			//iga kord massiivi lisan juurde nr. m2rgi
			array_push($result,$proj);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
			
	function cleanInput($input)
	{
		$input = trim($input);
		$input = htmlspecialchars($input);
		$input = stripslashes($input);
		
		return $input;
	}
	
	
	
	
	
	
?>