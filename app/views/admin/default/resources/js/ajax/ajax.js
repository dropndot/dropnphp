var xmlHttp;
function districtFilter(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/admin/default/ajax/district_filter.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = addDistrictFilterState;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function addDistrictFilterState() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("districtFilterId").innerHTML=xmlHttp.responseText;
	} 
}
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
function add_page_url(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/admin/default/ajax/add_page_url.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = addStatePageUr;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function addStatePageUr() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("addPageUrl").innerHTML=xmlHttp.responseText;
	} 
}
function edit_page_url(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/admin/default/ajax/edit_page_url.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = editStatePageUr;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}


function editStatePageUr() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("editPageUrl").innerHTML=xmlHttp.responseText;
	} 
}


function addMenuImg(str) { 
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp==null) {
		alert("Browser does not support HTTP Request");
		return;
	}
	var url="app/views/admin/default/ajax/add_menu_image.php";
	url = url+"?q="+str;
	xmlHttp.onreadystatechange = addMenuStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function addMenuStateChanged() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById("menuImg").innerHTML=xmlHttp.responseText;
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