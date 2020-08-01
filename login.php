<?php
	session_start();
	if(isset($_SESSION))
		session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NCS - Login</title>
	<!-- metatags-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-java script"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
	function hideURLbar(){ window.scrollTo(0,1); }</script>
	<!-- Meta tag Keywords -->
	<link href="css/login_style.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="dynamic_v1.0/css/font-awesome.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<link rel="shortcut icon" href="favicon.ico">
	<style type="text/css">
		#error{

			background-color: rgba(230,50,50,0.8);
			display: none;
			position: fixed;
			width: 46.5%;
			  
			  min-width: 250px !important;
			  min-height: 10%;
			  height: 50px;
			  left: 40%;
			  right: 40%;
			  bottom: 5%;
			  padding: 10px;
			  box-sizing: border-box;
			  margin-left: -12.5%;
			  margin-top: -5.2%;
			  border-radius: 6px;
			  text-align: center;
			  color: #fff;
			  font-family: Arial, Helvetica, sans-serif;
			  font-size: 14px;  
			  @media all and (max-width: 1300px){
			    .message{
			      font-size: 14px !important;
			    }
			  }
			.message{
		    padding: 0px;
		    color: white;
		    font-size: 14px;

		    line-height: 20px;
		    text-align: justify;

		  }	
		}
		button{
			background-color: red;
			color: white;
			border:none;	
		}

	</style>
</head>
<body>
	<div class="w3l-signin4" style="position: fixed;">
		
		<form action="#" method="post" id="login-form">
			<h3>NCS Login</h3>
			<input type="text" name="name" id="name" placeholder="user id" required=""/>
			<input type="password" name="password" id="pass" placeholder="password" required=""/>
			<input type="submit" class="btn" name="button" id="submit" value="Sign In"/ style="color: black;">
			<input class="btn" value="Back"/ style="color: black;" onclick="goBack()">
		</form>
	</div>
	<div id="error">
		
	</div>
	<script>
		function goBack() {
		    window.location.href = "index.html";
		}
		
		$('#submit').click(function(event) {
			
			
			if($('#name').val()!="" && $('#pass').val()!="")
			{
				event.preventDefault();
				var data = $("#login-form").serialize()+"&"+$.param({login:true});
				$.ajax({
					type : 'POST',
					url : 'dynamic_v1.0/login.php',
					data : data,
					beforeSend: function(){
						$("#error").fadeOut();
						$("#submit").val('sending ...');
					},
					success : function(response){
						if(response=="admin" || response=="studentreg"){
							$("#submit").val('Signing In ...');
							setTimeout(' window.location.href = "dynamic_v1.0/index.php"; ',1000);
						} 
						else if(response=="studentnotreg"){
							$("#submit").val('Signing In ...');
							setTimeout(' window.location.href = "dynamic_v1.0/Student/"; ',1000);
						} 
						else {
							$("#submit").val('Sign In');
							$("#error").fadeIn(500, function(){
								$("#error").html('<div class="alert alert-danger"><em class="fa fa-exclamation-triangle" style="padding-right:10px;"></em>'+response+' !</div>');
								$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span>   Sign In');
							});

							$("#error").delay(5000).fadeOut();
						}
					}
				});
				return false;
			}
			else
			{
				$("#error").fadeIn(500, function(){
				$("#error").html('<div class="alert alert-danger"><em class="fa fa-exclamation-triangle" style="padding-right:10px;"></em>'+'Please enter ID and Password!!'+' !</div>');
				$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span>   Sign In');
						});

				$("#error").delay(5000).fadeOut();
			}
		});

	</script>
</body>
</html>