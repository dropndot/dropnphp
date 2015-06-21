var xmlHttp;
function thanaFilter(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/admin/default/ajax/thana_filter.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = addThanaFilterState;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function addThanaFilterState() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("thanaFilterId").innerHTML=xmlHttp.responseText;
	} 
}
function genarate_map(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/public/pedrollo/ajax/genarate_map.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = genarate_map_state;
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);
}

function genarate_map_state() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("mapDisplay").innerHTML=xmlHttp.responseText;
	} 
}
function genarate_map_dealer(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/public/pedrollo/ajax/genarate_map_dealer.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = genarate_map_dealer_state;
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);
}

function genarate_map_dealer_state() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("genarateMapDealer").innerHTML=xmlHttp.responseText;
	} 
}

function GetXmlHttpObject() {
	var xmlHttp=null;
	try {
		// Firefox, Opera 8.0+, Safari
	 	xmlHttp=new XMLHttpRequest();
	}
	catch(e) {
		 //Internet Explorer
		try {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e) {
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}