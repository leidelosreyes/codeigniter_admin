$(function() {
	// place your code
    //for sidebar
	//$( ".active" ).parent().parent().parent().addClass('show');
    //( ".active" ).parent().parent().parent().siblings().removeClass('collapsed');
    //$( ".active" ).parent().parent().parent().siblings().attr('aria-expanded' , 'true');
    //for tooltips
    $('[data-toggle="tooltip"]').tooltip({
        placement: 'auto'
    });

    $("a.sbnav").on("click", function(e) {
        localStorage.setItem('activeNav', $(e.target).attr('href'));
    });

    var activeNav = localStorage.getItem('activeNav');
    if(activeNav){
        $('a[href="' + activeNav + '"]').addClass('active');
        $('a[href="' + activeNav + '"]').parent().parent().parent().addClass('show');
        $('a[href="' + activeNav + '"]').parent().parent().parent().siblings().removeClass('collapsed');
        $('a[href="' + activeNav + '"]').parent().parent().parent().siblings().attr('aria-expanded' , 'true');
    } else {
        $('a[href="/dashboard"]').addClass('active');
        $('a[href="/dashboard"]').parent().parent().parent().addClass('show');
        $('a[href="/dashboard"]').parent().parent().parent().siblings().removeClass('collapsed');
        $('a[href="/dashboard"]').parent().parent().parent().siblings().attr('aria-expanded' , 'true');
    }
    localStorage.setItem('activeNav', ''); // reset active navigation.
    // check if user is still looged in or not. if not, redirect to login page.
    setInterval(function () {
        $.get("/logstatus", function(data, status){
            if(data.status == 0){
                //console.log("logged out");
                window.location.replace("/login");
            }
        });
        
      }, 600000); // 10 mins
    
});

//for reloading
function reloadPage(){
    var segment = window.location.href.split( '/' );
    var n_url = segment[3].replace('#','');
    localStorage.setItem('activeNav', "/" + n_url);
    window.location.replace("/" + n_url);
    //location.reload(true);
}

