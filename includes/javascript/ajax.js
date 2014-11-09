var loadcomp = 0;
var catlist = 0;
var g_menu = '';
var imgid = 0;
var pageman = 0;
var bulkload = 0;
var manorder = 0;
var sessionid = 0;
function getHTTPObject()
{
	var xmlhttp;
	/*@cc_on
	@if(@_jscript_version >=5)
	try
	{
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			xmlhttp=false;
		}
	}
	@else
		xmlhttp=false;
	@end @*/
	if(!xmlhttp && typeof XMLHttpRequest != 'undefined')
	{
		try
		{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)
		{
			xmlhttp=false;
		}
	}
	return xmlhttp;
}

function xmlhttpPost(strURL, strSubmit, strResultFunc) {
	//alert(strURL);
   var xmlHttpReq = false;

        // Mozilla/Safari
        if (window.XMLHttpRequest) {
                xmlHttpReq = new XMLHttpRequest();
                //xmlHttpReq.overrideMimeType('text/xml');
        }
        // IE
        else if (window.ActiveXObject) {
                xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
        }

	xmlHttpReq.open('POST', strURL, true);
	xmlHttpReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttpReq.onreadystatechange = function() {
	if (xmlHttpReq.readyState == 4) {
           strResponse = xmlHttpReq.responseText;
           switch (xmlHttpReq.status) {
                   // Page-not-found error
                   case 404:
                           alert('Error: Not Found. The requested URL ' +
                                   strURL + ' could not be found.');
                           break;
                   // Display results in a full window for server-side errors
                   case 500:
                           handleErrFullPage(strResponse);
                           break;
                   default:
                           // Call JS alert for custom error or debug messages
                           if (strResponse.indexOf('Error:') > -1 ||
                                   strResponse.indexOf('Debug:') > -1) {
                                   alert(strResponse);
                           }
                           // Call the desired result function
                           else {
                                   eval(strResultFunc + '(strResponse);');
                           }
                           break;
           }
   }
 }
  xmlHttpReq.send(strSubmit);
}

function handleErrFullPage(strIn) {

        var errorWin;

        // Create new window and display error
        try {
                errorWin = window.open('', 'errorWin');
                errorWin.document.body.innerHTML = strIn;
        }
        // If pop-up gets blocked, inform user
        catch(e) {
                alert('An error occurred, but the error message cannot be' +
                        ' displayed because of your browser\'s pop-up blocker.\n' +
                        'Please allow pop-ups from this Web site.');
        }
}


function savedSequence()
{
	if(http.readyState == 4)
	{


		document.getElementById('saveresult').innerHTML = 'Category Sequence has been saved';
	}
}
function saveSequence()
{
	var sequences = document.catlistform.elements["sequence[]"];
	var codes = document.catlistform.elements["code[]"];
	var seqa = new Array();
	var coda = new Array();
	for(i=0;i<sequences.length;i++)
	{
		seqa[i] = sequences[i].value;
		coda[i] = codes[i].value;
	}
	var seq = seqa.toString();
	var cod = coda.toString();
	var url="lib/savesequence.php?sequences=" + seq + "&codes=" + cod;
	http.open("GET",url, true);
	http.onreadystatechange=savedSequence;
	http.send(null);

}

function loadState(val)
	{
	   //alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="country_id="+val+'&formname=customer&type=state';
		var strURL = url;
		var strResultFunc = "displaysubResult2";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function displaysubResult2(strIn)
	{
	    //document.getElementById('selectbox1').innerHTML="";
		document.getElementById('selectbox1').innerHTML=strIn;
		//document.getElementById('selectbox1').innerHTML=strIn;
	}
function loadStatenew(val)
	{
	   //alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="country_id="+val+'&formname=customer&type=state';
		var strURL = url;
		var strResultFunc = "displaysubResultNew";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function displaysubResultNew(strIn)
	{
	    //document.getElementById('selectbox1').innerHTML="";
		document.getElementById('td_state').innerHTML=strIn;
		//document.getElementById('selectbox1').innerHTML=strIn;
	}

	function loadStateship(val)
	{
	   //alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="country_id="+val+'&formname=checkout&type=state';
		var strURL = url;
		var strResultFunc = "displaysubResultship";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function displaysubResultship(strIn)
	{
	    //document.getElementById('selectbox1').innerHTML="";
		document.getElementById('td_state_ship').innerHTML=strIn;
		//document.getElementById('selectbox1').innerHTML=strIn;
	}

	function displaysubResult2(strIn)
	{
	    //document.getElementById('selectbox1').innerHTML="";
		document.getElementById('selectbox1').innerHTML=strIn;
		//document.getElementById('selectbox1').innerHTML=strIn;
	}

	function loadState_u(val)
	{
	  // alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="country_id="+val+'&formname=customer&type=state_u';
		var strURL = url;
		var strResultFunc = "displaysubResult2_u";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function displaysubResult2_u(strIn)
	{
	   // alert(strIn);
		document.getElementById('selectbox1').innerHTML=strIn;
	}

	function loadCity(val)
	{

		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="state_id="+val+'&formname=customer&type=city';
		var strURL = url;
		var strResultFunc = "displaysubResult3";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}

	function displaysubResult3(strIn)
	{
		document.getElementById('td_city').innerHTML=strIn;
	}

	function loadCityship(val)
	{

		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="state_id="+val+'&formname=checkout&type=city';
		var strURL = url;
		var strResultFunc = "displaysubcityship";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}

	function displaysubcityship(strIn)
	{
		document.getElementById('td_city_ship').innerHTML=strIn;
	}

	function loadCity_u(val)
	{

		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="state_id="+val+'&formname=customer&type=city_u';
		var strURL = url;
		var strResultFunc = "displaysubResult3_u";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}

	function displaysubResult3_u(strIn)
	{
		document.getElementById('selectbox2').innerHTML=strIn;
	}


	function loadCity1(val)
	{
		//alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="city1="+val+'&formname=customer&type=city1';
		var strURL = url;
		var strResultFunc = "displaysubResult9";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}

	function displaysubResult9(strIn)
	{
		document.getElementById('td_city1').innerHTML=strIn;
	}

	function diliveryState(val)
	{
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="country_id="+val+'&formname=addorder&type=state';
		var strURL = url;
		var strResultFunc = "displaysubResult10";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function displaysubResult10(strIn)
	{
		document.getElementById('di_state').innerHTML=strIn;
	}

	function diliveryCity(val)
	{
		//alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="state_id="+val+'&formname=addorder&type=city';
		var strURL = url;
		var strResultFunc = "displaysubResult11";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}

	function displaysubResult11(strIn)
	{
		document.getElementById('di_city').innerHTML=strIn;
	}

	function diliveryCity1(val)
	{
		//alert(val);
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/result_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="city1="+val+'&formname=addorder&type=city1';
		var strURL = url;
		var strResultFunc = "displaysubResult12";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function displaysubResult12(strIn)
	{
		document.getElementById('di_city1').innerHTML=strIn;
	}
	//Discount Function
	//function dis_count(disc_pct,total) {
//	 var dis_per=disc_pct/100;
//	 var dis_total=total*dis_per;
//	 a=total-dis_total
//	 document.getElementById('cartSub_Dis_Total').innerHTML=a;
//	 document.getElementById('cartSub_Dis_Total1').value=a;
//	 document.getElementById('disc_count_value').value=disc_pct;
//
//    }
     // Pick Up Or Deliver User Selection

	function ship_Pick(val,id)
	{

		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/user_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="pick_shipping="+val+"&user_id="+id+'&formname=checkout_shipping';
		var strURL = url;
		var strResultFunc = "display_shippign_pickup";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function display_shippign_pickup(strIn)
	{
		//alert(strIn);
		document.getElementById('ship_pickup').innerHTML=strIn;
	}
	function test(zip,val,id)
	{

		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/user_ajax.php";
		 if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="pick_shipping="+val+"&user_id="+id+'&formname=service_text'+"&zip_code="+zip;
		var strURL = url;
		var strResultFunc = "test_result";
		//alert(strResultFunc);
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;

	}

	function test_result(strIn)
	{
		data=strIn.split('##');
		//alert(data);
		document.getElementById('ship_pickup').innerHTML=data[0];
		document.getElementById('disc_total').innerHTML=data[1];
	}
//Pick Up date end
// Delivery date function
function delivery_date1()
	{

	    var now = new Date();
        var hour        = now.getHours();
        var minute      = now.getMinutes();
        var second      = now.getSeconds();
        var monthnumber = now.getMonth();
        var monthday    = now.getDate();
        var year        = now.getYear();
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="ajax/user_ajax.php";
		if (url.substring(0, 4) != 'http') {
			url = base_url + url;
		}
		var strSubmit="current_hour="+hour+'&formname=delivery_date_cal';
		var strURL = url;
		var strResultFunc = "display_delivery_date";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
	function display_delivery_date(strIn)
{


	var stor_close_time=20;
	if(stor_close_time > strIn)
    {
	  var now = new Date();
      var monthnumber = now.getMonth();
	  var monthday    = now.getDate();
	  var year        = now.getYear();
	  if(year < 2000) { year = year + 1900; }
      var dateString = (monthnumber+1) +
                    '/' + (monthday)
                     +
                    '/' +
                    year;
	  document.getElementById('delivery_date').value=dateString;
	}
	else
	{

	  var now = new Date();
      var monthnumber = now.getMonth();
	  var monthday    = now.getDate();
	  var year        = now.getYear();
	  if(year < 2000) { year = year + 1900; }
      var dateString = (monthnumber+1)+
                    '/' + (monthday+1)
                     +
                    '/ ' +
                    year;
	  document.getElementById('delivery_date').value=dateString;
	  alert("Your order by selecting tomorrow "+dateString+" or call (800) 555-xxxx for more assistance");

	}

}



