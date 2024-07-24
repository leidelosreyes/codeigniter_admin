;
(function(w, $) {
    var windowBox = $('.box'),
        windowBox2 = $('.box2'),
        mask = $('.mask'),
        host = "";    //https://r88vip.com/
        // var host = "http://bottle.haoall.com";

    
    // $('.btn_chaxun').click(function () {
    //     mask.show();
    //     windowBox2.fadeIn();
    // })



    $(document).ready(function() {
        $.ajax({
          url: "getsysconfig/nav",
          type: "GET",
          dataType: "json",
      
          success: function(response) {
           
            $.each(response, function(index, value) {
                var nav_name = $( '<a>', {
                    href:value.sys_value,
                    html:value.sys_desc,
                    target:"_blank",
                    class:'wow lightSpeedIn animated',
                    style: 'visibility: visible; animation-delay: 0.1s; animation-name: lightSpeedIn;',
                    "data-wow-delay":".1s"
                } );
                nav_name.appendTo( '.navLink' );
            });
          },
          error: function(error) {
            console.log(error);
          },
        });
      });
     

    $('#queryButton').click(function() {
        var username = $('#username').val();
        if(username == '') {
            layer.alert('会员帐号不能为空!', {
                title: "提示",
                icon: 5
            });
            return false;
        }
  
        $.ajax({
	   // url: host + '/service?action=ZRVIPSearch&terminal_id=5&username=' + username,
            url: '/show_vip',
            type: 'post',
            data: {username: username},
            success: function(data) {
                if(data.status < 1){
                    mask.hide();
	                layer.alert('没有查询到您的帐号信息！', { title:"错误提示",icon: 2,shade: 0.7,move: false});
                    
                }
                else{
                    var info = data.data;
                    var queryResultBox = $('#queryResultInfo');
                          mask.show();
                          windowBox2.fadeIn();
                         $('#user-info').show();
                          queryResultBox.find('.playerName').text(info.username); //用户名
                          queryResultBox.find('.total_bet_amount').text(info.allbet); //累计投注
                          queryResultBox.find('.curMonthBetAmount').text(info.glvalue); //当月投注
                          queryResultBox.find('.curVipInfo').text(info.grade); //当前VIP等级
                          queryResultBox.find('.nextLv').text(info.nextvip); //下一VIP等级
                          queryResultBox.find('.need_bet_amount').text(info.nextupdatevipbet); //升下一级所需投注
                }
              
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    $('.closeBox').click(function() {
        mask.fadeOut();
        windowBox.fadeOut();
        windowBox2.fadeOut();
    });

    

})(window, jQuery)
