<?php
/**
* Template Name: Archives
*/

get_template_part('content', 'before');
?>

        <div class="content">  
              
            <?php $theme->hook('content_before'); ?>
        
            <?php if (have_posts()) while (have_posts()) : the_post(); ?> 
        
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
                
            <?php endwhile; ?>
            
            <div class="sitemap">
            
                <div>
                    <h2><?php _e('The Last 20 Posts', 'themater'); ?></h2>
                    
                    <ul class="sitemap-list">
                        <?php wp_get_archives('type=postbypost&limit=20&show_post_count=1'); ?>
                    </ul>
                    
                </div>
                
                <div class="clearfix">
                    
                    <div class="alignleft sitemap-col-archives">
                        <h2><?php _e('Categories', 'themater'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_list_categories('title_li=&show_count=1'); ?>
                        </ul>
                    </div>
                    
                    <div class="alignleft sitemap-col-archives">
                        <h2><?php _e('Monthly Archives', 'themater'); ?></h2>
                        <ul class="sitemap-list">
                            <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
                        </ul>
                    </div>
                </div>
                
            </div>
            
            <?php $theme->hook('content_after'); ?>
            
        </div>

<?php get_template_part('content', 'after'); ?>