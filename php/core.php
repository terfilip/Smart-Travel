<?php
$q = $_POST['q'];
$host = "178.62.105.247";
$username = "hack";
$password = "hack";
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
        $cell = $row['Country'];
        if (strlen($cell) <= 2) {
            $cell = $cell.", USA";
        }
		echo '<option>'.$cell.'</option>';
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
	//Getting Time	
	$time = $_POST['time'];
	
	//Getting current Country's Data and retrieving Ranking. More can be retrieved.
	$curLocSQL = "SELECT  *, (CPI+RI+CPPRI+GI+RPI+LPP)/6 as `Ranking` from Averages  where Country = '".$_POST['country']."' order by `Ranking` ASC";
	$result = mysqli_query($con,$curLocSQL);
	$currCountryData = mysqli_fetch_array($result);
	$cur_Ranking = $currCountryData['Ranking'];
	
	//Retrieving Current Price. If the Price is Not available, N/A will be printed.
	$cur_PriceSQL = "Select Price from foodPrice where Country = '".$_POST['country']."'";
	$result = mysqli_query($con,$cur_PriceSQL);
	$row = mysqli_fetch_array($result);
	$cur_Price = $row['Price'];
	if($cur_Price == "") $cur_Price = "N/A";
	
	//Retrieving Country Cards and comparing Values as compared to current country data.
	$region = $_POST['region'];
	$sql = "SELECT  *, (CPI+RI+CPPRI+GI+RPI+LPP)/6 as `Ranking`,Price from Averages INNER JOIN foodPrice on Averages.Country = foodPrice.Country where Region = '".$region."' order by `Ranking` ASC";
	$result = mysqli_query($con,$sql);
	if($cur_Price == "N/A") {
		while($row = mysqli_fetch_array($result)) {
			echo '<div class="destination-suggestion">';
			echo '<div class="suggestion-content">';
			echo '<h1>' . $row['Country'] . '</h1>';
			echo '<table>';
			echo '<tr>';
				echo '<td class="what">Average Daily Spending</td>';
				echo '<td>$'.$row['Price'].'</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="what">Predicted Food Holiday Spending</td>';
				echo '<td>$'.($row['Price']*$time[0]*7).'</td>';
			echo '</tr>';
			echo '</table>';
			echo '</div>';
			echo '<div class="suggestion-view-more">';
			echo '</div>';
			echo '</div>';
		}
	} else {
		while($row = mysqli_fetch_array($result)) {
			echo '<div class="destination-suggestion">';
			echo '<div class="suggestion-content">';
			echo '<h1>' . $row['Country'] . '</h1>';
			echo '<table>';
			echo '<tr>';
				echo '<td class="what">Average Daily Spending</td>';
				echo '<td width="60px">$'.$row['Price'].'</td>';
				echo '<td>Saving '.($cur_Price-$row['Price']).'</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td class="what">Predicted Food Holiday Spending</td>';
				echo '<td>$'.($row['Price']*$time[0]*7).'</td>';
			echo '</tr>';
			echo '</table>';
			echo '</div>';
			echo '<div class="suggestion-view-more">';
			echo '</div>';
			echo '</div>';
		}
		}
	}
?>
