var uploadvideo = angular.module("UploadVideoModule",[
    "ngSanitize",
    "com.2fdevs.videogular",
    "com.2fdevs.videogular.plugins.controls",
    "com.2fdevs.videogular.plugins.overlayplay",
    "com.2fdevs.videogular.plugins.buffering",
    "com.2fdevs.videogular.plugins.poster"])
    .config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    })
    .config(['$httpProvider',function ($httpProvider) {
        $httpProvider.defaults.withCredentials = '';
        $httpProvider.defaults.useXDomain = false;
        $httpProvider.defaults.headers.common['X-Requested-With']= 'XMLHttpRequest';
        var httpStatusCodeInterceptorFactory = function ($q) {
            function onSuccess(response){
                if("success_condition"){
                    return response.data;
                }
                else{
                    //Show your global error dialog $q.reject(response.data);//Very important to reject the error } };
                    function onError(response){
                        //Show your global error dialog
                        $q.reject(response);
                        //Very important to reject the error
                    };
                    return function (promise) {
                        return promise.then(onSuccess,onError);
                    };
                };
                //Activate your interceptor
                $httpProvider.responseInterceptors.push(httpStatusCodeInterceptorFactory);
            }
        }
    }]);

uploadvideo.service('UploadVideoService', function(){   
    this.setColorStatus = function (status_select) {

        var response = 0;
        switch (parseInt(status_select)) {
            case 0:
                response = 'status-new';
                break;

            case 1:
                response = 'status-accepted';
                break;
            case 2:
                response = 'status-active';
                break;
            case 3:
                response = 'status-finish';
                break;
            case 4:
                response = 'status-canceled';
                break;
            default:
                response = null;
                break;
        }

        return response;
    }

});

uploadvideo.controller('UploadVideoController',['$scope','UploadVideoService','$sce', function($scope,UploadVideoService,$sce){
    $scope.data = data;
    $scope.color_status = UploadVideoService.setColorStatus($scope.data.status);
    $scope.$watch('data.status', function() {$scope.color_status = UploadVideoService.setColorStatus($scope.data.status);});
    
    var controller = {};
    controller.API = null;
    controller.videos = [];

    console.log($scope.data);
    //Se inicializa los videos actualmente
    controller.videos = [{src: $sce.trustAsResourceUrl('/uploads/videos/'+$scope.data.video_url), type: $scope.data.mime_type}];
    console.log(controller.videos);

    // Configuraciones iniciales
    controller.config = {
        preload: "none",
        autoHide: false,
        autoHideTime: 3000,
        autoPlay: true,
        sources: controller.videos[0],
        theme: {
            url: "http://digitalsignagefacyt.dev/bundles/dsfacytinfrastructure/assets/vendor/css/videogular.css",
        },
        plugins: {
            poster: "http://www.videogular.com/assets/images/videogular.png"
        }
    }

    // Iniciar automaticamente la reproducción de videos
    controller.onPlayerReady = function(API) {
        controller.API = API;        
    };
    controller.onCompleteVideo = function() { 
        controller.API.stop();
    }
}]);


uploadvideo.directive('validFile',function(){
  return {
    require:'ngModel',
    link:function(scope,el,attrs,ngModel){
      //change event is fired when file is selected
      el.bind('change',function(){
        scope.$apply(function(){
          ngModel.$setViewValue(el.val());
          ngModel.$render();
        });
      });
    }
  }
});

