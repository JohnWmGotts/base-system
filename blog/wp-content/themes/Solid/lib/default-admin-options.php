<?php
/**
 * Setting the default admin theme options and menus
*/

    $themater_current_theme = wp_get_theme();
    $themater_current_theme_uri = $themater_current_theme->{'Author URI'};
    
    if(isset($_REQUEST('themater_welcome_guide_display')) && $_REQUEST['themater_welcome_guide_display']) {
        update_option('themater_welcome_guide_' . $themater_current_theme->Template, $_REQUEST['themater_welcome_guide_display']);
    }
    
    $themater_welcome_guide_option = get_option('themater_welcome_guide_' . $themater_current_theme->Template);
    
    $themater_welcome_guide_content = "
        <p>
            This is a quick startup guide and feature tour of the $themater_current_theme->Name theme. If you're new to WordPress or our themes we recommend you check this out before you start using $themater_current_theme->Name. You will learn what special features are available and how to use the theme options page. Let's get started!
            <br /><em>You can hide this guide by clicking on Hide Button at the end of this page. This guide is always available under the \"Support\" tab.</em>
        </p>
        
        <div class='tt-form-element'><div class='tt-form-label'>Theme Features List</div>
            <div class='tt-element-content'><p>
                $themater_current_theme->Name comes with a bunch of special features! 
                <ul style='list-style: disc; padding-left: 25px;'>
                    <li>Featured Posts Slider</li>
                    <li>Responsive Design (Mobole Phone &amp; Tablet Friendly)</li>
                    <li>Shortcodes</li>
                    <li>Page templates (Contact Form, Archives Page, Full Width Page, Sitemap)</li>
                    <li>WooCommerce Shopping Cart Support</li>
                    <li>7+ Custom Widgets</li>
                </ul>
            </p></div>
        </div><!--Theme Features List-->
        
        <div class='tt-form-element'><div class='tt-form-label'>General Theme Options</div>
            <div class='tt-element-content'><p>
                There are loads of ways to customise your theme here! You can change just about anything in the theme from the logo image to the speed of the slideshow. The options are also divided into tabs so you can easily navigate through your choices.
                For example, if you wanted to remove or replace the default header banner, you can click on the \"Ads\" tab and then either delete or customise the code in the \"header banner\" box. Just click save and then you're done! Easy as that. 
            </p></div>
        </div><!---->
        
        <div class='tt-form-element'><div class='tt-form-label'>Custom Menus</div>
            <div class='tt-element-content'><p>
                $themater_current_theme->Name allows you to change what appears in the menu bar using a simple drag-and-drop options screen. You can access this page by clicking on the wp-admin / Appearance / Menus. You can have many different custom menus and you can assign them to either the primary or secondary menu.
                <br />

                Creating a custom menu is very simple. These 5 short steps will show you how:
                
                <ol style='padding-left: 25px;'>
                    <li>You need to create a menu before you can add your links to it. To do this, enter a name for your menu in the \"Menu Name\" box and click \"Create Menu\".</li>
                    <li>You can now see your list of pages and categories that you have on WordPress. Each page and category has a checkbox next to it. You can select which links you want to add to your menu by selecting the box next to it and then clicking the \"Add to Menu\" button. <br /><em>(Tip: Want to add individual posts or tags to the menu too? Click the \"screen options\" button at the very top right of your screen. You'll see the option to select \"posts\" and \"tags\" appear.)</em></li>
                    <li>Once added, you can no arrange your links in the order you choose. Drag-and-drop your links up and down to change their order.</li>
                    <li>Did you know you can have drop-down menus? Drag your link to the right underneath another link to make that link appear in a drop-down list below the link above. For example, If I had the page \"Contact us\" and I wanted the page \"Directions\" to appear in a drop down list below it, I would place the \"Directions\" link below the \"Contact us\" link, and then drag the \"Directions\" link to the right to indent it.</li>
                    <li>Now you've finished organising your menu, click the \"save menu\" button on the right. You now need to assign this custom menu to one of the menus on the theme. The top left box called \"theme locations\" lists the place you can put your menu. If you want your custom menu to appear in the primary menu spot, select your custom menu from the drop-down box and then click \"save\". Your custom menu now appears on your website!</li>
                </ol>
     
            </p></div>
        </div><!--Custom Menus-->
        
        <div class='tt-form-element'><div class='tt-form-label'>Configure the Slider (Featured Posts)</div>
            <div class='tt-element-content'><p>
                The slideshow is very easy to use. It scrolls through the posts, pages or even custom slides that you've written. You can access the options for the slideshow in the theme options under the \"Featured Posts\" tab. Let's take a quick look at what you can do:
    
                <ul style='list-style: disc; padding-left: 25px;'>
                    <li>The first set of options let you choose where you want your slideshow to appear. Our demos show the slideshow only on the homepage but you can display it everywhere if you wanted.</li>
                    <li>Featured post images - Although not an option, this has important information. It shows you the dimensions of the images that are shown in the slideshow and has information explaining how to set a \"featured image\" in WordPress. <br /><em>(Tip: If you need more help setting up a featured image, check out the FAQ section in the Support Forums. You can find the link in the \"support\" tab in the theme options)</em></li>
                    <li>Featured Posts Source - This is where the power is! You can choose to show either custom posts which you can edit yourself, the most recent posts from a specific category, selected posts based on the post ID or selected pages based on the page ID. If you choose to show posts by category you can also select how many of the most recent posts are displayed. Remember, if you use posts or pages, you must have a featured image set for all the posts/pages in the slideshow for it to work!</li>
                    <li>Slideshow Effect - A whole range of sliding or fading effects are available for your slideshow. You can select the one you want from this drop down box</li>
                    <li>Misc Options - These last options are all about tweaking your slideshow to be just right. Most of the time the default options will do fine but sometimes you just want to make that tiny little adjustment to things! </li>
                </ul>
            </p></div>
        </div><!--Configure the Slider-->
        
        <div class='tt-form-element'><div class='tt-form-label'>Customise the Sidebars (Widget Areas)</div>
            <div class='tt-element-content'><p>
                $themater_current_theme->Name lets you choose what you want to put in your sidebar. Each item in a sidebar is called a widget. The theme puts its own widgets in the sidebars by default so that it doesn't look too empty when you first get it, but when you add your own widgets to the sidebar the default ones will be removed. You can set your own widgets by going to the wp-admin / Appearance / Widgets. To add your own widgets just drag and drop the widgets (shown in the middle of the screen) to the sidebars (shown on the right of the screen). Just like the menus, you can drag-and-drop them into any order you want.
                <br /> This theme also comes with 7+ widgets of its own! Here's a brief summary for some widgets:
                <ul style='list-style: disc; padding-left: 25px;'>
                    <li>125X125 Banners - Allows you to add small square adverts in a grid pattern</li>
                    <li>Recent Comments - Displays a list of the most recent comments made on your site</li>
                    <li>Facebook Like Box - If you have facebook, you can display a \"like\" button with other cool stuff</li>
                    <li>Info Box - Place images and text in the sidebar.</li>
                    <li>Posts with Images - Displays a list posts with your own settings. You can add your own filters, include a thumbnail image etc.</li>
                    <li>Social Profiles - Displays icons that link to your profiles on popular social networking sites</li>
                    <li>Tabs Widget - A list of different widgets can be added into a tabbed widget much like the theme options page is tabbed</li>
                </ul>
            </p></div>
        </div><!--Customise the Sidebars-->
        
        
        
        <div class='tt-form-element'><div class='tt-form-label'>Page Templates</div>
            <div class='tt-element-content'><p>
                You can choose to display different page templates on your site if you choose! One important one is the full width template page which removes the sidebar(s) from your theme if you want to have a page which lets you put wider content in your website! The other page templates are the sitemap, which lists all the categories and pages in your site; the archive page which lists the most recent posts on your site in a simple list; and the contact form page which has  a built in ready to use contact form!
                <br />A page template can be selected when on the page editing screen. On the right hand side you'll see a box called \"page attributes\" with the \"template\" drop-down box inside.
            </p></div>
        </div><!--Page Templates-->
        
        <div class='tt-form-element'><div class='tt-form-label'>Contact Form</div>
            <div class='tt-element-content'><p>
                Once you've assigned a page as a contact form you'll need to set the email address that you want to receive the emails to. By default it's the admin email address you used when settings up WordPress but to change it you can go to the \"general\" tab in the theme options.
            </p></div>
        </div><!--Contact Form-->
        
        <div class='tt-form-element'><div class='tt-form-label'>WooCommerce Support</div>
            <div class='tt-element-content'><p>
               It is a great shopping cart plugin. Now you can easily open your online store. The theme supports and works very well with the plugin.
            </p></div>
        </div><!---->
        
        <div class='tt-form-element'><div class='tt-form-label'>Shortcodes</div>
            <div class='tt-element-content'><p>
                A shortcode is a WordPress-specific code that lets you do nifty things with very little effort. Shortcodes can embed files or create objects that would normally require lots of complicated, ugly code in just one line.
                <br />
                We added some extra options to your text editor that you use when writing posts and pages. These icons generates a shortcode for you and places it in your editor. 
                <br />
                <img src=\"$themater_current_theme_uri/wp-content/pro/shortcodes.png\" style=\"max-width: 100%;\" /><br>
                The custom shortcodes included in this theme are:
                <ul style='list-style: disc; padding-left: 25px;'>
                    <li>Columns - Allows you to make columns of text and images</li>
                    <li>Buttons - Allows you to create buttons</li>
                    <li>Labels and Badges - add a label or badge to a portion of your post or page</li>
                    <li>Tabs - Create tabbed section of content much like the theme option page uses tabs</li>
                    <li>Icons - Display an icon on your site</li>
                    <li>Collapse Items - this creates a list of titles that can be clicked to display more information. This is useful for things like an FAQ</li>
                    <li>Notifications - Allows you to create notifications that appear on your page</li>
                </ul>
                You can aslo check the <a href=\"$themater_current_theme_uri/themedemo/shortcodes/?wptheme=$themater_current_theme->Template\" target=\"_blank\">online demonstration</a> of these shortcodes.
            </p></div>
        </div><!--Shortcodes-->
        
        <div class='tt-form-element'><div class='tt-form-label'>Conclusion</div>
            <div class='tt-element-content'><p>
                That's it! We hope you enjoy creating your new website. Remember that if you need any more help you can come visit us in the support forum. You can find more support links in the theme options under the \"Support\" tab. Thank you!
                </ul>
            </p></div>
        </div><!--Conclusion-->
    ";
    
    $themater_welcome_guide_hide_button = "
        <div class='tt-form-element'><div class='tt-form-label'>Hide This Guide</div>
            <div class='tt-element-content'><p>Click on below button to hide this guide.</p>
                <p><a href=\"" . admin_url('themes.php?page=themater&themater_welcome_guide_display=false') . "\" class=\"button\">Hide The Welcome Guide</a></p>
                
                <p>You can always read it again from the \"Support\" tab.</p>
            </div>
        </div><!--Hide This Guide-->
    ";
    
    $themater_welcome_guide_show_button = "
        <div class='tt-form-element'><div class='tt-form-label'>Show This Guide in Welcome Tab</div>
            <div class='tt-element-content'><p>Click on below button to show this guide in Welcome Tab.</p>
                <p><a href=\"" . admin_url('themes.php?page=themater&themater_welcome_guide_display=true') . "\" class=\"button\">Show This Guide in Welcome Tab</a></p>
                
            </div>
        </div><!--Show This Guide-->
    ";
    
    if($themater_welcome_guide_option != 'false') {
        $this->admin_option(array('Welcome', 9), 
            'Theme Guide &amp; Feature Tour', 'logo', 
            'content', $themater_welcome_guide_content . $themater_welcome_guide_hide_button,
            array('style'=> 'font-size: 14px; line-height: 20px;')
        );
    }
    
    $this->admin_option(array('Support', 9999), 
        '<br />Theme Guide &amp; Feature Tour', 'logo', 
        'content', $themater_welcome_guide_content . $themater_welcome_guide_show_button,
        array('style'=> 'font-size: 14px; line-height: 20px;', 'priority' => 9999)
    );

    /*********************************************
     * General Options
     *********************************************
    */

        // General Settings
        $this->admin_option('General', 
            'Logo Image', 'logo', 
            'imageupload', get_bloginfo('template_directory') . "/images/logo.png", 
            array('help' => "Enter the full url to your logo image. Leave it blank if you don't want to use a logo image.")
        );
        
        $this->admin_option('General', 
            'Favicon', 'favicon', 
            'imageupload', get_bloginfo('template_directory') . "/images/favicon.png", 
            array('help' => "Enter the full url to your favicon file. Leave it blank if you don't want to use a favicon.")
        );
        
        $this->admin_option('General',
            'Contact Form Email', 'contact_form_email', 
            'text', get_option('admin_email'),
            array('display' => 'extended', 'help' => 'The messages submitted from the contact form will be sent to this email address.')
        );

        $this->admin_option('General',
           'Posts Date Format', 'dateformat', 
            'text', 'F d, Y', 
            array('help' => 'Please, check <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">this reference</a> for more details.', 'display'=>'extended')
        );
        
        $this->admin_option('General',
            'RSS Feed URL', 'rss_url', 
            'text', '', 
            array('help' => 'Enter your custom RSS Feed URL, Feedburner or other.')
        );
        
        $this->admin_option('General',
            'Custom CSS', 'custom_css', 
            'textarea', '', 
            array('help' => 'Any code you add here will appear in the head section of every page of your site. Add only the css code without &lt;style&gt;&lt;/style&gt; style blocks. They are auto added.', 'style'=>'height: 180px;')
        );
        
        $this->admin_option('General',
            'Head Code', 'head_code', 
            'textarea', '', 
            array('help' => 'Any code you add here will appear in the head section, just before &lt;/head&gt; of every page of your site.', 'style'=>'height: 180px;')
        );
        
        $this->admin_option('General',
            'Footer Code', 'footer_code', 
            'textarea', '', 
            array('help' => 'Any code you add here will appear just before &lt;/body&gt; tag of every page of your site.', 'style'=>'height: 180px;')
        );
        
        $this->admin_option('General',
        'Reset Theme Options', 'reset_options', 
        'content', '
        <div id="fp_reset_options" style="margin-bottom:40px; display:none;"></div>
        <div style="margin-bottom:40px;"><a class="button-primary tt-button-red" onclick="if (confirm(\'All the saved settings will be lost! Do you really want to continue?\')) { themater_form(\'admin_options&do=reset\', \'fpForm\',\'fp_reset_options\',\'true\'); } return false;">Reset Options Now</a></div>', 
        array('help' => 'Reset the theme options to default values. <span style="color:red;"><strong>Note:</strong> All the previous saved settings will be lost!</span>', 'display'=>'extended-top')
    );
    
    
    /*********************************************
     * Layout Options
     *********************************************
    */
        
        $this->admin_option('Layout', 
            'Featured Image Options', 'featured_image_settings', 
            'content', ''
        );
        
        $this->admin_option('Layout',
            'Image Width', 'featured_image_width', 
            'text', '200', 
            array('display'=>'inline', 'style'=>'width: 100px;', 'suffix'=>' px.')
        );
        
        $this->admin_option('Layout',
            'Image Height', 'featured_image_height', 
            'text', '160', 
            array('display'=>'inline', 'style'=>'width: 100px;', 'suffix'=>' px.')
        );
        
        $this->admin_option('Layout',
            'Image Position', 'featured_image_position', 
            'radio', 'alignleft', 
            array('options'=>array('alignleft' => 'Left', 'alignright'=> 'Right', 'aligncenter'=>'Center') , 'display'=>'inline')
        );
        
        
        $this->admin_option('Layout',
            '"Read More" Text', 'read_more', 
            'text', 'Read More'
        );

        $this->admin_option('Layout', 
            'Custom Footer Text', 'footer_custom_text', 
            'textarea', '', 
            array('help' => 'Add your custom footer text. Will override the default theme generated text.', 'display'=>'extended-top', 'style'=>'height: 140px;')
        );
    
   /*********************************************
     * Ads
     *********************************************
    */

    $this->admin_option('Ads', 
        'Header Banner', 'header_banner', 
        'textarea', '', 
        array('help' => 'Enter your 468x60 px. ad code. You may use any html code here, including your 468x60 px Adsense code.', 'style'=>'height: 120px;')
    ); 
    

    /*********************************************
     * Support
     *********************************************
    */
    $get_theme_data = array(); $get_theme_data["Name"] = $themater_current_theme->Name; $get_theme_data["Version"] = $themater_current_theme->Version; $get_theme_data["Author"] = $themater_current_theme->Author; $get_theme_data["URI"] = $themater_current_theme->get( "ThemeURI" ); $get_theme_data["AuthorURI"] = $themater_current_theme->{"Author URI"};
    $this->admin_option('Support',
        'Support', 'support',
        'raw', '<ul>
        <li><strong>Theme:</strong> ' . $get_theme_data['Name'] . ' ' . $get_theme_data['Version']  .' </li>
        <li><strong>Theme Author:</strong> <a href="' . $get_theme_data['AuthorURI'] . '" target="_blank">' . $get_theme_data['Author'] . '</a></li>
        <li><strong>Theme Homepage:</strong> <a href="' . $get_theme_data['URI'] . '" target="_blank">' . $get_theme_data['URI'] . '</a></li>
        <li><strong>Support Forums:</strong> <a href="' . $get_theme_data['AuthorURI'] . '/forum/" target="_blank">' . $get_theme_data['AuthorURI'] . '/forum/</a></li>
        </ul>'
    );
    
    $the_theme_slug_url =  str_replace(' ', '-', trim(strtolower($get_theme_data['Name'])));
    $this->head_msg = '<div class="tt-notice" style="width: 800px; margin: 15px 0;">You can buy this theme without footer links online at <a href="' . $get_theme_data['AuthorURI'] . '/buy/?theme=' . $the_theme_slug_url . '" target="_blank">' . $get_theme_data['AuthorURI'] . '/buy/?theme=' . $the_theme_slug_url . '</a><br />Upgrading is easy. You will NOT lose your current settings or already made customizations.</div>'; //the_theme_slug_url 
 ?>