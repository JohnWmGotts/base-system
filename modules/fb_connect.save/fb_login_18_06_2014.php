<?php //if($_SESSION['ses_name']=='') { ?>

  <script type="text/javascript">
    //<![CDATA[	 
      window.fbAsyncInit = function() {
            FB.init({appId: '1445733892307042',status:true, cookie: true, xfbml: true}); 
            /* All the events registered */
            FB.Event.subscribe('auth.login', function(response) {
                // do something with response
				login();
            });
            FB.Event.subscribe('auth.logout', function(response) {
                // do something with response                   
            });
            FB.logout(function(response) {
                  // user is now logged out
            }); 
          
        };		
        (function() {
			var e = document.createElement('script');
			e.type = 'text/javascript';
			e.src = 'http://connect.facebook.net/en_US/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		}()); 
        function login(){                
            fqlQuery();
        }           
//stream publish method
        function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
            FB.ui(
            {
                method: 'stream.publish',
                message: '',
                attachment: {
                    name: name,
                    caption: '',
                    description: (description),
                    href: hrefLink
                },
                action_links: [
                    { text: hrefTitle, href: hrefLink }
                ],
                user_prompt_message: userPrompt
            },
            function(response) { 
            }); 
        }
        function graphStreamPublish(){
            var body = 'Reading New Graph api &amp; Javascript Base FBConnect Tutorial';
            FB.api('/me/feed', 'post', { message: body }, function(response) {
                if (!response || response.error) {
                    alert('Error occured');
                } else {
                    alert('Post ID: ' + response.id);
                }
            });
        }
        function fqlQuery(){				 
           FB.api('/me', function(response) {
                var query = FB.Data.query('select username,name,first_name,last_name,email,birthday,current_location,sex,pic,pic_small,pic_big,about_me,education_history,work_history from user where uid={0}', response.id);
			query.wait(function(rows) {		
                       if(rows[0].username!=null)
                       {
                           var uname=rows[0].username;
                           document.getElementById('uname').value=uname;
                       }
                       else if(rows[0].name!=null)
                       {
                           var name=rows[0].name;
                           document.getElementById('uname').value=name;
                       }
                       if(rows[0].first_name!=null)
                       {
                           var fname=rows[0].first_name;
                           document.getElementById('fname').value=fname;
                       }
                       if(rows[0].last_name!=null)
                       {
                           var lname=rows[0].last_name;
                           document.getElementById('lname').value=lname;
                       }
                       if(rows[0].email!=null)
                       {
                           var email=rows[0].email;
                           document.getElementById('email').value=email;
                       }
                       if(rows[0].birthday!=null)
                       {
                           var birthdate=rows[0].birthday;
                           document.getElementById('bdate').value=birthdate;
                       }
                       if(rows[0].sex!=null)
                       {
                           var gender=rows[0].sex;
                           document.getElementById('gender').value=gender;
                       }
                       if(rows[0].uid!=null)
                       {
                           var uid=rows[0].uid;
                           document.getElementById('uid').value=uid;
                       }
                       if(rows[0].pic!=null)
                       {
                            var photo=rows[0].pic;
                            document.getElementById('photo').value=photo;
                       }
					   
					   if(rows[0].pic_big!=null)
                       {
                            var photo_big=rows[0].pic_big;
                            document.getElementById('photo_big').value=photo_big;
                       }
					   if(rows[0].pic_small!=null)
                       {
                            var pic_small=rows[0].pic_small;
                            document.getElementById('photo_small').value=pic_small;
                       }
					   if(rows[0].about_me!=null)
                       {
                            var about_me=rows[0].about_me;
                            document.getElementById('about_me').value=about_me;
                       }
					   
					   <?php if($fb_login_require == true && $fb_createProject_Id >0){?>
					   
					   if(rows[0].about_me!=null)
                       {
                            var about_me1=rows[0].about_me;
                            document.getElementById('fb_about_me').value=about_me1;
                       }
					   
					   if(rows[0].email!=null)
                       {
                           var email1=rows[0].email;
                           document.getElementById('fb_email').value=email1;
                       }
					   <?php } ?>  
					   
                       if(rows[0].education_history!=null)
                       {
                           var school=rows[0].education_history['name'];
                           document.getElementById('school').value=school;
                       }	
                       
                       if(rows[0].current_location!=null)
                       {
                           var city=rows[0].current_location['city'];
                           document.getElementById('city').value=city;
                           var state=rows[0].current_location['state'];
                           document.getElementById('state').value=state;
                           var country=rows[0].current_location['country'];
                           document.getElementById('country').value=country;
                           var zip=rows[0].current_location['zip'];
                           document.getElementById('zipcode').value=zip;
                                                          
                       }
                       if(rows[0].work_history !=null)
                       {
                           var work=rows[0].work_history['company_name '];
                           document.getElementById('work').value=school;
                          
                       }
					   document.login_frm1.submit();
                 });
            });
        }
        function setStatus(){
            FB.api(
              {
                method: 'status.set'
              },
              function(response) {
                if (response == 0){
                    alert('Your facebook status not updated. Give Status Update Permission.');
                }
                else{
                    alert('Your facebook status updated');
                }
              }
            );
        }
        //]]>
        function fblogin()
        {
             FB.getLoginStatus(function(response) {	
               // alert(response.status)
                if (response.status=="connected") {					
                    // logged in and connected user, someone you know		
                    login();				
                    
                } else if (response.status === 'not_authorized') {
                     // the user is logged in to Facebook, 
                     // but has not authenticated your app
                    FB.login(function(response){fblogin()},{scope:'email,user_birthday,user_location,user_about_me,user_website,user_education_history,user_work_history'});
                }
                else
                {
					//username,name,first_name,last_name,email,birthday, current_location, sex, pic, pic_small, pic_big,about_me, education_history ,work_history
                    FB.login(function(response){fblogin()},{scope:'email,user_birthday,user_location,user_about_me,user_website,user_education_history,user_work_history'});
                }
            });
            
        }
    </script>
<script type="text/javascript">
/*<![CDATA[	 
document.write('<fb:login-button perms="email,user_about_me,user_location,user_website"></fb:login-button>');
]]>*/
</script>
   <!-- <fb:login-button scope="email,user_birthday,status_update,publish_stream" ></fb:login-button>-->
      
      	
      	<form name="login_frm1" id="login_frm1" action="<?php echo SITE_MOD;?>fb_connect/fb_login_process.php"  method="post">
      		
			<?php if($fb_login_require == true && $fb_createProject_Id >0){?>
            	<input type="hidden" name="fb_createProject" id="fb_createProject" value="<?php echo $fb_createProject_Id; ?>"/>
                <input type="hidden" name="fb_login_require" id="fb_login_require"  value="TRUE" />
                <input type="hidden" name="fb_about_me" id="fb_about_me"  />
                <input type="hidden" name="fb_email" id="fb_email"  />
            <?php } ?>
            
            <input type="hidden" name="login" id="login"/>
            <input type="hidden" name="uname" id="uname"  />
            <input type="hidden" name="fname" id="fname"  />
            <input type="hidden" name="lname" id="lname"  />
            <input type="hidden" name="gender" id="gender"  />
            <input type="hidden" name="email" id="email"  />
            <input type="hidden" name="bdate" id="bdate"  />
            <input type="hidden" name="uid" id="uid"  />
            <input type="hidden" name="city" id="city"  />
            <input type="hidden" name="state" id="state"  />
            <input type="hidden" name="country" id="country"  />
            <input type="hidden" name="zipcode" id="zipcode"  />
            <input type="hidden" name="phone" id="phone"  />
            <input type="hidden" name="pass" id="pass"  />
            <input type="hidden" name="address" id="address"  />
            <input type="hidden" name="photo" id="photo"  />
            <input type="hidden" name="photo_big" id="photo_big"  />
            <input type="hidden" name="photo_small" id="photo_small"  />
            <input type="hidden" name="about_me" id="about_me"  />
            <input type="hidden" name="school" id="school"  />    
            <input type="hidden" name="work" id="work"  />
		</form>
	
<?php //} ?>