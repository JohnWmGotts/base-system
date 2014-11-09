<?php get_header(); ?>

    <div id="main-fullwidth" class="span-24">
    
    <div class="content">
    
        <div class="woocommerce">
           <?php if(function_exists('woocommerce_content')) { woocommerce_content(); } ?>
       </div>
        
    </div><!-- .content -->
    
    </div><!-- #main-fullwidth-->

<?php get_footer(); ?>