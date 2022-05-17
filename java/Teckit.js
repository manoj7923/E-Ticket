{
	function getQueryStringValue (key) {  
                             return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
                             }
							 document.getElementById("data1").innerHTML = getQueryStringValue("stason");
	
}

{
function getQueryStringValue (key) {  
                             return escape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
                             }
							 document.getElementById("sta").innerHTML = getQueryStringValue("data");
}



/* FOR SIDE MANU BAR */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function goBack() {
  window.history.back();
}
