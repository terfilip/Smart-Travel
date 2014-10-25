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
	$sql = "SELECT  *, (CPI+RI+CPPRI+GI+RPI+LPP)/6,Price as `Ranking` from Averages INNER JOIN foodPrice on Averages.Country = foodPrice.Country where Region = '".$region."' order by `Ranking` ASC";
	echo $sql;
	$result = mysqli_query($con,$sql);
	echo "<table>";
	echo '<tr>';
		echo '<th class = "Country">Country</th>';
		echo '<th class = "CPI">CPI</th>';
		echo '<th class = "RI">RI</th>';
		echo '<th class = "CPPRI">CPPRI</th>';
		echo '<th class = "GI">GI</th>';
		echo '<th class = "RPI">RPI</th>';
		echo '<th class = "LPP">LPP</th>';
		echo '<th class = "Ranking">Ranking</th>';
		echo '<th class = "Price">Price</th>';
		echo '</tr>'; 
	while($row = mysqli_fetch_array($result))
	{
		echo '<tr>';
		echo '<td class = "Country">'.$row['Country'].'</td>';
		echo '<td class = "CPI">'.$row['CPI'].'</td>';
		echo '<td class = "RI">'.$row['RI'].'</td>';
		echo '<td class = "CPPRI">'.$row['CPPRI'].'</td>';
		echo '<td class = "GI">'.$row['GI'].'</td>';
		echo '<td class = "RPI">'.$row['RPI'].'</td>';
		echo '<td class = "LPP">'.$row['LPP'].'</td>';
		echo '<td class = "Ranking">'.$row['Ranking'].'</td>';
		echo '<td class = "Price">'.$row['Price'].'</td>';
		echo '</tr>';
	}
	echo "</table>";
}
?>
