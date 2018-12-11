<html>
<head>
	<title>js 登入 測試</title>
</head>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1156375791180386',
      xfbml      : true,
      version    : 'v2.5'
    });
  };//end of fbAsyncInit
	(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	function hello(){
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				alert("hello");
			}
		});
	}
	function logout(){
		FB.logout();
		alert("facebook logout");
	}
	function login(){
		FB.login(function(response) {
		    if (response.authResponse) {
			     console.log('Welcome! Fetching your information.... ');
			     FB.api('/me', function(response) {
			       console.log(response);
			       console.log('Good to see you, ' + response.name + '.');
			       console.log('Your user_id , ' + response.id);
			     });
			     
		    }else{
		     	console.log('User cancelled login or did not fully authorize.');
		     	
		    }
		} , {scope: 'publish_actions'});		
	}
	//取得使用者大頭貼
	function get_user_picture(){
		FB.getLoginStatus(function(response) {
			console.log(response.status);
		  if (response.status === 'connected') {
		  	
		  	FB.api('/me/picture?type=large' , function(response2) {
		       		console.log(response2.data.url);
			});
		    
		  } else if (response.status === 'not_authorized') {
		    // the user is logged in to Facebook, 
		    // but has not authenticated your app
		  } else {
		    FB.login(function(response) {});
		  }
		});
	}
	//發佈到facebook 個人塗鴉牆
	function publish_actions(){
		//publish_actions
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				 var accessToken = response.authResponse.accessToken;
				 	FB.api(
					    "/me/feed",
					    "POST",
					    {
					        "message": "This is a test message" ,
					        "link" : "your_link" ,
					        "picture" : "picture_url" ,
					        "access_token" : accessToken
					    },
					    function (response) {
					      if (response && !response.error) {
					        /* handle the result */
					        console.log(response);
					      }else{
					      	console.log(response);
					      }
					    }
					);
			} else if (response.status === 'not_authorized') {
			    // the user is logged in to Facebook, 
			    // but has not authenticated your app
			} else {
			    // the user isn't logged in to Facebook.
			    FB.login(function(response) {});
			}
		});
		
		
	}
/*
想要在使用者進入網頁就把基本資料帶進去表單內的話 , 
必須等到網頁載入結束後再判斷,否則導致 FB is not defined 情況發生.
*/
window.onload = function(){
	FB.getLoginStatus(function(response) {
	  if (response.status === 'connected') {	    
	    FB.api('/me?fields=name,email', function(response) {
	       //console.log(response);
	       document.getElementById("user_name").value = response.name;
	       document.getElementById("user_email").value = response.email;			       
		});
	    
	  }else if(response.status === 'not_authorized'){
	  	console.log('Not authorized');	    
	  }else{ console.log('Not logged in'); }
 	});
}
</script>

<br><br>
<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false"  onlogin="hello" data-auto-logout-link="true"></div>
<br><br>
<button id="fb_logout" onclick="logout()" >facebook logout</button>
<br><br>
<button id="fb_login" onclick="login()" >facebook login</button>
<br><br>
<button id="get_user_picture" onclick="get_user_picture()" > get user picture </button>
<br><br>

<button id="publish_actions" onclick="publish_actions()" >publich on your facebook </button>

<!-- 
see more
https://developers.facebook.com/docs/facebook-login/web/login-button 
https://developers.facebook.com/docs/reference/javascript/FB.login/v2.6
https://developers.facebook.com/docs/graph-api/reference
https://developers.facebook.com/docs/graph-api/reference/v2.6/post/
-->


</body>
</html>