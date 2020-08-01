var app = angular.module('MyApp');
app.controller('DemoCtrl', function($scope,$http) {
		$scope.user={
			image:""
		};
		$scope.files="";
		var date = new Date().getFullYear();
        var d1=(date-1).toString().substr(0,4);
        var d2=(date-2).toString().substr(0,4);
        var d3=(date-3).toString().substr(0,4);
        var d4=(date-4).toString().substr(0,4);
        var d0=(date).toString().substr(0,4);
        $scope.years=[d4,d3,d2,d1,d0];
        $scope.branches=branches;
        $scope.fac=fac;

        $scope.user.submit = function($event){
        	$event.preventDefault();
        	var formData = new FormData();
        	for(d in $scope.user){
        		if(d!='submit' && d!='image')
        		{
        			formData.append(d,$scope.user[d]);
        		}

        	}
        	var file=document.getElementById('propic').files[0];
        	formData.append('photo',file);
        	var request=$http({
        		method:'POST',
        		url: '../Student/php/login.php',
        		data: formData,
        		transformRequest: angular.identity,
        		headers:{'Content-Type':undefined}
        	});
        	request.then(function(response){
        		$scope.responseMessage = response.data;
                if(response.data=="success")
                {
                    $scope.responseMessage = "Successfully Registered!!!";
					setTimeout(function() {
					  window.location.href = "../../login.php";
					}, 3000);

                }
        	},function(error){
				
        		$scope.responseMessage = error.data;
        	})
        }

        /*
        $scope.submit = function($event) {
		  // our function body
		  $event.preventDefault();


		  $scope.files = document.getElementById('propic').files[0].getAsText("");
		  var request = $http({
                method: "post",
                url: "http://localhost/NCS Website/login.php",
                data: {
                	id:$scope.id,
                	roll:$scope.roll,
                    email: $scope.user.email,
                    password: $scope.user.password,
                    photo:$scope.files
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            });
		  request.success(function (data) {
                $scope.responseMessage = $scope.files;
                
            });

		}*/

});
app.directive("compareTo", function() {
		return {
				require: "ngModel",
				scope: {
						otherModelValue: "=compareTo"
				},
				link: function(scope, element, attributes, ngModel) {

						ngModel.$validators.compareTo = function(modelValue) {
								return modelValue == scope.otherModelValue;
						};

						scope.$watch("otherModelValue", function() {
								ngModel.$validate();
						});
				}
		};
});

