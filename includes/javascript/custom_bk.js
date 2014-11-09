function displayMessagePart() { alert("fs");	
	setTimeout(function() {
		  $('#msgPart').fadeOut(1200, "linear");
	}, 9000);
}
	  function initCorners() {
	    var settings = {
	      tl: { radius: 10 },
	      tr: { radius: 10 },
	      bl: { radius: 0 },
	      br: { radius: 0 },
	      antiAlias: true
	    }
	    curvyCorners(settings, ".top-menu");
		curvyCorners(settings, ".staff-picks-top");
		curvyCorners(settings, ".info-panel-title");	
		var settings1 = {
	      tl: { radius: 0 },
	      tr: { radius: 0 },
	      bl: { radius: 10 },
	      br: { radius: 10 },
	      antiAlias: true
	    }
		curvyCorners(settings1, ".staff-picks-bottom");
		curvyCorners(settings1, ".staff-picks-bottom2");
		curvyCorners(settings1, ".info-panel-description");
		var settings2 = {
	      tl: { radius: 10 },
	      tr: { radius: 10 },
	      bl: { radius: 10 },
	      br: { radius: 10 },
	      antiAlias: true
	    }		
		curvyCorners(settings2, ".fieldContainer");
		curvyCorners(settings2, ".grey-field");
		curvyCorners(settings2, ".roundedImageDiv");
	  }
   
	if (curveyCornerFlag) {
		addEvent(window, 'load', initCorners);
	}
	
	$(function() {
	$('#closeMsgPart').click(function(){		
		  $('#msgPart').fadeOut(1000, "linear");
	})
	setTimeout(function() {
		  $('#msgPart').fadeOut(1200, "linear");
	}, 9000);
	//$.noConflict();
	var minCount;
		$( "#searchInputBox" ).keypress(function(){
			//alert("keypress");
			var minCount = $('#searchInputBox').val().length;
			//alert(minCount);
			if(minCount>=3)
			{		
				$.ajax({
				  type: "POST",
				  url: application_path+"modules/search/index.php",
				  data: { str: $('#searchInputBox').val() }
					}).done(function( msg ) {
					if(msg!='0')
					{
						$('#search_results-wrap').css('display','block');
						$("#closeSearch").css('position','relative');
						$("#closeSearch").css('left','-21px');
						$("#closeSearch").css('top','25px');					
						$('#SearchCarousel').removeData();
						$('#SearchCarousel').html('');
						$('#SearchCarousel').html(msg);
						//alert( "Data Saved: " + msg );
						//alert(minCount);					
						$('#SearchCarousel').jcarousel({
						auto:0
						});
						initCorners();
					}
					else
					{
						$('#search_results-wrap').css('display','none');
						/*$("#closeSearch").css('position','relative');
						$("#closeSearch").css('left','-21px');
						$("#closeSearch").css('top','25px');					
						$('#SearchCarousel').removeData();
						$('#SearchCarousel').html('');
						$('#SearchCarousel').html('<li><span>No Result Found.</span></li>');*/
					}
				});
			}
		});
		$( "#searchBoxFooter" ).keypress(function(){
			var minCount = $('#searchBoxFooter').val().length;
			//alert(minCount);
			if(minCount>=3)
			{		
				$.ajax({
				  type: "POST",
				  url: application_path+"modules/search/index.php",
				  data: { str: $('#searchBoxFooter').val() }
					}).done(function( msg ) {
					if(msg!='0')
					{
						$('#search_results-wrap').css('display','block');
						$("#closeSearch").css('position','relative');
						$("#closeSearch").css('left','-21px');
						$("#closeSearch").css('top','25px');					
						$('#SearchCarousel').removeData();
						$('#SearchCarousel').html('');
						$('#SearchCarousel').html(msg);
						//alert( "Data Saved: " + msg );
						//alert(minCount);					
						$('#SearchCarousel').jcarousel({
						auto:0
						});
						initCorners();
					}
					else
					{
						$('#search_results-wrap').css('display','block');
						$("#closeSearch").css('position','relative');
						$("#closeSearch").css('left','-21px');
						$("#closeSearch").css('top','25px');					
						$('#SearchCarousel').removeData();
						$('#SearchCarousel').html('');
						$('#SearchCarousel').html('<li><span>No Result Found.</span></li>');
					}
				});
			}
		});	
		$("#closeSearch").click(function(){
			//alert('Click');
			$('#search_results-wrap').css('display','none');	
			$('#SearchCarousel').removeData();
		    $('#SearchCarousel').html('');
			$('#searchInputBox').val('');
			
		});
	});
	