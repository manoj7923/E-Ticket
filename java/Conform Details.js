{
	function getQueryStringValue (key) {  
                             return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
                             }
							 document.getElementById("date").innerHTML = getQueryStringValue("Station1");
	
}

{
function getQueryStringValue (key) {  
                             return escape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
                             }
							 document.getElementById("data").innerHTML = getQueryStringValue("data");
}

{
	function getQueryStringValue (key) {  
                             return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
                             }
							 document.getElementById("Date1").innerHTML = getQueryStringValue("Date");
	
}
{
    function getElementById (key) {  
                             return escape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
                             }
							 document.getElementById("data2").innerHTML = getQueryStringValue("data2");
}

