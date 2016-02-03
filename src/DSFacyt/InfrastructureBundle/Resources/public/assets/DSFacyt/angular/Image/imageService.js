image.service('imageService', function(){

    this.checkStatus = function(data) {
        $.each(data, function (index, value) {
            switch (value.status) {
                case 0:
                value.classStatus = 'fa fa-circle';
                break;
                case 1:
                value.classStatus = 'fa fa-circle-o';
                break;
                case 1:
                value.classStatus = 'fa fa-circle-thin';
                break;

            }
        });
    }
});