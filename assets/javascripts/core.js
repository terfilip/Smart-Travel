//current region
//Visiting region
//Date where they want to go.
$( document ).ready(function() {
	inputSetup();
});

function inputSetup() {
	fetchAndShowCurrentRegions();
	fetchDestinationRegions();
	createCalendarInput();
}
function fetchAndShowCurrentRegions() {
	//AJAX code to retrieve the regions
	$('#curReg').html("<select></select>");
	$.ajax({
		type: 'POST',
		url: "dummy.php",
		context: "Dummy context",
		success: function(data) {
			feedRegions(data);
			console.log("Fetched regions");
		}
	});
	
}
function fetchDestinationRegions() {
	//Just copy the options from the current Regions to avoid multiple PHP calls.
	$('#desReg').html("<select></select>");
}
function createCalendarInput() {
	//This will allow selecting a widget that will allow selecting a date on which.
	$('#date').html('Date: <input type="text" id="datepicker">');
	$('#datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
}
function feedRegions(data) {
	
	selectRegionByIP();
}
function selectRegionByIP() {
	
}

function fetchAndShowCountries() {
	
}

function searchResults() {
	//Retrieve Current
	//Retrieve Destination
	//Retrieve Date
	
	//Show results
}

