var Util = function(){
	
};
Util.prototype.xhr = function(url,method,data,callback){
	var xmlhttp;
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	 }
	else if (window.ActiveXObject){
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (xmlhttp!=null){
	  xmlhttp.onreadystatechange=state_Change;
	  xmlhttp.open(method,url,true);
	  xmlhttp.send(data);
	}else{
	  alert("Your browser does not support XMLHTTP.");
	}

	function state_Change()
	{
	if (xmlhttp.readyState==4)
	  {// 4 = "loaded"
	  if (xmlhttp.status==200)
		{// 200 = OK
            console.log(xmlhttp.responseText)
			callback(xmlhttp.responseText);
		}
	  else
		{
		alert("Problem retrieving XML data");
		}
	  }
	}
}