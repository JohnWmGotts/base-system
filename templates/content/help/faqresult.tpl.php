<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length > 0) {
			$('#icon-search-clear-all').show();	
		}else{ $('#icon-search-clear-all').hide(); }
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
		window.location= application_path+"help/"+id+"/#"+question;
	}
	function fill1() {
		setTimeout("$('#suggestions').fadeOut();", 200);
	}
	function clearText()
	{
		document.getElementById("inputString").value="";
		if ( $.browser.msie ) {
			$("#inputString").val("Search the FAQ");
		}
		$('#icon-search-clear-all').hide();
	}
	function placeholdertext()
	{
		document.getElementById("faq-overlabel").innerHTML="";
	}
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#faq-submit").click(function () { $("#frm-faq").submit(); });
		  
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
	});
</script>

<div id="content-main"> 
  	<div class="wrapper">
    	<div class="sidebar-help">
            <h3><a title="FAQ" href="<?php echo SITE_URL; ?>help/">FAQ</a></h3>
            <div class="sub_cat">
            	<ul>
                	<?php 
					
						$sel_faq_category=$con->recordselect("SELECT * FROM `faqcategory` WHERE `faqCategoryParentId` =0 AND faqStatus!='0' ORDER BY faqCategoryId ASC");
						while($sel_main_category=mysql_fetch_assoc($sel_faq_category))
						{
					?>
                        <li><a title="<?php echo $sel_main_category['faqcategoryName']; ?>" class="anchor" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId'].'/'.Slug($sel_main_category['faqcategoryName']).'/'; ?>">
							<?php echo $sel_main_category['faqcategoryName']; ?></a>
						<?php 
                            $sel_faq_subcat=$con->recordselect("SELECT * FROM `faqcategory` WHERE faqCategoryParentId='".$sel_main_category['faqCategoryId']."'");
                            while($selFaqSubCat=mysql_fetch_assoc($sel_faq_subcat))
                            {
                        ?>
                            <?php /*?><li class="subcat"><a data="HowItWork" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId']; ?>/#<?php echo $selFaqSubCat['faqCategoryTime']; ?>"><?php echo $selFaqSubCat['faqcategoryName']; ?></a></li><?php */?>
                            <li class="subcat"><a title="<?php echo $selFaqSubCat['faqcategoryName']; ?>" data="HowItWork" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId']; ?>/#<?php echo Slug($selFaqSubCat['faqcategoryName']).'/'; ?>">
								<?php echo $selFaqSubCat['faqcategoryName']; ?></a>
                            </li>
                        <?php } ?>
                        <div class="space20"></div>
						</li>
                    <?php } ?>  
                </ul>
            </div>            
        </div>
        
        <div class="rightbar">
        	<h1><?php echo $sel_faq_main_title['faqcategoryName']; ?></h1>
            <form method="post" class="search" action="<?php echo SITE_URL; ?>help/search/" name="frm-faq" id="frm-faq" accept-charset="UTF-8">
            	<input type="hidden" value="✓" name="utf8" class="hidden">
                <div id="faq-search" class="field faq-search-all"> 
                	<span class="icon-faq-search-all"></span> 
                    <span id="icon-search-clear-all" class="icon-search-clear-all" onclick="return clearText();" style="display: none;"></span>
                    <!--onfocus="return placeholdertext();"-->
                    <input type="text" placeholder="search here" name="term" id="inputString"  onkeyup="lookup(this.value);" onblur="fill1();"  >
                    <div class="all-faq-results suggestionsBox" id="suggestions" style="display:none;">
                        <ul class="result_list" id="autoSuggestionsList"></ul>
                        <div class="no_faq_results" id="no_faq_results" style="display: none;">Sorry, we couldn't find anything.</div>
                    </div>
                  	<div class="all-faq-submit" id="faq-submit">Search</div>
                </div>
			</form>
            <?php 
			/*print "SELECT faqStatus FROM `faqcategory` WHERE `faqCategoryParentId`=0 AND faqCategoryId='".$_GET['id']."'";*/
			$sel_faq_categoryMain=mysql_fetch_array($con->recordselect("SELECT faqStatus FROM `faqcategory` WHERE `faqCategoryParentId` =0 AND faqCategoryId='".$_GET['id']."'"));
			//echo 'status'.$sel_faq_categoryMain['faqStatus'];
			if($sel_faq_categoryMain['faqStatus']!='0') {
				$sel_sub_title=$con->recordselect("SELECT * FROM `faqcategory` WHERE `faqCategoryParentId` ='".$_GET['id']."' ORDER BY faqCategoryId ASC");
				while($selSubTitle=mysql_fetch_assoc($sel_sub_title))
				{
			?>
            	<h3><?php echo $selSubTitle['faqcategoryName']; ?></h3>
				<?php
                    $sel_faq_questions=$con->recordselect("SELECT * FROM `faqquestionanswer` WHERE faqCategoryId='".$selSubTitle['faqCategoryId']."'");
                    while($selFaqQuestions=mysql_fetch_assoc($sel_faq_questions))
                    { ?>
                        <h4 class="anchor"><a title="<?php echo unsanitize_string($selFaqQuestions['faqQuestion']); ?>" class="anchor" href="#<?php echo Slug($selFaqQuestions['faqQuestion']) ;?>">
							<?php echo unsanitize_string($selFaqQuestions['faqQuestion']); ?>
                            </a></h4>
            	<?php } ?>
                <div class="space20"></div>
            <?php } ?>    
            <?php } ?>
            
            <div class="content_midle">
            	<?php 
				$sel_faq_categoryMain=mysql_fetch_array($con->recordselect("SELECT faqStatus FROM `faqcategory` WHERE `faqCategoryParentId` =0 AND faqCategoryId='".$_GET['id']."'"));
			if($sel_faq_categoryMain['faqStatus']!='0') {
					$sel_sub_title1=$con->recordselect("SELECT * FROM `faqcategory` WHERE `faqCategoryParentId` ='".$_GET['id']."' ORDER BY faqCategoryId ASC");
					while($selSubTitle1=mysql_fetch_assoc($sel_sub_title1))
					{
                ?>
                <li id="<?php echo Slug($selSubTitle1['faqcategoryName']);?>">
					<a name="<?php echo Slug($selSubTitle1['faqcategoryName']);?>" ></a>
                    <h2><?php echo $selSubTitle1['faqcategoryName'] ?></h2><h6><a href="#">Top ↑</a></h6>
                    <div class="clear"></div>
                        <?php
                            $sel_faq_questionanswer=$con->recordselect("SELECT * FROM `faqquestionanswer` WHERE faqCategoryId='".$selSubTitle1['faqCategoryId']."'");
                            while($selFaqQuestionAnswer=mysql_fetch_assoc($sel_faq_questionanswer))
                            {
                        ?>
                            <h3 id="<?php echo Slug($selFaqQuestionAnswer['faqQuestion']); ?>"><?php echo unsanitize_string($selFaqQuestionAnswer['faqQuestion']); ?></h3>
                            <p><?php echo unsanitize_string($selFaqQuestionAnswer['faqAnswer']); ?></p>
                       <?php } ?> 
                </li>
				<?php } ?>
                <?php } ?>
                <div class="flclear"></div>
            </div>
        </div>
    <div class="flclear"></div>
  </div>
</div>