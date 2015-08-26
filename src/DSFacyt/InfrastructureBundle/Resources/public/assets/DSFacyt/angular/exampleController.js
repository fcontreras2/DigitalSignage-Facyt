exampleModule.controller('ExampleController', ['$scope','$filter', 'exampleService', '$modal' ,
  function ($scope, $filter,exampleService, $modal) {
	   
	$scope.newContact = { name: null , last_name: null };

  var orderBy = $filter('orderBy');

	$scope.array = 
    [
  	  {	name : 'Freddy',last_name : 'Contreras' , age: '12'},
      {	name : 'Samuel',last_name : 'Chirinos'  , age: '14'},
      {	name : 'luisana',last_name : 'Lizarazo'  , age: '133'},
      {	name : 'Amarantha',	last_name : 'Rios' , age: '1'}
  	];

    $scope.order = function(predicate, reverse) {
      $scope.array = orderBy($scope.array, predicate, reverse);
    };

    //Ordernar de manera automatica
    $scope.order('name',false);


    $scope.addNumber =  function(number) {
    	exampleService.addNumber(number, $scope.array);
    };

  	$scope.addContact = function() {
  		$scope.array.push($scope.newContact);
  		$scope.newContact = { name: null , last_name: null};
  	};

  	$scope.quiteValue = function (number) {
  		exampleService.quiteValues(number, $scope.array);
  	};

    var myOtherModal = $modal({scope: $scope, template: 'modal-example.tpl', show: false});

    $scope.showModal = function() {
          myOtherModal.$promise.then(myOtherModal.show);
    };

}]);