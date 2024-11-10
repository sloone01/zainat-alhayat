$(document).ready(function(){

    var select  = '#problemChange';

    $(select).change(function(event){
        event.preventDefault();

        var id = this.value
        window.location.href = id ; // Redirect to the new URL
        
    });

    

});
