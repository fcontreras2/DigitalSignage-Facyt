var user = angular.module("UserModule", ['angular-repeat-n', 'mgcrea.ngStrap','angular-img-cropper'])

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
    }])
    .config(function($datepickerProvider) {
        angular.extend($datepickerProvider.defaults, {
            dateFormat: 'dd/MM/yyyy',
            startWeek: 1
        })});

user.filter('range', function() {
    return function(input, init, total) {
        total = parseInt(total);

        for (var i=init; i<=total; i++) {
            input.push(i);
        }
        return input;
    };
});