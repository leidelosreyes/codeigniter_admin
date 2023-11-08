$(function() {
    //for toast (notifications)
    var toasttarget = document.getElementById('liveToast');
    var toast1 = new bootstrap.Toast(toasttarget , []);
    //example usage of toast
    $("#liveToastBtn").click(function() {
        //$("#toast_time").html("the time here");
        $("#toast_msg").html("the message here! i have a pretty long message for you now so read this as fast as you can or you will miss it.");
        toast1.show();
    });

    //Jquery confirm modals

    $("#jqm1").click(function() {
        $.alert({
            title: 'Alert alert!',
            content: 'This is a simple<i class="bi-c-circle"></i> alert. <br> with some <strong>HTML</strong> <em>contents</em>',
            icon: 'bi-info-circle',
            type: 'blue',
            animation: 'scale',
            closeAnimation: 'scale',
            buttons: {
                okay: {
                    text: 'Okay',
                    btnClass: 'btn-primary'
                }
            }
        });
    });

    $("#jqm2").click(function(){
        $.confirm({
            title: 'A secure action',
            content: 'Its smooth to do multiple confirms at a time. <br> Click confirm or cancel for another modal',
            icon: 'bi-question-circle',
            animation: 'scale',
            type: 'orange',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-primary',
                    action: function(){
                        $.confirm({
                            title: 'This maybe critical',
                            content: 'Critical actions can have multiple confirmations like this one.',
                            icon: 'bi-exclamation-circle',
                            animation: 'scale',
                            type: 'red',
                            closeAnimation: 'zoom',
                            buttons: {
                                confirm: {
                                    text: 'Yes, sure!',
                                    btnClass: 'btn-warning',
                                    action: function(){
                                        $.alert('A very critical action <strong>triggered!</strong>');
                                    }
                                },
                                cancel: function(){
                                    $.alert('you clicked on <strong>cancel</strong>');
                                }
                            }
                        });
                    }
                },
                cancel: function(){
                    $.alert('you clicked on <strong>cancel</strong>');
                },
                moreButtons: {
                    text: 'something else',
                    action: function(){
                        $.alert('you clicked on <strong>something else</strong>');
                    }
                },
            }
        });
    });

    $("#jqm3").click(function(){
        $.alert({
            title: 'Error',
            icon: 'bi-exclamation-circle',
            type: 'orange',
            content: 'Something went wrong, please retry again after sometime.' +
                '<hr>' +
                'More types: red, green, orange, blue, purple, dark',
        });
    });

    $("#jqm4").click(function(){
        $.confirm({
            title: 'Auto close',
            icon: 'bi-exclamation-circle',
            content: 'Some actions maybe critical, prevent it with the Auto close. This dialog will automatically trigger cancel after the timer runs out.',
            autoClose: 'cancelAction|10000',
            type: 'red',
            escapeKey: 'cancelAction',
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    text: 'Delete ben\'s account',
                    action: function(){
                        $.alert('You deleted Ben\'s account!');
                    }
                },
                cancelAction: {
                    text: 'Cancel',
                    action: function(){
                        $.alert('Ben just got saved!');
                    }
                }
            }
        });
    });

    $("#jqm5").click(function(){
        $.dialog({
            title: 'Text content!',
            content: 'Simple modal!',
            type: 'blue'
        });
    });
});