// JavaScript Document


/*
	Expressions 
	
	valid exp for checking for email :: var validRegExp = /^\w(\.?\w)*@\w(\.?[-\w])*\.([a-z]{3}(\.[a-z]{2})?|[a-z]{2}(\.[a-z]{2})?)$/i ;
	valid exp for only letters allowed :: var alphaExp = /^[a-zA-Z]+$/;
	valid exp for only numbers allowed :: var numericExpression = /^[0-9]+$/;
	valid exp for only numbers & letters are allowed :: var alphaExp = /^[0-9a-zA-Z]+$/;
	
*/
var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var language;
var languageName;
var browserName  = '';
var fullVersion  = 0; 
var majorVersion = 0;

// Function To check character
//function checkverifychar(formname,fieldname,allowchar,message)
function checkverifychar(formname,fieldname,message)
{
	var e=eval("document." + formname + "." + fieldname);
	//var alphaExp = new RegExp("[a-zA-Z"+allowchar+"]", "g");
	var validRegExp = /^[a-zA-Z]+$/
	//var alphaExp = new RegExp("[a-zA-Z]", "g");
	var isValid = validRegExp.test(e.value);
	if(!isValid)
	{
		alert(message);
		e.focus();
		return false;
	}
	return true;
}

function checkverifychar_space(formname,fieldname,message)
{
	var e=eval("document." + formname + "." + fieldname);
	//var alphaExp = new RegExp("[a-zA-Z"+allowchar+"]", "g");
	var validRegExp = /^[a-zA-Z0-9]+$/
	//var alphaExp = new RegExp("[a-zA-Z]", "g");
	var isValid = validRegExp.test(e.value);
	if(!isValid)
	{
		alert(message);
		e.focus();
		return false;
	}
	return true;
}

function checkverifychar1(formname,fieldname1,message)
{
	var e=eval("document." + formname + "." + fieldname1);
	var validRegExp = /^[0-9-]+$/
	var isValid = validRegExp.test(e.value);
	if(!isValid)
	{
		alert(message);
		e.focus();
		return false;
		
	}
	return true;
}

function check_space(formname,fieldname,message)
{
var e1=eval("document." + formname + "." + fieldname)
str = e1.value;
for(var i=0; i<fieldname.length; i++)
{
if(str.charCodeAt(0) == 32)
{
alert(message);
//e1.value="";
e1.focus();
return false;
}
}
}
function checkminlen(formname,fieldname1,size1,message)
{
var e1=eval("document." + formname + "." + fieldname1);
str1 = e1.value;

if(str1.length<size1)
{
alert(message);
e1.focus();
return false;
}
return true;
}
//function setformaction(formname,naction)
function setformaction(formname,naction)
{
	var e=eval("document." + formname);
	e.action=naction;
	e.submit();
}

//function setformaction(formname,naction)
function setformactionprompt(formname,naction,message)
{
	var e=eval("document." + formname);
	truth1 = confirm(message)
	if (truth1)
	{
		e.action=naction;
		e.submit();
	}
}

//Function for forcus
function efocus(evalue)
{
	var e=eval(evalue);
	e.focus();
}

//Function for checking valid email Address
function checkemail(formname,fieldname,message)
{
	var stremail;
	var validRegExp = /^\w(\.?\w)*@\w(\.?[-\w])*\.([a-z]{3}(\.[a-z]{2})?|[a-z]{2}(\.[a-z]{2})?)$/i ;
	var e=eval("document." + formname + "." + fieldname);
  	stremail = e.value;
	if(stremail == "")
	{
		alert(message);
		e.focus();
		return false;
	}
	var isValid = validRegExp.test(stremail);
	if(!isValid)
	{
		alert("Enter valid Email id");
		e.focus();
		return false;
	}
	return true;
}
//end

function promote_goPage(pageid,formname,fieldname,totalname,username,uidcheckbox,actionval)
{
	suser="";
	var n=eval("document." + formname + "." + totalname + ".value");
	var suser=eval("document." + formname + "." + username + ".value");
	suarr = suser.split(",")
	found="false";
	for(i=1;i<=n;++i){
		e = eval("document." + formname + "." + uidcheckbox + i + ".value");
		found="false";
		for(j=0;j<suarr.length;j++)
		{
			if(suarr[j]==e.value)
			{
				found="true";
				break;
			}
		}
		if(found=="false")
		{
			if(e.checked)
			{
				suser=suser+e.value+",";
			}
		}
		else
		{
			if(e.checked)
			{
			}
			else
			{
				if(suser.indexOf(","+e.value+",")!=-1)
				{
					suser=suser.replace(","+e.value+",",",");
				}
				else
				{
					suser=suser.replace(e.value+",","");
				}
			}
		}
	}	
	var e = eval("document." + formname + "." + username );
	e.value=suser;
	var e = eval("document." + formname + ".page");
	e.value=pageid;
	var e = eval("document." + formname);
	e.action=actionval;
	e.submit();
}

function promote_sendscrap(formname,fieldname,totalname,username,uidcheckbox,actionval,message)
{
	suser="";
	var n=eval("document." + formname + "." + totalname + ".value");
	var suser=eval("document." + formname + "." + username + ".value");
	suarr = suser.split(",")
	found="false";
	for(i=1;i<=n;++i){
		e = eval("document." + formname + "." + uidcheckbox + i + ".value");
		found="false";
		for(j=0;j<suarr.length;j++)
		{
			if(suarr[j]==e.value)
			{
				found="true";
				break;
			}
		}
		if(found=="false")
		{
			if(e.checked)
			{
				suser=suser+e.value+",";
			}
		}
		else
		{
			if(e.checked)
			{
			}
			else
			{
				if(suser.indexOf(","+e.value+",")!=-1)
				{
					suser=suser.replace(","+e.value+",",",");
				}
				else
				{
					suser=suser.replace(e.value+",","");
				}
			}
		}
	}
	
	var e1 = eval("document." + formname + "." + username );
	e1.value=suser;
	if(e1!="")
	{
		var e = eval("document." + formname);
		e.action=actionval;
		e.submit();
	}
	else
	{
		alert(message);
		return false;
	}
}

//Function to set values for the control
function setvalue(formname,fieldname,fieldvalue)
{
	var e=eval("document." + formname + "." + fieldname);
	e.value=fieldvalue;
}
//end

//Function for checking valid numbers
function checkword(formname,fieldname1,limit,message)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	formcontent=e1.value.split(" ")
	
	if(formcontent.length<limit)
	{
		alert(message);
		e1.focus();
		return false;
	}
	return true;
}
//end

//Function for checking valid numbers
function checknumber(formname,fieldname1,message)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.value;

	if(isNaN(str1))
	{
		alert(message);
		e1.focus();
		return false;
	}
	return true;
}
//end

//Function for checking length Of combo
function checkcombolength(formname,fieldname1,message)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.options.length;

	if(str1<=0)
	{
		alert(message);
		e1.focus();
		return false;
	}
	return true;
}
//end

//Function for assign combo to textbox
function assigncombolength(formname,fieldname1,fieldname2)
{
	var e1=eval("document." + formname + "." + fieldname1);
	var e2=eval("document." + formname + "." + fieldname2);
  	str1 = e1.options.length;

	flist="";
	for(j=0;j<document.f1.mailto.options.length;++j){
		 flist=flist+e1[j].value+",";
	}
	e2.value=flist;
	return true;
}
//end

//Function for 
function checkboxLength(formname,prefix_field,total_field,message,minsel,minmessage,maxsel,maxmessage)
{
	var e1=eval("document." + formname + "." + total_field);
  	str1 = e1.value;
	totalopt=0;
	
	for(i=1;i<=str1;i++)
	{
		e=eval("document." + formname + "." + prefix_field + i);
		if(e.checked==true)
		{
			totalopt=totalopt+1;
		}
	}
	if(minsel>-1)
	{
		if(minsel==0)
		{
			if(totalopt==0)
			{
				alert(message);
				return false;
			}
		}
	}
	if(minsel!=0)
	{
		if(minsel>totalopt)
		{
			alert(minmessage);
			return false;	
		}
	}
	if(maxsel!=0)
	{
		if(totalopt>maxsel)
		{
			alert(maxmessage);
			return false;	
		}
	}
}
//end

//function start
function mergecheckboxLength(formname,prefix_field,prefix_field1,total_field,message,minsel,minmessage,maxsel,maxmessage)
{
	var e1=eval("document." + formname + "." + total_field);
  	str1 = e1.value;
	totalopt=0;
	for(i=1;i<=str1;i++)
	{
		e=eval("document." + formname + "." + prefix_field + i);
		if(e.checked==true)
		{
			totalopt=totalopt+1;
		}
		e1=eval("document." + formname + "." + prefix_field1 + i);
		if(e1.checked==true)
		{
			totalopt=totalopt+1;
		}
	}
	if(minsel>-1)
	{
		if(minsel==0)
		{
			if(totalopt==0)
			{
				alert(message);
				return false;
			}
		}
	}
	if(minsel!=0)
	{
		if(minsel>totalopt)
		{
			alert(minmessage);
			return false;	
		}
	}
	if(maxsel!=0)
	{
		if(totalopt>maxsel)
		{
			alert(maxmessage);
			return false;	
		}
	}
}
//end
//Function for selecting all check boxes
function checkTerm(formname,fieldname,message)
{
	var e1=eval("document." + formname + "." + fieldname);
	if(e1.checked!=true)
	{
		alert(message);
		return false;
	}
}

//Function for selecting all check boxes
function checkAll(formname,checkfiled,prefix_field,total_field)
{
	var cf=eval("document." + formname + "." + checkfiled);
	var e1=eval("document." + formname + "." + total_field);
  	str1 = e1.value;
	
	if(cf.checked)
	{
		for(i=1;i<=str1;i++)
		{
			e=eval("document." + formname + "." + prefix_field + i);
			e.checked=true;
		}
	}
	else
	{
		for(i=1;i<=str1;i++)
		{
			e=eval("document." + formname + "." + prefix_field + i);
			e.checked=false;
		}
	}
}
//end

//Function for checking whether option button is checked or not
function checkradio(formname,fieldname,message)
{
	var cf=eval("document." + formname + "." + fieldname);
	totalopt=0;
	for (i=cf.length-1; i > -1; i--) 
	{
		if(cf[i].checked) 
		{
			totalopt=1;
		}
	}
	if(totalopt==0)
	{
		alert(message);
		return false;
	}
	return true;
}
//end

//Function for checking multiple check boxes 
function checkmultiselect(formname,fieldname,message,minsel,minmessage,maxsel,maxmessage)
{
	var cf=eval("document." + formname + "." + fieldname);
	totalopt=0;

	for (i=0;i< cf.length;i++) 
	{
		if(cf.options[i].selected) 
		{
			totalopt=totalopt+1;
		}
	}
	if(minsel>-1)
	{
		if(minsel==0)
		{
			if(totalopt==0)
			{
				alert(message);
				return false;
			}
		}
	}
	if(minsel!=0)
	{
		if(minsel>totalopt)
		{
			alert(minmessage);
			return false;	
		}
	}
	if(maxsel!=0)
	{
		if(totalopt>maxsel)
		{
			alert(maxmessage);
			return false;	
		}
	}
	return true;
}
//end

//Function for checking required fields
function checkrequire(formname,fieldname1,message)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.value;

	if(str1 == "")
	{
		alert(message);
		e1.focus();
		return false;
	}
	return true;
}
//end

function checkverifydate(formname,fieldname1,fieldname2)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.value;
	var e2=eval("document." + formname + "." + fieldname2);
  	str2 = e2.value;
	month=str1;
	day=str2;
	if (month == 0 || day == 0)
	{
	     alert("Enter proper BirthDate"); 
		 return false;
	}
	return true;
}


//Function for checking valid (specified) extentions
function checkextension(formname,fieldname1,message,exten)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.value;
	var extenarr=exten.split(",");
	var valid=false;

	if(str1 == "")
	{
	}
	else
	{
		idx=str1.lastIndexOf(".");
		str1=str1.substr(idx+1).toLowerCase();
		for(i=0;i<extenarr.length;i++)
		{
			if(extenarr[i]==str1)
			{
				valid=true;
			}
		}
		if(valid==false)
		{
			alert(message + "[ " + exten.replace(/,/g, ", ") + " ] ");
			e1.value = "";
			return false;
		}
	}
	return true;
}
//end

//Function for checking input length
function checkmaxlen(formname,fieldname1,size1,message)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.value;

	if(str1.length>size1)
	{
		alert(message);
		e1.focus();
		return false;
	}
	return true;
}
//end

//Function for show/hide controls or elements
function hideshowtoggle(obj)
{
	var subobj=document.getElementById(obj);
	if(subobj.style.display=="none")
	{
		subobj.style.display="block";
	}
	else
	{
		subobj.style.display="none";
	}
}
//end

//Function for checking both inputs i.e both emails or passsword etc
function checksame(formname,fieldname1,fieldname2,message)
{
	var e1=eval("document." + formname + "." + fieldname1);
  	str1 = e1.value;
	var e2=eval("document." + formname + "." + fieldname2);
  	str2 = e2.value;

	if(str1 != str2)
	{
		alert(message);
		e1.focus();
		return false;
	}
	return true;
}
//end

//Function for checking valid numbers
function validatenumber()
{
	if((event.keyCode<48) || (event.keyCode>58) )
	{
		if(event.keyCode!=13)
		{
			event.keyCode=0;
			alert("Only Numbers are Allowed");		
		}
	}
}
//end

function deleteItMessage(formname,prefix_field,total_field,message1,message2,action1)
{  
	var e1=eval("document." + formname + "." + total_field);
  	str1 = e1.value;
	var tc=0;
	
	for(i=1;i<=str1;i++)
	{
		e=eval("document." + formname + "." + prefix_field + i);
		if(e.checked==true)
		{
			tc=tc+1;
		}
	}
	
	if(parseInt(tc)>0)
	{
		truth1 = confirm(message1+message2)
		if (truth1)
		{
			var e1=eval("document." + formname);
			e1.action=action1;
			e1.submit();
		}
	}
}

function deleteItMessage1(formname,prefix_field,prefix_field1,total_field,message1,message2,action1)
{  
	var e1=eval("document." + formname + "." + total_field);
  	str1 = e1.value;
	var tc=0;
	
	for(i=1;i<=str1;i++)
	{
		e=eval("document." + formname + "." + prefix_field + i);
		if(e.checked==true)
		{
			tc=tc+1;
		}
		e1=eval("document." + formname + "." + prefix_field1 + i);
		if(e1.checked==true)
		{
			tc=tc+1;
		}
	}
	
	if(parseInt(tc)>0)
	{
		truth1 = confirm(message1+message2)
		if (truth1)
		{
			var e1=eval("document." + formname);
			e1.action=action1;
			e1.submit();
		}
	}
}

//Function for getting details for browser
function getbrowserName()
{
	// In Internet Explorer, the true version is after "MSIE" in userAgent
	if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
	 browserName  = "Microsoft Internet Explorer";
	 fullVersion  = parseFloat(nAgt.substring(verOffset+5));
	 majorVersion = parseInt(''+fullVersion);
	}
	
	// In Opera, the true version is after "Opera" 
	else if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
	 browserName  = "Microsoft Internet Explorer";
	 fullVersion  = parseFloat(nAgt.substring(verOffset+6));
	 majorVersion = parseInt(''+fullVersion);
	}
	
	// In most other browsers, "name/version" is at the end of userAgent 
	else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < (verOffset=nAgt.lastIndexOf('/')) ) 
	{
	 browserName  = nAgt.substring(nameOffset,verOffset);
	 fullVersion  = parseFloat(nAgt.substring(verOffset+1));
	 if (!isNaN(fullVersion)) majorVersion = parseInt(''+fullVersion);
	 else {fullVersion  = 0; majorVersion = 0;}
	}
	
	// Finally, if no name and/or no version detected from userAgent...
	if (browserName.toLowerCase() == browserName.toUpperCase()
	 || fullVersion==0 || majorVersion == 0 )
	{
	 browserName  = navigator.appName;
	 fullVersion  = parseFloat(nVer);
	 majorVersion = parseInt(nVer);
	}
	
	return browserName;
}
//end

//Function for getting details for browser language
function getLanguage()
{
	if (navigator.appName == 'Netscape')
	{
		var language = navigator.language;
	}
	else
	{
		var language = navigator.browserLanguage;
	}
	
	if (language.indexOf('en') > -1) languageName = 'english';
	else if (language.indexOf('nl') > -1) languageName = 'dutch';
	else if (language.indexOf('fr') > -1) languageName = 'french';
	else if (language.indexOf('de') > -1) languageName = 'german';
	else if (language.indexOf('ja') > -1) languageName = 'japanese';
	else if (language.indexOf('it') > -1) languageName = 'italian';
	else if (language.indexOf('pt') > -1) languageName = 'portuguese';
	else if (language.indexOf('es') > -1) languageName = 'Spanish';
	else if (language.indexOf('sv') > -1) languageName = 'swedish';
	else if (language.indexOf('zh') > -1) languageName = 'chinese';
	else 
	languageName = 'nl';
		
	return languageName;
}
//end

//Function for alerting specified message
function display(str)
{ //display alert message
	alert(str);
}
//end

//Java script for oncliick show hide div elements
function getposOffset(overlay, offsettype)
{
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function overlay(curobj, subobjstr, opt_position)
{
	if (document.getElementById){
		var subobj=document.getElementById(subobjstr)
		subobj.style.display=(subobj.style.display!="block")? "block" : "none"
		var xpos=getposOffset(curobj, "left")+((typeof opt_position!="undefined" && opt_position.indexOf("right")!=-1)? -(subobj.offsetWidth-curobj.offsetWidth) : 0) 
		var ypos=getposOffset(curobj, "top")+((typeof opt_position!="undefined" && opt_position.indexOf("bottom")!=-1)? curobj.offsetHeight : 0)
		subobj.style.left=xpos+"px"
		subobj.style.top=ypos+"px"
		return false
	}
	else
		return true
}

function overlayclose(subobj)
{ //Hide div elemenents
	document.getElementById(subobj).style.display="none"
}
//end

//function for adding site or page to addto favourite
function addToFavorite()
{
	//Add to favourite the page
	window.external.AddFavorite(location.href, document.title);
}
//end

// GetElementByID Function
function setElementId(txtname,txtval)
{
	//Assign value to specifiend control or span ID
	document.getElementById(txtname).innerHTML=txtval;
}
//end

//Remove selected values from the combo
function removeselected(formname,fieldname1,fieldname2)
{
	var i;	
	var e=eval("document." + formname + "." + fieldname1);  	
	var e1=eval("document." + formname + "." + fieldname2);  		
	for(i=e.options.length-1;i>=0;i--)
	{
		if(e[i].selected){
			for(j=0;j<e1.length;++j){
				if(e1[j].value==e[i].value){
					e1[j].style.color='#000000';
				}
			}
			e.remove(i);
		}
	}
}

//Remove all values from one combo
function removeall(formname,fieldname1,fieldname2)
{
	var i;	
	var e=eval("document." + formname + "." + fieldname1);  	
	var e1=eval("document." + formname + "." + fieldname2); 
	for(i=0;i<e1.length;++i){						
		e1[i].style.color='#000000';
	}
	var i;
	for(i=e.options.length-1;i>=0;i--)
	{
		e.remove(i);
	}
}

//Add selected values from one combo to another
function selectselected(formname,fieldname1,fieldname2)
{
	var i;	
	var e=eval("document." + formname + "." + fieldname1);  	
	var e1=eval("document." + formname + "." + fieldname2);
	
	st="true";
	for(i=0;i<e1.length;++i){
		if(e1[i].selected){
			e1[i].style.color='#CCCCCC';			
			st="true";
			for(j=0;j<e.options.length;++j){
				if(e1[i].value==e[j].value)
					st="false";
			}
			if(st=="true"){ 
				e.options[e.options.length]=new Option(e1[i].text,e1[i].value)
			}
		}
	}
}

//Add values from one combo to another
function selectall(formname,fieldname1,fieldname2)
{
	var i;	
	var e=eval("document." + formname + "." + fieldname1);  	
	var e1=eval("document." + formname + "." + fieldname2);
	
	st="true";
	for(i=0;i<e1.length;++i){
		e1[i].style.color='#CCCCCC';
		st="true";	
		for(j=0;j<e.options.length;++j){
			if(e1[i].value==e[j].value){				
				st="false";				
			}	
		}
		if(st=="true"){ 
			e.options[e.options.length]=new Option(e1[i].text,e1[i].value)
		}
	}
}
//end

function checksearchicon(e)
{
	var al=e.value;
	if(al.length==0)
	{
		e.className='inputbig';
	}
}

function trimString (str) 
{
  str = this != window? this : str;
  return str.replace(/^\s+/g, '').replace(/\s+$/g, '');
}
function trimstr(formname,fieldname) 
{
    var e=eval("document." + formname + "." + fieldname);
	var str=e.value; 	
    str = this != window? this : str;
    str=str.replace(/^\s+/g, '').replace(/\s+$/g, '');
	
	var cap=str.charAt(0).toUpperCase() + str.substring(1,str.length);
	e.value = cap;
}
function trimstr2(formname,fieldname) 
{
    var e=eval("document." + formname + "." + fieldname);
	var str=e.value; 	
    str = this != window? this : str;
    str=str.replace(/^\s+/g, '').replace(/\s+$/g, '');
	
	e.value = str;
}


function firstCapital(formname,fieldname)
{
 var e=eval("document." + formname + "." + fieldname);
 var str=e.value;
 var cap=str.charAt(0).toUpperCase() + str.substring(1,str.length);
 e.value = cap;
}
function check_search()
{
	if(document.search1.stext.value=="")
	{
		alert("Enter text for search");
		document.search1.stext.focus();
		return false;
	}
	var entry=document.search1.stext.value;
	var aCharExists;
	aCharExists=0;
	for (var i=0; i<entry.length; i++) 
	{
		if (entry.charAt(i) == "\"")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "/")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "\\")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "_")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "-")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "+")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "_")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "!")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "`")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "@")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "~")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "$")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "^")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "=")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "{")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "}")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "|")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ";")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ":")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "?")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ".")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ",")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "<")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ">")
			{
				aCharExists = 1;
			}			
			if (entry.charAt(i) == "'")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "%")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "*")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "&")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "(")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ")")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "[")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "]")
			{
				aCharExists = 1;
			}
	}
	if(aCharExists==1)
	{		
		alert("Please Ingnore use of & ! ` @ ~ $ % ^ & * ( ) - _ + = ] [ { } \ | ' \" ; : / ? . , > < ");
		document.search1.stext.focus();
		return false;
	}
	document.search1.page.value=1;
	return true;
}

function network_search()
{
	var entry=document.search1.stext.value;
	var aCharExists;
	aCharExists=0;
	for (var i=0; i<entry.length; i++) 
	{
		if (entry.charAt(i) == "\"")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "/")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "\\")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "_")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "-")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "+")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "_")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "!")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "`")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "@")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "~")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "$")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "^")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "=")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "{")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "}")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "|")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ";")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ":")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "?")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ".")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ",")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "<")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ">")
			{
				aCharExists = 1;
			}			
			if (entry.charAt(i) == "'")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "%")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "*")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "&")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "(")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ")")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "[")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "]")
			{
				aCharExists = 1;
			}
	}
	if(aCharExists==1)
	{		
		alert("Please Ingnore use of & ! ` @ ~ $ % ^ & * ( ) - _ + = ] [ { } \ | ' \" ; : / ? . , > < ");
		document.search1.stext.focus();
		return false;
	}
	return true;
}

function check_login() 
{
	if(checkemail("login","email","Enter Your Email")==false)
		return false;
		
	if(checkrequire("login","password","Enter Password")==false)
		return false;
		
	return true;
}

function browse_search()
{
	if(document.searchbig.stext1.value=="")
	{
		alert("Enter text for search");
		document.searchbig.stext1.focus();
		return false;
	}
	var entry=document.searchbig.stext1.value;
	var aCharExists;
	aCharExists=0;
	for (var i=0; i<entry.length; i++) 
	{
		if (entry.charAt(i) == "\"")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "/")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "\\")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "_")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "-")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "+")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "_")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "!")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "`")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "@")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "~")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "$")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "^")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "=")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "{")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "}")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "|")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ";")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ":")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "?")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ".")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ",")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "<")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ">")
			{
				aCharExists = 1;
			}			
			if (entry.charAt(i) == "'")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "%")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "*")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "&")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "(")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == ")")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "[")
			{
				aCharExists = 1;
			}
			if (entry.charAt(i) == "]")
			{
				aCharExists = 1;
			}
	}
	if(aCharExists==1)
	{		
		alert("Please Ingnore use of & ! ` @ ~ $ % ^ & * ( ) - _ + = ] [ { } \ | ' \" ; : / ? . , > < ");
		document.searchbig.stext1.focus();
		return false;
	}
	document.searchbig.page.value=1;
	return true;
}

var a;
function create_tagarray(str)
{	
	a=str.split("{}");
	/*alert(a.length);
	for(i=0;i<a.length;++i)
	{
		alert(a[i]);
	}*/
}

//menu
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';
	

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}
// close layer when click-out
document.onclick = mclose; 

function IsNumeric(sText)
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;
 
  for (i = 0; i < sText.length && IsNumber == true; i++) 
  { 
  Char = sText.charAt(i); 
  if (ValidChars.indexOf(Char) == -1) 
	 {
	 IsNumber = false;
	 }
  }
   return IsNumber;   
}

////////////////////   This Function For select atleast 2 chkbox qoute[]   ////////
function quotes()
{
	var checkSelected=false;
	chks = document.getElementsByName('quote[]');
	var cnt=0;
	var hasChecked = false;
	
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
		{
			hasChecked = true;
			cnt++;					
			//break;
		}
	}
	
	if (!hasChecked)
	{
		alert("Please select two Options");
		chks[0].focus();
		return false;
	}
	if(cnt < 2) // Minimum 2 checkbox select
	{							
		alert("Please select two Options");
		return false;
	}
	return true;
}