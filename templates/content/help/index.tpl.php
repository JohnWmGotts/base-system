<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length > 0) {
			$('#icon-search-clear').show();	
		}else{ 
			$('#icon-search-clear').hide(); 
		}
		
		if(inputString.length < 3) {
			$('#suggestions').hide();
		} else {
			$.post("<?php echo SITE_MOD; ?>help/help.php", {queryString: ""+inputString+""}, function(data){
			if(data.length >0) {
				$('#suggestions').fadeIn();
				$('#autoSuggestionsList').html(data);
			}
			});
		}
	}
	function fill(id,question) {
		//alert(question)
		window.location= application_path+"help/"+id+"/#"+question;
	}
	function fill1() {
		setTimeout("$('#suggestions').fadeOut(200);", 200);
	}
	function clearText()
	{
		document.getElementById("inputString").value="";
		if ( $.browser.msie ) {
			$("#inputString").val("Search the FAQ");
		}
		$('#icon-search-clear').hide();
	}
	function placeholdertext()
	{
		document.getElementById("faq-overlabel").innerHTML="";
	}
</script>
<script type="text/javascript">
	$(document).ready(function () {
		  $("#faq-submit").click(function () { $("#frm-faq").submit(); });
		  $(".grid").last().attr('id','last');
		  
		if ( $.browser.msie ) {
			
			$("#inputString").val("Search the FAQ");
			var Input = $("#inputString");
			var default_value = Input.val();
			Input.focus(function() {
				if(Input.val() == default_value)
				{ Input.val("");}
			}).blur(function(){
				if(Input.val().length == 0)
				{ Input.val(default_value);}
			});
			
			$("#inputString").focus(function(){
				$("#inputString").val("");
			});
		}
		
		$("#frm-faq").validate({
			errorLabelContainer: "#errorSearch",
            wrapper: "li",
            errorClass: "errSearch",
			
			rules: {
				term: { required: true }
			},
			messages: {
				term: {
					required: "Please Enter Text."
				}
			}
		});
		 
	});
</script>
<style>
.errSearch{display: block;color: #F00;vertical-align: top;line-height: 20px;}
</style>
<div id="content-main"> 
  	<div class="wrapper">
    <div class="help_center_header">
    	<h1>Welcome to the Help Center</h1>
    </div>
    <div class="faq_block">
    	<h2>
        	<span>FAQ</span>
            <div class="devider"></div>
        </h2>
                       
        <form method="post" class="search" action="<?php echo SITE_URL; ?>help/search/" name="frm-faq" id="frm-faq" accept-charset="UTF-8">
            <div style="margin:0;padding:0;display:inline">
            	<input type="hidden" value="✓" name="utf8" class="hidden">
            </div>
            
                <div id="faq-search"> <span class="icon-faq-search"></span> <span id="icon-search-clear" class="icon-search-clear" onclick="return clearText();" style="display: none;"></span>
                    <div class="search_box">
                    <!--onfocus="return placeholdertext();" -->
                    <input type="text" placeholder="Search the FAQ" name="term" id="inputString" class="help faq-text" onkeyup="lookup(this.value);" onblur="fill1();">
                    <input type="button" value="Search" id="faq-submit">
                    </div>
                    <div class="faq-results suggestionsBox" id="suggestions" style="display:none;">
                        <ul class="result_list" id="autoSuggestionsList"></ul>
                        <div class="no_faq_results" id="no_faq_results" style="display: none;">Sorry, we couldn't find anything.</div>
                    </div>
               
            </div>
        </form>
        <center><div id="errorSearch"></div></center>
        <?php 
			$sel_faq_category=$con->recordselect("SELECT * FROM `faqcategory` WHERE `faqCategoryParentId` =0 AND faqStatus!='0' ORDER BY faqCategoryId ASC LIMIT 3");
			while($sel_main_category=mysql_fetch_assoc($sel_faq_category))
			{
		?>
            <div class="grid">
                <h3><a title="<?php echo $sel_main_category['faqcategoryName']; ?>" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId'].'/'.Slug($sel_main_category['faqcategoryName']).'/'; ?>">
						<?php echo $sel_main_category['faqcategoryName']; ?>
                    </a>
                </h3>
                <ul>
                    <?php 
                        $sel_faq_question=$con->recordselect("SELECT * FROM `faqquestionanswer` WHERE faqCategoryParentId='".$sel_main_category['faqCategoryId']."' LIMIT 4");
                        while($selFaqQuestion=mysql_fetch_assoc($sel_faq_question))
                        {
                    ?>
                    <?php /*?><li><a class="anchor" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId']; ?>/#<?php echo $selFaqQuestion['faqQuestionAnswerTime']; ?>"><?php echo $selFaqQuestion['faqQuestion']; ?></a></li><?php */?>
                    <li><a title="<?php echo $selFaqQuestion['faqQuestion']; ?>" class="anchor" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId']; ?>/#<?php echo Slug($selFaqQuestion['faqQuestion']).'/' ;?>">
							<?php echo $selFaqQuestion['faqQuestion']; ?>
                        </a>
                    </li>
                    <?php }//While Over ?>
                </ul>
                <a class="faq-see-all" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId']; ?>"><span class="faq-icon-arrow"></span><span>See All</span></a>  
            </div>
        <?php } //While Over ?>
        <div class="flclear"></div>
    </div>
    </div>
</div>