<?php
/**
* Template Name: Sitemap
*/

get_template_part('content', 'before');
?>

        <div class="content">
    
         <?php $theme->hook('content_before'); ?>
        
            <div class="post-wrap post-wrap-page">
            
                <div <?php post_class('post clearfix'); ?> id="post-<?php the_ID(); ?>">
                    <h2 class="title"><?php the_title(); ?></h2>
                    <?php
                        if(is_user_logged_in())  {
                            ?><div class="postmeta-primary"><span class="meta_edit"><?php edit_post_link(); ?></span></div><?php
                        } 
                    ?>
                    <div class="entry clearfix">
                            
                        <?php
                            if(has_post_thumbnail())  {
                                the_post_thumbnail(
                                    array(300, 225),
                                    array("class" => "alignleft featured_image")
                                );
                            }
                        ?>
                        
                        <?php
                            the_content(''); 
                            wp_link_pages( array( 'before' => '<p><strong>' . __( 'Pages:', 'themater' ) . '</strong>', 'after' => '</p>' ) );
                        ?>
        
                    </div>
                    
                </div><!-- Page ID <?php the_ID(); ?> -->
                
            </div><!-- .post-wrap -->
            
            <div class="sitemap">
            
                <div class="clearfix">
                    <div class="alignleft sitemap-col">
                        <h2><?php _e('Pages', 'themater'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_list_pages('title_li='); ?>
                        </ul>
                    </div>
                    
                    <div class="alignleft sitemap-col">
                        <h2><?php _e('Categories', 'themater'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_list_categories('title_li='); ?>
                        </ul>
                    </div>
                    
                    <div class="alignleft sitemap-col">
                        <h2><?php _e('Archives', 'themater'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_get_archives('type=monthly&show_post_count=0'); ?>
                        </ul>
                    </div>
                </div>
                
                <div>
                    <h2><?php _e('Posts per category', 'themater'); ?></h2>
                    
                    <?php
			    
			            $cats = get_categories();
			            foreach ( $cats as $cat ) {
			    
			            query_posts( 'cat=' . $cat->cat_ID );
			
			        ?>
	        
	        			<h3><?php echo $cat->cat_name; ?></h3>
			        	<ul class="sitemap-list">	
	    	        	    <?php while ( have_posts() ) { the_post(); ?>
	        	    	    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	            		    <?php } wp_reset_query(); ?>
			        	</ul>
	    
	    		    <?php } ?>
                    
                </div>
                
            </div>
            
            <?php $theme->hook('content_after'); ?>
            
        </div>

<?php get_template_part('content', 'after'); ?>