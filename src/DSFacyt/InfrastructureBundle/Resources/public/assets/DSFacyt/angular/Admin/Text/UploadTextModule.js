var uploadText = angular.module("UploadTextModule", [])
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