<?php
	session_start();
	$id=$_SESSION['lduserid'];
?>
<!DOCTYPE html>
<html lang="en" >

	<head>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>NCS Student Registration</title>
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
	  
	  <link rel='stylesheet prefetch' href='https://cdn.gitcdn.xyz/cdn/angular/bower-material/v1.0.0-rc3/angular-material.css'>
	      <link rel="stylesheet" href="css/style.css">

	</head>

	<body>
		

	  <div ng-init="user.id='<?php echo $id?>'" ng-controller="DemoCtrl" ng-cloak=""  class="md-inline-form" ng-app="MyApp" layout="column" layout-sm="row" layout-align="start center" layout-align-sm="start start" layout-fill>
			<md-content id="SignupContent" class="md-whiteframe-10dp" style="width: 100%;" flex-sm>
					<md-toolbar flex id="materialToolbar" style="background-color: #263238">
							<div class="md-toolbar-tools"> <span flex=""></span> <span class="md-headline" align="center">NCS Student Guide Profile</span> <span flex=""></span> </div>
					</md-toolbar>
					<div layout-padding="">
							<div></div>
							<form name="userForm" method="POST" ng-submit="user.submit($event)" enctype="multipart/form-data">
									<input type="hidden" name="action" value="signup" />
									
									<div layout="row" layout-sm="column">
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.7);">Profile Picture</label>

													<!--<center>-->
														<img src="images/profile/none.png" id="setpic"/>
														<input style="color: #000;" ng-model="user.image" id="propic" type="file" name="photo" onchange="document.getElementById('setpic').src = window.URL.createObjectURL(this.files[0]);" accept="image/*" placeholder="" >
													<!--</center>-->'
											</md-input-container>
											<md-input-container flex-gt-sm="">
													<div layout="row" layout-sm="column">
															<md-input-container flex-gt-sm="">
																	<label style="color:rgba(0,0,0,0.7);">Student Id</label>
																	<input style="color: #000;" id="stud-id" ng-model="user.id" name="id" type="text" placeholder="<?php echo $id?>" readonly="readonly">
															</md-input-container>
													<!--		<md-input-container flex-gt-sm="">
																	<label style="color:rgba(0,0,0,0.7);">Roll Number</label>
																	<input id="stud-roll" ng-model="user.roll_no" name="roll_number" type="number" placeholder="<?php echo $roll?>" readonly="readonly">
															</md-input-container> -->
															
													</div>
													<div layout="row" layout-sm="column">
													<md-input-container flex-gt-sm="">	
													<label style="color:rgba(0,0,0,0.7);">Name</label>
													<input style="color: #000;" ng-model="user.name" name="name" required type="text" ng-pattern="/^[a-zA-Z'. -]+$/" placeholder="Your Name">
													<div ng-if="userForm.name.$dirty" ng-messages="userForm.name.$error" role="alert">
													         
															<div ng-message="required" class="my-message">Name is Required.</div>
															<div ng-message="pattern" class="my-message">Enter correct Name.</div>
													
													</div>
													</md-input-container>
													
													</div >
													<div layout="row" layout-sm="column">
													<md-input-container flex-gt-sm="">	
													
													<label style="color:rgba(0,0,0,0.7);">Email</label>
													<input style="color: #000;" style="width:100%;" required type="email" name="email" class="external" ng-model="user.email" ng-pattern="/^[_a-z0-9-+]+(\.[_a-z0-9-+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" placeholder="someone@example.com" />
													<div ng-if="userForm.email.$dirty" ng-messages="userForm.email.$error" role="alert">
															<div ng-message="required" class="my-message">Email Address is Required.</div>
															<div ng-message="pattern" class="my-message">Enter Correct Email Address. </div>
															<div ng-message="email" class="my-message">Enter Correct Email Address. </div> 
													</div>
													</md-input-container>
													</div>
											</md-input-container>
					
						
									</div>
									<div layout="row" layout-sm="column">
											
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.8);">Faculty Guide</label>
													<select ng-model="user.fac" required name="fac" ng-options="x.id as x.name for x in fac" placeholder="no select" style="width: 100%;"></select>
													<div ng-if="userForm.fac.$dirty" ng-messages="userForm.fac.$error" role="alert">
															<div ng-message="required" class="my-message">Faculty is Required.</div>
													</div>
											</md-input-container>
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.7);">Batch</label>
													<select ng-model="user.batch" required name="batch" ng-options="x for x in years" placeholder="no select" style="width: 100%;"></select>
													<div ng-if="userForm.batch.$dirty" ng-messages="userForm.batch.$error" role="alert">
															<div ng-message="required" class="my-message">Batch is Required.</div>
													</div>
											</md-input-container>
									</div>

									<div layout="row" layout-sm="column">
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.7);">Mobile Number</label>
													<input required type="text" name="mobile" ng-model="user.mobile" ng-pattern="/^(?:\d{10}|\w+@\w+\.\w{2,3})$/" placeholder="Your Mobile Number" />
													<div ng-if="userForm.mobile.$dirty" ng-messages="userForm.mobile.$error" role="alert">
															<div ng-message="required" class="my-message">Mobile Number is Required.</div>
															<div ng-message="pattern" class="my-message">Enter Correct Mobile Number. </div>
															<div ng-message="email" class="my-message">Enter Correct Mobile Number. </div>
													</div>
											</md-input-container>
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.7);">Branch</label>
													<select ng-model="user.branch" required name="branch" ng-options="x for x in branches" placeholder="none" style="width: 100%;"></select>
													<div ng-if="userForm.branch.$dirty" ng-messages="userForm.branch.$error" role="alert">
															<div ng-message="required" class="my-message">Branch is Required.</div>
													</div>
											</md-input-container>
									</div>
									
									<div layout="row" layout-sm="column">
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.7);">New Password</label>
													<input name="password" ng-model="user.password" type="password" minlength="8" maxlength="100" ng-pattern="/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/" required placeholder="********">
													<div ng-if="userForm.password.$dirty" ng-messages="userForm.password.$error" role="alert" multiple>
															<div ng-message="required">Password is Required.</div>
															<div ng-message="pattern">Password should contain at least one number, one lowercase and one uppercase character.</div>
															<div ng-message="minlength">Password should be greater than 8 letters.</div>
															<div ng-message="maxlength">Password Can't be more than 100 letters.</div>
													</div>
											</md-input-container>
											<md-input-container flex-gt-sm="">
													<label style="color:rgba(0,0,0,0.7);">Confirm Password</label>
													<input name="confmPassword" ng-model="user.confmPassword" type="password" minlength="8" maxlength="100" ng-pattern="/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/" required compare-to="user.password" placeholder="********">
													<div ng-if="userForm.confmPassword.$dirty" ng-messages="userForm.confmPassword.$error" role="alert">
															<div ng-message="required">Confirm Password is Required.</div>
															<div ng-message="compareTo">Password Doesn't Match.</div>
													</div>
											</md-input-container>
									</div>
									<md-button class="md-raised md-primary" style="width:100%; margin: 0px 0px;" type="submit" ng-disabled="userForm.$invalid" name="submit">Submit</md-button>
									<span>{{responseMessage}}</span>
									
							</form>
					</div>
			</md-content>
	</div>
	  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-aria.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js'></script>
	<script src='https://cdn.gitcdn.xyz/cdn/angular/bower-material/v1.0.0-rc3/angular-material.js'></script>
	<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js'></script>

	  
	<script type="text/javascript">
		//document.getElementById("stud-id").placeholder="";
		//document.getElementById("stud-roll").placeholder="";
		
	    var branches=['CSE','ELE','EE','CE','ME','ECE','IE','IT'];
		var fac=[
			<?php 
				require($_SERVER['DOCUMENT_ROOT']."/dynamic_v1.0/class/dbconnect.php");
				$sQuery="SELECT cifid, cifname FROM public.ncscounsellorinfo order by cifname;";
				$rsltNCSCounsellor=pg_exec($connection,$sQuery) ;
				$lNumRows=0;
				$lNumRows = pg_numrows($rsltNCSCounsellor);
				if ($lNumRows == 0)
				{
					pg_close();
					return null;
				}
				//print_r($rsltNCSStudentDetails);
		        for($i=0;$i<$lNumRows-1;$i++)
				{
					$row=pg_fetch_array($rsltNCSCounsellor,$i);
					echo '{id:'.$row['cifid'].',name:"'.$row['cifname'].'"},';
				}
				$row=pg_fetch_array($rsltNCSCounsellor,$i);
				echo '{id:'.$row['cifid'].',name:"'.$row['cifname'].'"}';
			?>
		];	
	</script>
	    <script  src="js/index.js"></script>




	</body>

</html>
