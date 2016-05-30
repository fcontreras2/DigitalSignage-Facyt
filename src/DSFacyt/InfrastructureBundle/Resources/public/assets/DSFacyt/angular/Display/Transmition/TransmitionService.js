Transmition.service('TransmitionService', function(){   

    this.changeMedia = function(timeout, showImages, showVideos) {

        timeout(
            function() {
                showImages = false; 
                showVideos = true;
            }, 
            1000);                  
    };
    
});