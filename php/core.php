<?php
$q = $_POST['q'];
$host = "192.168.1.3";
$username = "root";
$password = "password";
$db = "hackathon";
$con = mysqli_connect($host,$username,$password,$db);
if (!$con)
  {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,$db);

if($q == "getCountries") {
	$sql = "Select Country from Countries";
	$result = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_array($result))
	{
		echo '<option>'.$row['Country'].'</option>';
	}
}

if($q == "getRegions") {
	$sql = "Select Region from Regions";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result))
	{
		echo '<option>'.$row['Region'].'</option>';
	}
}
if($q == "getRankings") {
	$region = $_POST['region'];
	$sql = "SELECT  *, (CPI+RI+CPPRI+GI+RPI+LPP)/6 as `Ranking` from Averages where region = '".$region."' order by `Ranking` ASC";
	
	while($row = mysqli_fetch_array($result))
	{
		echo '<option>'.$row['Region'].'</option>';
	}
}
?>
