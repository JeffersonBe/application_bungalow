var time_variable;

function lookup_nom(inputString) {
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#suggestions1').hide();
	} else {
		$.post("../assets/includes/search1.php", {search1: ""+inputString+""}, function(data){
			if(data.length >0) {
				$('#suggestions1').show();
				$('#autoSuggestionsList1').html(data);
			}
		});
	}
} // lookup

function lookup_prenom(inputString) {
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#suggestions2').hide();
	} else {
		$.post("../assets/includes/search2.php", {search2: ""+inputString+""}, function(data){
			if(data.length >0) {
				$('#suggestions2').show();
				$('#autoSuggestionsList2').html(data);
			}
		});
	}
} // lookup

function fill(x,y,z) {
	$('#nom').val(x);
	$('#prenom').val(y);
	setTimeout("$('#suggestions"+z+"').hide();", 200);
}

function getXMLObject()  //XML OBJECT
{
   var xmlHttp = false;
   try {
     xmlHttp = new ActiveXObject("Msxml2.XMLHTTP")  // For Old Microsoft Browsers
   }
   catch (e) {
     try {
       xmlHttp = new ActiveXObject("Microsoft.XMLHTTP")  // For Microsoft IE 6.0+
     }
     catch (e2) {
       xmlHttp = false   // No Browser accepts the XMLHTTP Object then false
     }
   }
   if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
     xmlHttp = new XMLHttpRequest();        //For Mozilla, Opera Browsers
   }
   return xmlHttp;  // Mandatory Statement returning the ajax object created
}

var xmlhttp = new getXMLObject();	//xmlhttp holds the ajax object

function ajaxFunction() {
  var getdate = new Date();  //Used to prevent caching during ajax call
  if(xmlhttp) {
  	var txtname = document.getElementById("txtname");
    xmlhttp.open("POST","testing.php",true); //calling testing.php using POST method
    xmlhttp.onreadystatechange  = handleServerResponse;
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send("txtname=" + txtname.value); //Posting txtname to PHP File
  }
}

function handleServerResponse() {
   if (xmlhttp.readyState == 4) {
     if(xmlhttp.status == 200) {
       document.getElementById("message").innerHTML=xmlhttp.responseText; //Update the HTML Form element
     }
     else {
        alert("Error during AJAX call. Please try again");
     }
   }
}

chosen=0;
function choose(x)
{
	if(chosen!=0){document.getElementById('cell_'+chosen).style.border= 'none';}
	document.getElementById('bungalow').value=x;
	document.getElementById('cell_'+x).style.border= "solid 5px #2FC61A";
	chosen=x;
}