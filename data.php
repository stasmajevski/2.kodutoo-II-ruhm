<?php

// me peame uhendama lehed, et session tootaks

	require("functions.php");
	// kui ei ole kasutajat id'd
	if(!isset($_SESSION["userID"]))
	{
		//suunan sisselogimise lehele
		header("Location: login.php");
		
		// teper' on ne chitaet kod dalshe
		exit();
	}
	
	//kui on ?logout aadressireal siis login valja
	if(isset($_GET["logout"]))
	{
		session_destroy();
		header("Location: login.php");
	}
	$msg="";
	if(isset($_SESSION["message"]))
	{
		$msg = $_SESSION["message"];	

			// kui uhe naitame siis kustuta ara, et parast refreshi ei naitaks
			unset($_SESSION["message"]);
	}
	
	
	/*if(isset($_POST["carPlate"]) && isset($_POST["carColor"]) && !empty($_POST["carPlate"]) && !empty($_POST["carColor"]))
	{
		saveCar(cleanInput($_POST["carPlate"]),cleanInput($_POST["carColor"]));
	}
	*/
	
	if(isset($_POST["project"]) && isset($_POST["customer"]) && isset($_POST["deadline"]) && isset($_POST["contact"])
		&& !empty($_POST["project"]) && !empty($_POST["customer"]) && !empty($_POST["deadline"]) && !empty($_POST["contact"]))
	{
		//saveCar(cleanInput($_POST["carPlate"]),cleanInput($_POST["carColor"]));
		saveProject(cleanInput($_POST["project"]),cleanInput($_POST["customer"]),cleanInput($_POST["deadline"]),cleanInput($_POST["contact"]));
	}
	
	
	
	//$carData = getAllCars();
	
	$projectDetails = getAllProjectDetails();
	
?>
<link rel="stylesheet" type="text/css" href="style.css">
<!-- lisasin 'Nunito' fonti -->
 <link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>

<?=$msg;?>
<p>Welcome! <?=$_SESSION["userEmail"];?>!</p>
<a href="?logout=1">Logi välja</a>

<form method="POST">
	<h1>Details</h1>
	<label for="project">Project: </label>
	<input name="project" type="text" value=""><br><br>
	
	<label for="customer">Customer: </label>
	<input name="customer" type="text" value=""><br><br>
	
	<label for="deadline">Deadline: </label>
	<input name="deadline" type="date" value=""><br><br>
	
	<label for="contact">Contact: </label>
	<input name="contact" type="text" value=""><br><br>
	
	<input type="submit" value="Save" class="button">
</form>


<!--
<form method="POST">
	<h1>Salvesta autot</h1>
	
    <label for="carPlate">Cars number: </label>
	<input name="carPlate" type="text" value=""><br><br>
    <label for="carColor">Cars color: </label>
	<input name="carColor" type="color"><br><br>
	
	<input type="submit" value="Save car" class="button">
</form>

<h1>Autod</h1>
-->
<?php
$html = "";
	foreach($projectDetails as $project)
	{
		//$html .= "<p>".$project->id."</p>";
		$html .= "<p>".$project->project."</p>";
		$html .= "<p>".$project->customer."</p>";
		$html .= "<p>".$project->deadline."</p>";
		$html .= "<p>".$project->contact."</p>";
		
	}
	echo $html;

?>

<?php
/*
// th - table header
// td - table data
// tr - table row

	$html = "<table style='border:1px solid;margin:0 auto;'>";

	$html .="<tr>";
		$html .="<th>id</th>";
		$html .="<th>plate</th>";
		$html .="<th>color</th>";
	$html .="</tr>";
	
	
	
	// iga liikme kohta masiivis
	foreach($carData as $item)
	{
		// iga auto on $c
	$html .="<tr>";
		$html .="<td style='border:1px solid;'>".$item->id."</td>";
		$html .="<td style='border:1px solid;'>".$item->plate."</td>";
		$html .="<td style='border:1px solid; padding:10px;background-color:".$item->carColor."'>".$item->carColor."</td>";
	$html .="</tr>";
		
	}

	$html .="</table>";
	echo $html;
	
	$listHtml = "<br><br>";
	
	foreach($carData as $item)
	{
		// iga auto on $item
		
		$listHtml .= "<h1 style='color:".$item->carColor."'>".$item->plate."</h1>";
		$listHtml .= "<h1>color = ".$item->carColor."</h1>";
			
	}
	
	echo $listHtml;
?>
*/
