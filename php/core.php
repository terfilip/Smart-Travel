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
    $country = $_POST['country'];
    if (strpos($country, 'USA') !== false) {
        $country = substr($country,0,2);
    }

  $sql = "SELECT  *, (CPI+RI+CPPRI+GI+RPI+LPP)/6 as `Ranking`,Price from Averages INNER JOIN foodPrice on Averages.Country = foodPrice.Country where Region = '".$region."' order by `Ranking` ASC";
  $currencyq = "SELECT Currency FROM Currs WHERE Country = '".$_POST['country']."'";
    $currencyCodes = mysqli_query($con,$currencyq);
    $result = mysqli_query($con,$sql);

    $originCurrency = mysqli_fetch_array($currencyCodes)['Currency'];
  if($cur_Price == "N/A") {
    while($row = mysqli_fetch_array($result)) {

            //$res = mysqli_query($con,"SELECT Currency FROM Currs WHERE Country = '".$row['Country']."'");
            //$destCurrency = mysqli_fetch_array($res)['Currency'];

            $resVal = get_currency('USD',$originCurrency,$row['Price']);

      echo '<div class="destination-suggestion">';
      echo '<div class="suggestion-content">';
      echo '<h1>' . $row['Country'] . '</h1>';
      echo '<table>';
      echo '<tr>';
        echo '<td class="what">Average Daily Spending</td>';
        echo '<td width="60px">$'.number_format($resVal,2).' '.$originCurrency.'</td>';
        echo '<td>Saving '.number_format($cur_Price-$resVal,2).'</td>';
      echo '</tr>';
      echo '<tr>';
        echo '<td class="what">Predicted Food Holiday Spending</td>';
        echo '<td>'.number_format(($resVal*$time[0]*7),2).' '.$originCurrency.'</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '<div class="suggestion-view-more">';
      echo '</div>';
      echo '</div>';
    }
  } else {
    while($row = mysqli_fetch_array($result)) {

            $resVal = get_currency('USD', $originCurrency, $row['Price']);

      echo '<div class="destination-suggestion">';
      echo '<div class="suggestion-content">';
      echo '<h1>' . $row['Country'] . '</h1>';
      echo '<table>';
      echo '<tr>';
        echo '<td class="what">Average Daily Spending</td>';
        echo '<td>'.number_format($resVal,2).' '.$originCurrency;
        echo '<td> Saving '.number_format(($cur_Price-$resVal),2).' '.$originCurrency.'</td>';
      echo '</tr>';
      echo '<tr>';
        echo '<td class="what">Predicted Food Holiday Spending</td>';
        echo '<td>'.number_format(($resVal*$time[0]*7),2).' '.$originCurrency.'</td>';
      echo '</tr>';
      echo '</table>';
      echo '</div>';
      echo '<div class="suggestion-view-more">';
      echo '</div>';
      echo '</div>';
    }
   }
  }

    function get_currency($from_Currency, $to_Currency, $amount) {
        $amount = urlencode($amount);
        $from_Currency = urlencode($from_Currency);
        $to_Currency = urlencode($to_Currency);

        $url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";

        $ch = curl_init();
        $timeout = 0;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt ($ch, CURLOPT_USERAGENT,
                     "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        $data = explode('bld>', $rawdata);
        $data = explode($to_Currency, $data[1]);

        return round($data[0], 2);
    }

// Call the function to get the currency converted
//echo get_currency('USD', 'INR', 1);
?>