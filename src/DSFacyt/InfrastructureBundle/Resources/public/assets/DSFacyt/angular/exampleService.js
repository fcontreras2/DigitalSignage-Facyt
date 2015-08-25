exampleModule.service('exampleService', function(){

    this.addNumber = function( number, array) {
        $.each(array, function (index, value) {
            value.name = value.name.concat (number);
        });
    }

    this.quiteValues = function ( number, array) {
        
        $.each(array, function (index, value){

            var string_value = String(value.name);
            value.name = String(value.name).substr(0, string_value.length - number);
        });
    }
});