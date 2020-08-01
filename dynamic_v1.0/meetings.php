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
	<title>NCS - Meetings</title>
	<script src="js/jquery.min.js"></script>  
    <script src="js/jquery.dataTables.min.js"></script>  
    <script src="js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />

	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
	<!--<script src='fullcalendar/lib/jquery.min.js'></script>-->
	<script src='fullcalendar/lib/moment.min.js'></script>
	<script src='fullcalendar/fullcalendar.js'></script>
	
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<script src="js/bootstrap-datetimepicker.min.js"></script>

	<script>

	
      $(document).ready(function() {


    $("#myModal").modal("hide");
    $("#close").on('click',function()
    {
    	$("#myModal").modal("hide");
    });
      var table=$('#student_guide_data').DataTable();

		  $('#student_guide_data').on('click', 'tbody tr', function() {
		  	var data=table.row(this).data();
		  	var dataForm=new FormData();
		  	dataForm.append('roll',data[0]);
		  	dataForm.append('date',data[3]);
		  	dataForm.append('getstudentattendance',true);
		  	$.ajax({
				type : 'POST',
				url : 'login.php',
				data : dataForm,
				processData: false,
    			contentType: false,
				success : function(response){
					console.log(response);
					if(response=="")
					{
						$('#modal-header').html('<h4 class="modal-title">Student Guide: '+data[1]+'</h4><h5 class="modal-title text-right">Date : '+data[3]+'</h5>');
						$('#modal-body').html("No Meeting Found!!");
					}	
					else
					{
						$('#modal-header').html('<h4 class="modal-title">Student Guide: '+data[1]+'</h4><h5 class="modal-title text-right">Date : '+data[3]+'</h5>');
						$('#modal-body').html(response);
					}				
				}
			});
			$("#myModal").modal("show");
			});
      	
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();


  var calendar = $('#calendar').fullCalendar({
   editable: true,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },


   events: "getevent.php",


   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
    <?php 
    	if($_SESSION['role']=='Admin')
    	{
    		echo 'eventClick: function(event) {
	var decision = confirm("Do you really want to do that?"); 
	if (decision) {
	$.ajax({
		type: "POST",
		url: "delete_event.php",
		data: "&id=" + event.id,
		
		success: function(json) {			 
			if(json=="success"){
				$("#calendar").fullCalendar("removeEvents", event.id);
			  	alert("Updated Successfully");
			}
			else
			{
				alert("Unable to delete event!!");
			}  
		}
	});
	}
  	},';
    	}
    ?>
   selectable: true,
   selectHelper: true,

   editable: false
 });
			 $("#datetime").datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    autoclose: true,
    todayBtn:true
});
  
 });

    </script>
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
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
			<li class="active"><a href="meetings.php"><em class="fa fa-calendar">&nbsp;</em> Meetings</a></li>
			<li><a href="student_details.php"><em class="fa fa-search">&nbsp;</em> Student Details</a></li>
			<li><a href="addstudent.php"><em class="fa fa-user-plus">&nbsp;</em> Add Students</a></li>
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
				<li class="active">Meetings</li>
			</ol>
		</div><!--/.row-->
		
		

		<div class="row">
			<div class="col-md-7">
				<div class="panel panel-default">
					<div class="panel-heading">
						Calendar
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
					</div>
					<div class="panel-body">
						<div id="calendar"></div>
					</div>
			<!--/.col-->
				</div>
			</div>
				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-heading">
							Add Meeting
						</div>
						<div class="container-fluid">
						    <div class="row">
						      <!-- left column -->
						      
						      
						      <!-- edit form column -->
						      <div class="col-md-12 personal-info">
						        <div id="error" style="display: none;" class="alert alert-info alert-dismissable">
						          <a class="panel-close close" data-dismiss="alert">×</a> 
						          <i class="fa fa-coffee"></i>
						          This is an <strong>.alert</strong>. Use this to show important messages to the user.
						        </div>
						        <h3>Meeting details</h3>
						        
						        <form class="form-horizontal" role="form">
						        	
						          <div class="form-group">
						            <label class="col-lg-3 control-label">Title:</label>
						            <div class="col-lg-8">
						              <input class="form-control" type="text" id="title" name="title" value="" placeholder="title">
						            </div>
						          </div>
						           <div class="form-group">
						           		<label class="col-lg-3 control-label">Date:</label>
						                <div class="col-lg-8" >
						                   <input type="text" class="form-control" name="date" id="datetime" placeholder="click here">
						                    
						                </div>
						            </div>
						          
						          <div class="form-group">
						            <label class="col-lg-3 control-label">Place:</label>
						            <div class="col-lg-8">
						              <input class="form-control" name="place" type="text" id="place"  value="" placeholder="meeting place">
						            </div>
						          </div>
						          
						          <div class="form-group">
						            <label class="col-lg-3 control-label">Purpose:</label>
						            <div class="col-lg-8">
						              <textarea class="form-control" rows=3 value="" id="about" placeholder="meeting purpose"></textarea>
						            </div>
						          </div>
						          
						          <div class="form-group">
						            <label class="col-md-3 control-label"></label>
						            <div class="col-md-8">
						              <input type="submit" id="update_button" class="btn btn-primary" value="Add Meeting" >
						              <span></span>
						              <input type="reset" class="btn btn-default" value="Reset">
						            </div>
						          </div>
						        </form>
						      </div>
						  </div>
						</div>

					</div>
				</div>
			
		
	</div>
	<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="padding:20px 20px 20px 20px;">
					
						<div class="container-fluid">
						<div class="table-responsive">
							<table id="student_guide_data" class="table table-striped table-bordered">
								<thead>
									<tr>
										<td>Roll No</td>
										<td>Student Guide</td>
										<td>Title</td>
										<td>Date</td>
										<td>Place</td>
										<td>Purpose</td>
									</tr>
								</thead>
								<?php
									require_once($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/clsSearchTransaction.php");
									$clsSearchTransaction=new clsSearchTransaction();
									$result=$clsSearchTransaction->displayMeetingDetails();
									if($result==null)
									{
										
									}
									else
									{	
										while($row=pg_fetch_array($result))
										{
											echo '
												<tr>
													<td>'.$row["sdrollid"].'</td>
													<td>'.$row["sdname"].'</td>
													<td>'.$row["mititle"].'</td>
													<td>'.$row["midate"].'</td>
													<td>'.$row["miplace"].'</td>
													<td>'.$row["mipurpose"].'</td>
												</tr>
											';
										}
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModal" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		    	<div class="modal-content">
		        	<div class="modal-header" id="modal-header">
		          		
		        	</div>
		        	<div class="modal-body" id="modal-body">
		       			
		        	</div>
				<button id="close" class="btn btn-danger">x</button>
		      	</div>
		    </div>
		  </div>
		
		<center><div class="container-fluid">
			<div class="row">
				<p class="tm-copyright-text">Copyright &copy; 2018 NIST Counseling Service | Maintained by <a rel="nofollow" href="http://nist.edu/" target="_blank">N.I.S.T.</a> | Designed by <span style="color: #C51162">N.C.S. Web Design Team</span></p>
			</div>
		</div>		
	  
	</center><!--/.row-->
	</div>	<!--/.main-->
	  
	</div>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script type="text/javascript">
		$('#update_button').click(function(event) {
			
			event.preventDefault();
			if(!($('#title').val()==""|| $('#datetime').val()=="" || $('#place').val()=="" || $('#about').val()==""))
			{
				var data=new FormData($('form')[0]);
			data.append('meeting',true);
			data.append('about',$("#about").val());
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
					console.log(response);
					if(response=='success'){
						$("#update_button").val('Adding ...');
						$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Successfully Added Meeting!!');
						$("#error").fadeIn(500, function(){
						});
						setTimeout(' window.location.href = "meetings.php"; ',3000);
					} 
					else {
						$("#update_button").val('Add Meeting');
						$("#error").html('<a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i>'+response);
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
	</script>

	
</body>
</html>
