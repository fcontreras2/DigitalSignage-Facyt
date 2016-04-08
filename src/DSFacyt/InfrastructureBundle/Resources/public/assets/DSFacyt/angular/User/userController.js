user.controller('UserController', ['$scope','Upload','$filter', 'userService','$modal',
    function ($scope, Upload, $filter,userService, $modal) {

        $scope.data = data;
        $scope.profile_data_text = true;
        $scope.editData = {};
        $scope.change_password = false;
        $scope.icon_loading = false;
        var cropImageModal = $modal({scope: $scope, template: 'modal-uploadImage.tpl', show: false});

        userService.resetValues($scope.data, $scope.editData);
        userService.resetCropper(cropImageModal, $scope, $modal);


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
        };

        $scope.hideModal = function() {
            userService.resetCropper(cropImageModal, $scope, $modal);
        }

        $scope.uploadFile = function() {
            
            $scope.icon_loading = true;
            cropImageModal.$promise.then(cropImageModal.hide);
            
            Upload.upload({
                url: Routing.generate('ds_facyt_infrastructure_user_upload_image'),
                data: {file: $scope.file}
            }).then(function (resp) {
                
            }, function (resp) {

            }, function (evt) {

            });           

        }
    }]);