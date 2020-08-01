<?php
	session_start();
	if(isset($_SESSION['ncs']) and $_SESSION['ncs']==true)
	{
		$id=$_SESSION['id'];
		$name=$_SESSION['name'];
		$phone=$_SESSION['phone'];
		$email=$_SESSION['email'];
		$curyear=$_SESSION['year'];
		if($_SESSION['role']!='Admin')
		{
			$batch=$_SESSION['batch'];
			$branch=$_SESSION['branch'];
			$fac=$_SESSION['fac'];
		}
		
	}
	else
		header('location: ../login.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="../favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NCS - Add Students</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script src="js/jquery.min.js"></script>  
    
	</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span style="padding-right:20px;">NCS</span><?php echo '('.$curyear.'-'.($curyear+1).')';?></a>
				<ul class="nav navbar-top-links navbar-right">
					
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic" align="center">
				<img src="../upload/<?php echo $id ?>.jpg" style="object-fit: cover;" class="img-responsive" alt="" onerror=this.src="../img/avatar.jpg">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo $name?></div>
				<small><?php echo $id?></small>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		
		<ul class="nav menu">
			<li><a href="index.php"><em class="fa fa-address-card">&nbsp;</em> Profile</a></li>
			<li><a href="meetings.php"><em class="fa fa-calendar">&nbsp;</em> Meetings</a></li>
			<li><a href="student_details.php"><em class="fa fa-search">&nbsp;</em> Student Details</a></li>
			<li class="active"><a href="addstudent.php"><em class="fa fa-user-plus">&nbsp;</em> Add Students</a></li>
			<?php if($_SESSION['role']!='Admin') echo '<li><a href="attendance.php"><em class="fa fa-bars">&nbsp;</em> Attendance</a></li>';?>
			<li><a href="update.php"><em class="fa fa-edit">&nbsp;</em> Update Profile</a></li>
			<li><a href="event.php"><em class="fa fa-trophy">&nbsp;</em> Events</a></li>
		</ul>
		<div class="divider"></div>
		<ul class="nav menu">	
			<li><a href="../login.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Add Student</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Add New Counselling Student</h1>
			</div>
		</div><!--/.row-->
		<!--/.row-->
		<div class="row">
			
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="container-fluid">
					    
						<div class="row">
					      <!-- left column -->
					      
					      
					      <!-- edit form column -->
					      <div class="col-md-12 personal-info">
					        <div id="error" style="display: none;" class="alert alert-info alert-dismissable">
					          <a class="panel-close close" data-dismiss="alert">×</a> 
					          
					        </div>
					        <h3 style="padding-bottom:30px;">Student info</h3>
					        
					        
					        
					        <?php 

					        	if($_SESSION['role']=='Admin')
					        	{
					        		echo '
	    <div class="row">

	        
	        <div class="col-lg-6 col-sm-6 col-md-6">
	            <div class="input-group">
	                <label class="input-group-btn">
	                    <span class="btn btn-info">
	                        Browse&hellip; <input type="file" value="" id="file" accept=".xlsx, .xls, .csv" style="display: none;">
	                    </span>
	                </label>
	                <input type="text" class="form-control" readonly>
	            </div>
	            <span class="help-block">
	                Upload the form here
	            </span>
	        </div>
	       	<div class="col-lg-6 col-sm-6 col-md-6">
	        	<a href="doc/studentadd.csv"><button class="btn btn-info" style="width: 100%;height:45px;">Download CSV format File</button></a>
	        	<span class="help-block">
	                Download the format file for uploading student data
	            </span>
	        </div>
	        
	    </div>
	   
	    <div class="row" >
	    	<div class="col-lg-12" align="center">
	    		<button class="btn btn-primary" id="test">Submit</button>
	    		<a href="doc/password.csv"><button class="btn btn-success" id="testpass">Download Password</button></a>
	    	</div>
	    </div>
	
									';
					        	} 
					        	else
					        	{
					        		echo '
	    <div class="row">

	        
	        <div class="col-lg-6 col-sm-6 col-md-6">
	            <div class="input-group">
	                <label class="input-group-btn">
	                    <span class="btn btn-info">
	                        Browse&hellip; <input type="file" value="" id="file" accept=".xlsx, .xls, .csv" style="display: none;">
	                    </span>
	                </label>
	                <input type="text" class="form-control" readonly>
	            </div>
	            <span class="help-block">
	                Upload the form here
	            </span>
	        </div>
	       	<div class="col-lg-6 col-sm-6 col-md-6">
	        	<a href="doc/studentaddstud.csv"><button class="btn btn-info" style="width: 100%;height:45px;">Download CSV format File</button></a>
	        	<span class="help-block">
	                Download the format file for uploading student data
	            </span>
	        </div>
	        
	    </div>
	   
	    <div class="row" >
	    	<div class="col-lg-12" align="center">
	    		<button class="btn btn-primary" id="test">Submit</button>
	    	</div>
	    </div>
	
									';
					        	}

					        ?>
					        <div id="display"></div>
							<div class="row"><div class="col-md-5 col-sm-5 col-xs-5 col-lg-5"><hr></div><div class="col-md-2 col-sm-2 col-xs-2 col-lg-2" align="center"><h3>OR</h3></div><div class="col-md-5 col-sm-5 col-xs-5 col-lg-5"><hr></div></div>					        
					        <div class="row">
					        	<center><h4>You can fill the form</h4></center>	
							</div>
					        		
					        <form class="form-horizontal" role="form">
					          <div class="form-group">
					            <label class="col-lg-1 control-label">Roll:</label>
					            <div class="col-lg-11">
					              <input class="form-control" id="roll" type="text" name="roll" value="" placeholder="student roll number">
					            </div>
					          </div>
					          <?php
					          	if($_SESSION['role']!='Admin')
					          		echo '<div class="form-group">
					            <label class="col-lg-1 control-label">Name:</label>
					            <div class="col-lg-11">
					              <input class="form-control" type="text" id="name" name="name" value="" placeholder="student name" >
					            </div>
					          </div>
					          <div class="form-group">
					            <label class="col-lg-1 control-label">Batch:</label>
					            <div class="col-lg-11">
					              <input class="form-control" type="text" id="batch" name="batch" value="" placeholder="student batch">
					            </div>
					          </div>
					          <div class="form-group">
					            <label class="col-lg-1 control-label">Phone:</label>
					            <div class="col-lg-11">
					              <input class="form-control" type="text" id="phone" name="phone" value="" placeholder="Student phone">
					            </div>
					          </div>
					          <div class="form-group">
					            <label class="col-lg-1 control-label">Email:</label>
					            <div class="col-lg-11">
					              <input class="form-control" type="text" id="email" name="email" value="" placeholder="someone@example.com">
					            </div>
					          </div>
					          <div class="form-group">
					            <label class="col-lg-1 control-label">Branch</label>
					            <div class="col-lg-11">
					              <input class="form-control" type="text" id="branch" name="branch" value="" placeholder="Your Branch">
					            </div>
					          </div>
					          ';
					          ?>
					          
					          <div class="form-group">
					            <div class="col-md-12" align="center">
					              <input type="submit" id="update_button" class="btn btn-primary" value="Add Student">
					              <span></span>
					              <input type="reset" class="btn btn-default" value="Cancel">
					            </div>
					          </div>
					        </form>
					      </div>
					  </div>
					</div>

				</div>
			</div>
		</div>
			<center><div class="container-fluid">
			<div class="row">
				<p class="tm-copyright-text">Copyright &copy; 2018 NIST Counseling Service | Maintained by <a rel="nofollow" href="http://nist.edu/" target="_blank">N.I.S.T.</a> | Designed by <span style="color: #C51162">N.C.S. Web Design Team</span></p>
			</div>
		</div>		
	  
	</center>

	</div>	<!--/.main-->
	  

	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
	<script>
	function preview_images() 
	{
	$('#image_preview').html('');
	 var total_file=document.getElementById("images").files.length;
	 for(var i=0;i<total_file;i++)
	 {
	  $('#image_preview').append("<div class='col-md-3'><img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
	 }
	}
	$('#update_button').click(function(event) {
			
			event.preventDefault();
			if(!($('#roll').val()=="" || $('#name').val()=="" || $('#batch').val()=="" || $('#phone').val()=="" || $('#email').val()=="" || $('#branch').val()==""))
			{
				var data=new FormData($('form')[0]);
			data.append('addstudent',true);
			data.append('id',<?php echo $id; ?>)
			$.ajax({
				type : 'POST',
				url : 'login.php',
				data : data,
				processData: false,
    			contentType: false,
				beforeSend: function(){
					$("#error").fadeOut();
					$("#update_button").val('sending ...');

				},
				success : function(response){
					if(response=="success"){
						$("#update_button").val('Saving ...');
						$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Student Added!!');
						$("#error").fadeIn(500,function(){
							
						});
						setTimeout(' window.location.href = "addstudent.php"; ',1000);
					} 
					else {
						$("#update_button").val('Add Student');
						$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+"Your request can't be processed now!! please try again later!!!!");
						$("#error").fadeIn(500, function(){
							
						});
					}
				}
			});
			
			}
			else
			{
				$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Fill all the details!!');
				$("#error").fadeIn(500, function(){
				
				});
			}
				return false;
		});
	// We can attach the `fileselect` event to all file inputs on the page
		  $(document).on('change', ':file', function() {
		    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		    input.trigger('fileselect', [numFiles, label]);
		  });

		 $(function() {

		  // We can attach the `fileselect` event to all file inputs on the page
		  $(document).on('change', ':file', function() {
		    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		    input.trigger('fileselect', [numFiles, label]);
		  });

		  // We can watch for our custom `fileselect` event like this
		  $(document).ready( function() {
		      $(':file').on('fileselect', function(event, numFiles, label) {
		      		
		          var input = $(this).parents('.input-group').find(':text'),
		              log = numFiles > 1 ? numFiles + ' files selected' : label;
		          if( input.length ) {
		              input.val(log);
		          } else {
		              if( log ) alert(log);
		          }

		      });
		  });
		  
		});
		$('#test').on('click',function(){
			var filedata=document.getElementById('file').files[0];
			var data=new FormData();
			data.append('file',filedata);
			data.append('addstudentfile',true);
			$.ajax({
					type : 'POST',
					url : 'login.php',
					data : data,
					processData: false,
	    			contentType: false,
					beforeSend: function(){

					},
					success : function(response){
						if(response=="success"){
							$("#update_button").val('Saving ...');
						$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Student Added!!');
						$("#error").fadeIn(500,function(){
							
						});
						setTimeout(' window.location.href = "addstudent.php"; ',1000);
						} 
						else {
							$("#update_button").val('Add Student');
							$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+"Your request can't be processed now!! please try again later!!!!"+response);
							$("#error").fadeIn(500, function(){
								
							});
						}
					}
				});
				
		});
	</script>
</body>
</html>
