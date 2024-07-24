;
(function(w, $) {
    var windowBox = $('.box'),
        windowBox2 = $('.box2'),
        mask = $('.mask');
    var host = '';
    // var host = "http://bottle.haoall.com";
    $(document).ready(function() {
        $.ajax({
          url: "getsysconfig/mob",
          type: "GET",
          dataType: "json",
      
          success: function(response) {
            $.each(response, function(index, value) {
                $("." + value.name).attr("href", value.sys_value);
                $("." + value.name + " .navLinkText").html(value.sys_desc); 
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
                    _stopBodyScroll();
                    queryResultBox.find('.playerName').text(info.username); //用户名
                    queryResultBox.find('.total_bet_amount').text(info.allbet); //累计投注
                    queryResultBox.find('.curMonthBetAmount').text(info.glvalue); //当月投注
                    queryResultBox.find('.curVipInfo').text(info.grade); //当前VIP等级
                    queryResultBox.find('.nextLv').text(info.nextvip); //下一VIP等级
                    queryResultBox.find('.need_bet_amount').text(info.nextupdatevipbet); //升下一级所需投注
                    windowBox2.addClass("fullpage");
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
    });



    function _stopBodyScroll(){
        $('body').css({
            overflow: 'hidden',
            height: $(window).height() + 'px'
        })
    }

    function _bodyScroll(){
        $('body').css({
            overflow: 'auto',
            height: 'auto'
        })
    }

    function closeDig(obj){
        var dig = $(obj).parents(".applyStep")
        dig.removeClass("fullpage");
        _bodyScroll();
        setTimeout(function(){
            mask.hide();
        },200)
    }

    w.closeDig = closeDig;
})(window, jQuery)