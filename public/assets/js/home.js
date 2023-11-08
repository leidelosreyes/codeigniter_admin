$(function() {
    // for onload events
    $("#claim_bonus").submit(function (event) {
        event.preventDefault();
        
        $.post("/b_api/claim_bonus",
            $("#claim_bonus").serialize()
        ,
        function(data, status){
            if(data.status == 0)
            {
                $.alert({
                    title: 'Error',
                    icon: 'bi-exclamation-circle',
                    type: 'red',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    content: data.validation,
                });
            } else {
                $.alert({
                    title: 'Congratulations!',
                    content: data.validation,
                    icon: 'bi-info-circle',
                    type: 'blue',
                    animation: 'scale',
                    closeAnimation: 'scale',
                });
            }
            
        });

        
    });
    
});