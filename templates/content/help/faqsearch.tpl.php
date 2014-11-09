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
		//alert(question)
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
                            <li class="subcat"><a title="<?php echo $selFaqSubCat['faqcategoryName']; ?>" data="HowItWork" href="<?php echo $base_url; ?>help/<?php echo $sel_main_category['faqCategoryId']; ?>/#<?php echo Slug($selFaqSubCat['faqcategoryName']).'/'; ?>">
								<?php echo $selFaqSubCat['faqcategoryName']; ?>
                                </a></li>
                        <?php } ?>
                        <div class="space20"></div>
						</li>
                    <?php } ?>  
                </ul>
            </div>            
        </div>
        
        <!--<div class="faq-result-main">-->
		<?php $found = false; ?>
        <div class="rightbar">
        	<h1><?php if($term != '' && mysql_num_rows($sel_faq_search)>0)
				{
					$found = true;
					echo 'Search for "'.htmlentities(stripslashes($_POST['term'])).'"';
					if(mysql_num_rows($sel_faq_search)==1)
					{
						echo '<span>('.mysql_num_rows($sel_faq_search).' FAQ found)</span>';
					}
					else
					{
						echo '<span>('.mysql_num_rows($sel_faq_search).' FAQs found)</span>';
					}
				}
				else
				{
					echo '<p class="wordwrap">Sorry, no results for "'.htmlentities(stripslashes($_POST['term'])).'"</p>';
				}
				?>
			</h1>
            <?php if ($found) { ?>
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
            <div class="content_midle">
            	<div class="spaser2"></div>
				<?php 
                    if($term != '')
                    {
                        while($selFaqSearch=mysql_fetch_assoc($sel_faq_search))
                        {
                            $sel_main_cat = mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$selFaqSearch['faqCategoryParentId']."'"));
                            $sel_sub_cat = mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$selFaqSearch['faqCategoryId']."'"));
                    ?>
                          <h3><?php echo unsanitize_string($selFaqSearch['faqQuestion']); ?></h3>
                          <div class="faq-category">in <?php echo $sel_main_cat['faqcategoryName'].' / '.$sel_sub_cat['faqcategoryName']; ?></div>
                          <p><?php echo unsanitize_string($selFaqSearch['faqAnswer']); ?></p>
                        
                <?php } } ?>
            </div>
			<?php } ?>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>