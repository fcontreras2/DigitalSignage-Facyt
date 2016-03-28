user.controller('UserController', ['$scope','$filter', 'userService',
    function ($scope, $filter,userService) {

        $scope.data = data;
        $scope.profile_data_text = true;
        $scope.editData = {};
        $scope.change_password = false;

        userService.resetValues($scope.data, $scope.editData);


        $scope.editProfile = function() {
            $scope.profile_data_text = false;
        }

        $scope.cancelEditProfile = function () {
            userService.resetValues($scope.data, $scope.editData);
            $scope.profile_data_text = true;
        }

        $scope.cancelChangePassword = function () {
            $scope.change_password = false;
        }

        $scope.sendEditData = function() {
            var url = Routing.generate('ds_facyt_infrastructure_user_edit_profile');
            var data = angular.toJson($scope.editData);

            $.ajax({
                method: 'POST',
                data: data,
                url: url,
                success: function(data) {

                    userService.resetValues($scope.editData,$scope.data);
                    console.log('editData',$scope.editData);
                    console.log('data',$scope.data);
                    $scope.profile_data_text = true;
                }
            });
        }

        $scope.myImage='';
        $scope.myCroppedImage= data.profile_image;

        var handleFileSelect=function(evt) {
            var file=evt.currentTarget.files[0];
            var reader = new FileReader();
            reader.onload = function (evt) {
                $scope.$apply(function($scope){
                    $scope.myImage=evt.target.result;
                });
            };
            reader.readAsDataURL(file);
        };
        angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);
    }]);