$(function() {
	/*
	number of fieldsets
	*/
	var fieldsetCount = $('#projectCreatefield').children().length;
	/*
	current position of fieldset / navigation link
	*/
	var current 	= 1;
	/*
	sum and save the widths of each one of the fieldsets
	set the final sum as the total width of the steps element
	*/
	var stepsWidth	= 0;
	var widths 		= new Array();
		
	if($.browser.msie==true)
	{	
		$('#steps .step').each(function(i){
        	var $step 		= $(this);
			widths[i]  		= stepsWidth;
        	stepsWidth	 	+= $step.width()+6;
		
    	});
	}
	else
	{
		$('#steps .step').each(function(i){
        	var $step 		= $(this);
			widths[i]  		= stepsWidth;
        	stepsWidth	 	+= $step.width();
		
    	});
	}
	$('#steps').width(stepsWidth);
	/*
	to avoid problems in IE, focus the first input of the form
	*/
	$('#projectCreatefield').children(':first').find(':input:first').focus();	
	/*
	show the navigation bar
	*/
	$('#navigation').show();
	$('#acceptTerms').live('click', function(e){
		$.ajax({
			type: 'POST',
			url: application_path+'modules/createProject/startProject.php',
			dataType: 'html',
			data: 'id=' +$(this).val(),
			success: function(data) 
			{
				$('#projectCreate').val('1');
				
				if(data!='')
				{
					$("#preview-btn").attr('href',SiteUrl+'browseproject/'+data);
					$("#preview-btn a").attr('href',SiteUrl+'browseproject/'+data);
				}
			}
		});
		$('.content_right').css('display','block');
		//$('.sidebar').css('display','block');
		$(this).attr("disabled", true);
		var $this	= $(this);
		var prev	= current;
		$this.closest('ul').find('li').find('a').removeClass('active');
		$this.addClass('active');
		/*
		we store the position of the link
		in the current variable	
		*/				
		current = 2;
		/*
		animate / slide to the next or to the corresponding
		fieldset. The order of the links in the navigation
		is the order of the fieldsets.
		Also, after sliding, we trigger the focus on the first 
		input element of the new fieldset
		If we clicked on the last link (confirmation), then we validate
		all the fieldsets, otherwise we validate the previous one
		before the form slided
		*/
		$(".firststepfieldset").append(' <div class="clear"></div><div id="nextPrev"><input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev(\'getStarted\',2,\'basics\');" value="Next" /></div>');
		/*$('#steps').stop().animate({
			marginLeft: '-' + widths[current-1] + 'px'
		},500,function(){
			if(current == fieldsetCount)
				validateSteps();
			else
				validateStep(prev);*/
			//$('#projectCreatefield').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();
			//$("#getBasics").trigger("click");	
		//});
		$('#projectCreatefield').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();
		//e.preventDefault();
	});
	/*
	when clicking on a navigation link 
	the form slides to the corresponding fieldset
	*/
    $('#navigation a').bind('click',function(e){
		$('.content_right').css('display','block');
		if($('#projectCreate').val()=='1')
		{
			/*save the things as user move next step*/
			//document.getElementById('test').innerHTML = str;
			var $this	= $(this);
			var prev	= current;
			//$this.closest('ul').find('li').removeClass('selected');
			$this.closest('ul').find('li').find('a').removeClass('active');
			$this.addClass('active');
			/*
			we store the position of the link
			in the current variable	
			*/		
			current = $this.parent().index() + 1;
			var str = '';
			var elem = document.getElementById('projectCreatefield').elements;
			if($this.parent().index()==4)
			{			
				//str += "projectStory1='"+CKEDITOR.instances.redactor_content.getData()+"'&";
				//alert(str);
				//str += "projectStory1='"+encodeURIComponent(CKEDITOR.instances.redactor_content.getData())+"'&";
			}
			for(var i = 0; i < elem.length; i++)
			{						
				if(elem[i].name=='duration')
				{
					//alert(elem[i].name);
					if(elem[i].checked)
					{
						//alert(elem[i].name+"\n"+elem[i].value);
						str += elem[i].name + "=";
						str += elem[i].value + "&";					
					}
				}
				else if(elem[i].name=='fundingGoal' || elem[i].name=='rewardAmount[]' || elem[i].name=='days' || elem[i].name=='countRewards' )
				{				
						str += elem[i].name + "=";
						if(elem[i].name == "projectStory1"){
		    				str +=encodeURIComponent(CKEDITOR.instances['redactor_content'].getData())+"&";
						} else if (elem[i].name=='fundingGoal' || elem[i].name=='rewardAmount[]') {
							str += elem[i].value.replace('$','') + "&";								
						}else{
							str += elem[i].value + "&";
						}
				}
				else
				{
					str += elem[i].name + "=";
					if(elem[i].name == "projectStory1"){
		    			str +=encodeURIComponent(CKEDITOR.instances['redactor_content'].getData())+"&";
					} else if (elem[i].name == "video_url") {
						str +=encodeURIComponent(elem[i].value) + "&";
					}else{
						str += elem[i].value + "&";	
					}
				}
			} 
			str += "current=" + $this.parent().index() + "";
			//str += "current=" + current + "";
			//alert('N-Cur--'+str);
			$.ajax({
				type: 'POST',
				url: application_path+'modules/createProject/updateProject.php',
				dataType: 'html',
				data: str,
				success: function(data) 
				{
					$('#projectCreate').val('1');
					if(data!='')
					{
						$("#preview-btn").attr('href',SiteUrl+'browseproject/'+data);
						$("#preview-btn a").attr('href',SiteUrl+'browseproject/'+data);
					}
				}
				/*,error: function (req, status, error) {
					alert(req.responseText); 
				}*/
			});
			/*
			animate / slide to the next or to the corresponding
			fieldset. The order of the links in the navigation
			is the order of the fieldsets.
			Also, after sliding, we trigger the focus on the first 
			input element of the new fieldset
			If we clicked on the last link (confirmation), then we validate
			all the fieldsets, otherwise we validate the previous one
			before the form slided
			*/
			$('#steps').stop().animate({
				marginLeft: '-' + widths[current-1] + 'px'
			},500,function(){
				if(current == fieldsetCount)
					validateSteps();
				else
					validateStep(prev);
				$('#projectCreatefield').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
			});
		}
		else{
			alert('please accept terms & condition to start project');
		}
		e.preventDefault();
    });
	
	/*
	clicking on the tab (on the last input of each fieldset), makes the form
	slide to the next step
	*/
	$('#projectCreatefield > fieldset').each(function(){
		var $fieldset = $(this);
		$fieldset.children(':last').find(':input').keydown(function(e){
			if (e.which == 9){
				$('#navigation li:nth-child(' + (parseInt(current)+1) + ') a').click();
				/* force the blur for validation */
				$(this).blur();
				e.preventDefault();
			}
		});
	});
	
	/*
	validates errors on all the fieldsets
	records if the Form has errors in $('#formElem').data()
	*/
	function validateSteps(){
		//alert('validateSteps without arg');
		var FormErrors = false;
		for(var i = 1; i < fieldsetCount; ++i){
			var error = validateStep(i);
			if(error == -1)
				FormErrors = true;
		}
		$('#projectCreatefield').data('errors',FormErrors);	
	}
	function isValidEmail(str) {
		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	}
	/*
	validates one fieldset
	and returns -1 if errors found, or 1 if not
	*/
	function validateStep(step){
	//alert('validateSteps with arg');
	
		//if(step == fieldsetCount) return;		
		var error = 1;
		var hasError = false;
		if(parseInt(step)==2)
		{
			if($('#projectTitle').val()=='')
			{
				hasError = true;
			}
			if($('#projectCategory').val()=='')
			{
				hasError = true;
			}
			if($('#shortBlurb').val()=='')
			{
				hasError = true;
			}
			if($('#projectLocation').val()=='')
			{
				hasError = true;
			}
		}
		else if(step==3)
		{
			if($('#fundingGoal').val()=='')
			{
				hasError = true;
			}
		} 
		else if(step==4)
		{
			var num		= $('.clonedInput').length;
			for(var i=1; i<=num; i++)
			{				
				if($('.text').val() == '0.00')
				{					
					hasError = true;
				}
				if($('.text2').val() == '')
				{					
					hasError = true;
				}
				if($('.month').val() == '')
				{					
					hasError = true;
				}
				if($('.year').val() == '')
				{					
					hasError = true;
				}
			}
			if($("#noReward").val() == 0){
				hasError = false;
			}
		}
		else if(step==5)
		{
			if(CKEDITOR.instances.redactor_content.getData()=='')
			{
				hasError = true;
			}
		}
		else if(step==6)
		{
			hasError = false;
		}
		else if(step==7)
		{
			if($('#paypalUserAccount').val()!='')
			{				
				if(!isValidEmail($('#paypalUserAccount').val()))
				{
					hasError = true;
				}
			}
			else
			{
				hasError = true;
			}
		}
		else if(step==8)
		{			
			hasError = false;
		}
				
		var $link = $('#navigation li:nth-child(' + parseInt(step) + ') a');
		//$link.parent().find('.error,.checked').remove();
		$link.find('.error,.checked').remove();
		
		var valclass = 'checked';
		if(hasError){		
			error = -1;
			valclass = 'error';
		}
		$link.append('<span class="'+valclass+'"></span>');
		
		return error;
	}
	
	/*
	if there are errors don't allow the user to submit
	*/
	$('#registerButton').bind('click',function(){
		if($('#projectCreatefield').data('errors')){
			alert('Please correct the errors in the Form');
			return false;
		}	
	});
});
function ucfirst(str,force){
          str=force ? str.toLowerCase() : str;
          return str.replace(/(\b)([a-zA-Z])/,
                   function(firstLetter){
                      return   firstLetter.toUpperCase();
                   });
     }
function nextPrev(currentDiv,currentPosition,selectedDiv)
{
	var fieldsetCount = $('#projectCreatefield').children().length;
	/*
	current position of fieldset / navigation link
	*/
	var current 	= 1;
	/*
	sum and save the widths of each one of the fieldsets
	set the final sum as the total width of the steps element
	*/
	var stepsWidth	= 0;
    var widths 		= new Array();
	$('#steps .step').each(function(i){
        var $step 		= $(this);
		widths[i]  		= stepsWidth;
        stepsWidth	 	+= $step.width();
    });
	$('#steps').width(stepsWidth);
	
	/*$('#steps .step').each(function(){
        //$('#steps').height($(this).height());
    });*/
	
	
	//$('.sidebar').css('display','block');
	$('.content_right').css('display','block');
	if($('#projectCreate').val()=='1')
	{
		var $this	= $('#'+currentDiv);
		var prev	= current;		
		//$('#navigation').find('ul').find('li').removeClass('selected');
		$('#navigation').find('ul').find('li').find('a').removeClass('active');
		$('#'+selectedDiv).find('a').addClass('active');		
		//$('#'+selectedDiv).addClass('active');		
		current = currentPosition;
		var str = '';
		var elem = document.getElementById('projectCreatefield').elements;		
        $('#steps').stop().animate({
            marginLeft: '-' + widths[current-1] + 'px'
        },500,function(){
			$('#projectCreatefield').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
		});
		
		
		//if(current == 5){
			/*var $link = $('#navigation li:nth-child(' + parseInt(current-1) + ') a');
			$link.find('.error,.checked').remove();
			
			var valclass = 'checked';
			$link.addClass('disable');
			$link.append('<span class="'+valclass+'"></span>');
			$link.unbind("click");*/
			
		//}
		if(current == 6)
		{			
			//str += "projectStorySS='"+CKEDITOR.instances.redactor_content.getData()+"'&";
			//str += "projectStoryD='"+encodeURIComponent(CKEDITOR.instances.redactor_content.getData())+"'&";
			//str += "projectStory1='"+encodeURIComponent(CKEDITOR.instances['redactor_content'].getData())+"'&";
		}
		for(var i = 0; i < elem.length; i++)
		{						
			if(elem[i].name=='duration')
			{
				//alert(elem[i].name);
				if(elem[i].checked)
				{
					//alert(elem[i].name+"\n"+elem[i].value);
					str += elem[i].name + "=";
		    		str += elem[i].value + "&";					
				}
			}
			else if(elem[i].name=='fundingGoal' || elem[i].name=='rewardAmount[]' ||elem[i].name=='days' || elem[i].name=='countRewards' )
			{				
					str += elem[i].name + "=";
		    		if(elem[i].name == "projectStory1"){
		    			str +=encodeURIComponent(CKEDITOR.instances['redactor_content'].getData())+"&";
					} else if (elem[i].name=='fundingGoal' || elem[i].name=='rewardAmount[]') {
						str += elem[i].value.replace('$','') + "&";				
					}else{
							str += elem[i].value + "&";	
					
					}
			}
			else
			{
				str += elem[i].name + "=";
		    	if(elem[i].name == "projectStory1"){
		    		str +=encodeURIComponent(CKEDITOR.instances['redactor_content'].getData())+"&";
				}else{
					str += elem[i].value + "&";	
				}
			}
		} 
		
		//str += "current=" + $this.parent().index() + "";
		current = current - 1;
		str += "current=" +current+ "";
		$.ajax({
            type: 'POST',
            url: application_path+'modules/createProject/updateProject.php',
            dataType: 'html',
			data: str,
            success: function(data) 
			{
				$('#projectCreate').val('1');
				if(data!='')
				{
					$("#preview-btn").attr('href',SiteUrl+'browseproject/'+data);
					$("#preview-btn a").attr('href',SiteUrl+'browseproject/'+data);
				}
				$('#'+selectedDiv).find('a').trigger('click');
				$("html, body").animate({ scrollTop: 0 }, "slow"); // jwg
            }
        });
	}
	else{
		alert('please accept terms & condition to start project');
	} 
}