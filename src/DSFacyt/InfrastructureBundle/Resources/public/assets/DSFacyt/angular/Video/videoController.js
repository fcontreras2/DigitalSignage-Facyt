video.controller('VideoController', ['$scope','$filter', 'videoService', '$modal', '$alert', '$timeout',
    function ($scope, $filter,videoService, $modal, $alert, $timeout) {

        $scope.publish = data.videos;
        $scope.pagination = data.pagination;
        $scope.selectedDate = {date: new Date("2012-09-01")};
        $scope.indexEditVideo = null;
        $scope.filter = null;
        $scope.order = null;
        $scope.status = -1;
        $scope.alert_message = false;
        var initializing = false;

        var alertEmptyData = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo videoo',
                placement: 'top',
                type: 'info',
                show: false,
                container:'#box-alert'
            });

        if (checkEmptyData(alertEmptyData)) {
            alertEmptyData.$promise.then(function() {alertEmptyData.show();});            
        }

        function checkEmptyData(alertEmptyData) {
            if (!$scope.publish.length ) {
                $scope.publish= [];            
                return true;
            }
            return false;
        }

        var myOtherModal = $modal({scope: $scope, template: 'modal-previewVideo.tpl', show: false});

        $scope.modalPreviewVideo = function(video_id) {
            $scope.indexPreview = video_id;
            myOtherModal.$promise.then(myOtherModal.show);
        }

        var alertDeleteSuccess = $alert(
            {
                title: "Publicación Eliminada",
                content: 'Se ha eliminado correctamente el videoo',
                placement: 'top',
                type: 'success',
                show: false,
                container:'#box-alert'                
            });

        
        $scope.deleteVideo = function(indexData) {
            var url = Routing.generate('ds_facyt_infrastructure_user_video_delete');
            var data = angular.toJson({"video_id": $scope.publish[indexData].id}); 
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.publish.splice(indexData, 1);
                    myOtherModal.$promise.then(myOtherModal.hide);
                    if (checkEmptyData())
                        alertEmptyData.$promise.then(function() {alertEmptyData.show();});
                    else
                        alertDeleteSuccess.$promise.then(function() {alertDeleteSuccess.show();});
                }                
            });            
        }

        $scope.generatePagination = function(pagination) {
            $scope.urlPagination = Routing.generate('ds_facyt_infrastructure_user_video_homepage',{ page : pagination});
        };

        $scope.getUrlEdit = function(video_id) {
            $scope.urlEdit = Routing.generate('ds_facyt_infrastructure_user_video_edit',{
                'videoId' : video_id
            });
        };

        $scope.$watch('status_select', function() {
            if (initializing) {
                $scope.alert_message = 1;                
                $scope.color_status = videoService.setColorStatus($scope.status_select);
                var status = $scope.status_select >= 0 ? $scope.status_select : null;

                var data = angular.toJson({
                    'status': status,
                    'type': 'Video',
                    'page': 0,
                    'filter': $scope.filter,
                    'order' : $scope.order
                });

                videoService.ajaxGetPublish(data, $scope);
                $timeout(function() { $scope.alert_message = false;}, 1500);            
            }
        });

        $scope.setFiler = function(filter) 
        {
            $scope.alert_message = 1;
            if (filter == $scope.filter)
                $scope.order = videoService.setOrder($scope.order);
            else{
                $scope.filter = filter;
                $scope.order = 'DESC';
            }

            var data = angular.toJson({
                'status': $scope.status_select,
                'type': 'Video',
                'page': 0,
                'filter': $scope.filter,
                'order' : $scope.order
            });

            videoService.ajaxGetPublish(data, $scope);
            $timeout(function() { $scope.alert_message = false;}, 1500);
        }

        $scope.generatePagination = function (page)
        {
            $scope.alert_message = 1;

            var data = angular.toJson({
                'status': $scope.status_select,
                'type' : 'Video',
                'page': page,
                'filter': $scope.filter,
                'order' : $scope.order
            })

            videoService.ajaxGetPublish(data, $scope);

            console.log($scope.pagination);
            
            $timeout( function(){
                $scope.alert_message = false;
            },1500);
        };

        $timeout(function() { initializing = true; $scope.$apply();});

    }]);