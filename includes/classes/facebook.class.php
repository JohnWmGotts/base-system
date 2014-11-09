<?php
require 'facebook.php';
  class facebook_login
  {
      function facebook_login($id,$secret,$callback="",$permission=0)
      {
          if(!$permission)
          {
              //$permission = "email, publish_stream, read_stream, offline_access,user_birthday,user_location,read_friendlists,sms";
			  $permission = "public_profile,email,user_friends"; // jwg
          }
          else
          {
              $permission = $permission;
          }
          if($permission==-1)
          {
              $permission = "";
          }
          $this->ApplicationID = "$id";
          $this->ApplicationSecret = "$secret";
          $this->CallBack = "$callback"; 
          $this->Permission = "$permission"; 
          $this->facebook = new Facebook(array(
          'appId'  => $this->ApplicationID,
          'secret' => $this->ApplicationSecret,
          'cookie' => true,
          ));
      }   
      function connection()
      {
          
          $session = $this->facebook->getSession();
          $me = null;
          if($session)
          {
              try
              {
                  $uid = $this->facebook->getUser();
                  $me = $this->facebook->api('/me');
              }
              catch(FacebookApiException $e)
              {
                  error_log($e);
              }
          }
          
          
          return "<!doctype html>
          <html xmlns:fb=\"http://www.facebook.com/2008/fbml\">
          <head>
          </head>
          <body>
          <div id=\"fb-root\"></div>
          <script>
            window.fbAsyncInit = function()
            {
                FB.init
                ({
                    appId   : '".$this->facebook->getAppId()."',
                    session : ".json_encode($session).",
                    status  : true, // check login status
                    cookie  : true, // enable cookies to allow the server to access the session
                    xfbml   : true // parse XFBML
                });
                FB.Event.subscribe('auth.login', function()
                {
                    window.location.reload();
                });
            };
          
          (function()
          {
            var e = document.createElement('script');
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
            }());
            </script>
            
            <fb:login-button perms=\"".$this->Permission."\" onlogin='window.location=\"".$this->CallBack."\";'>Connect</fb:login-button> 
          </body>
          </html>";
      }
      function InformationInfo()
      {
          if($_REQUEST["fbs_".$this->ApplicationID]=="")
          return "Permission Disallow!";
          $PermissionCheck = split(",",$this->Permission);
          $a = str_ireplace("\"","",$_REQUEST["fbs_".$this->ApplicationID]);
          if(!$a)
          {
              return "Permission Disallow!";
          }
          $user = json_decode(file_get_contents('https://graph.facebook.com/me?'.$a));
          $Result["UserID"]      = $user->id;
          $Result["Name"]        = $user->name;
          $Result["FirstName"]   = $user->first_name;
          $Result["LastName"]    = $user->last_name;
          $Result["ProfileLink"] = $user->link;
          $Result["ImageLink"] = "<img src='https://graph.facebook.com/".$user->id."/picture' />";
          $Result["About"]       = $user->about;
          $Result["Quotes"]      = $user->quotes;
          $Result["Gender"]      = $user->gender;
          $Result["TimeZone"]    = $user->timezone;
          if(in_array("email",$PermissionCheck))
          {
              $Result["Email"]       = $user->email;
          }
          if(in_array("user_birthday",$PermissionCheck))
          {
              $Result["Birthday"]    = $user->birthday;
          }
          if(in_array("user_location",$PermissionCheck))
          {
              $Result["PermanentAddress"]    = $user->location->name;
              $Result["CurrentAddress"]    = $user->hometown->name;
          }
          return $Result;
      }
      function FBLogin()
      {
          $session = $this->facebook->getSession();
          $me = null;
          if($session)
          {
              try
              {
                  $uid = $this->facebook->getUser();
                  $me = $this->facebook->api('/me');
              }
              catch(FacebookApiException $e)
              {
                  error_log($e);
              }
          }
          if($me)
          {
              return $this->InformationInfo();
              //return "<a href=".$this->facebook->getLogoutUrl()."><img src=\"http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif\"></a>";
          }
          else
          {
              return $this->connection();
          }
      }
  }
?>
