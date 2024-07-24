<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Gbh012Seed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "item" => "home_link",
                "value" => "https://2124399.com",
                "title" => "官方首页",
                'created_at' => Time::now()

            ],
            [
                "item" => "regist_link",
                "value" => "http://089997.com/entrance/page/registermember",
                "title" => "注册会员链接",
                'created_at' => Time::now()
            ],
            [
                "item" => "about_link ",
                "value" => "http://089997.com/entrance/page/article?code=AT1",
                "title" => "关于我们",
                'created_at' => Time::now()
            ],
            [
                "item" => "customer_service_link",
                "value" => "https://sdoiuewa.cz5avlwg.com/chatwindow.aspx?siteId=60000733&planId=a435ce1e-ab1f-49cd-971a-9268e8712358",
                "title" => "在线客服",
                'created_at' => Time::now()
            ],
            [  
                "item" => "check_link",
                "value" => "https://9155832.com/",
                "title" => "线路检测",
                'created_at' => Time::now()

            ],
            [  
                "item" => "kefu_link",
                "value" => "https://gbh758.com",
                "title" => "客服自助中心",
                'created_at' => Time::now()

            ],
            [  
                "item" => "cgp_link",
                "value" => "https://cgpay.pw/",
                "title" => "ＣＧＰ钱包",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_browser_link",
                "value" => "http://ub222.net",
                "title" => "寰宇浏览器",
                'created_at' => Time::now()

            ],
            [  
                "item" => "divip_link",
                "value" => "https://2693853.com/",
                "title" => "顶级VIP会所",
                'created_at' => Time::now()

            ],
            [  
                "item" => "client_link",
                "value" => "http://089997.com",
                "title" => "客户端",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_399_link",
                "value" => "https://ydscn6wh.com/CustomBrowser/download.html?provider=rxj5t99e37",
                "title" => "399浏览器",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_app_link",
                "value" => "https://zjyyn.yegcohvu.com/api/c/s7268xf3",
                "title" => "下载APP",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_dl_html",
                "value" => "<p>代理优势<br/>金沙贵宾会VIP作为亚洲知名的在线博彩集团，提供最广范围并最具竞争力的产品。我们真诚为您打造最高档次合作<br/>平台，最好的代理加盟方案。八大加盟优势让您无法抗拒！<br/>1.高达50%的代理佣金，让你轻松月入百万。<br/>2.零风险，高回报，每月准时出佣。<br/>3.全年度优惠不断，满足各种类型玩家需求。<br/>4.提款快速、实力雄厚、资金有保障。<br/>5.营运多年，深受百万玩家信赖。<br/>6.拥有体育博彩与线上赌场执照，信誉保证。<br/>7.多年大力推广，品牌热度十足，代理可坐享广告品牌效应。<br/>8.数据信息详尽，可查阅下线投注记录。<br/>还等什么？马上加盟吧。注册加入，开始推广，赚取佣金，简单三步开始成就梦想之旅。<br/><br/>代理申流程<br/>1.请【<a href='http://411174.com:9900/entrance/page/registeragent' target='_blank' textvalue='点此代理注册'>点此代理注册</a>】在线提出申请，填写正确的各项资料，姓名、手机、邮箱务必真实有效，以便为您支付<br/>佣金。成功注册后3日内由专员与您联系开通，并提供您的代理账号及推广链接。<br/>2.成功注册代理帐号后，请及时联系下方我公司的女神代理进行代理商身份核实，需提供具体代理推广方案，进行代理商资格评估。<br/>3.以上审核通过后，即可享我公司代理专员索取代理推广网址（含推广代码）及代理端管理网址。<br/>4.开始推广、发展下线会员，下线会员发展状况，可登录代理管理后台查阅。<br/>5.达到退佣条件，可于指定佣金结算日期联系我公司代理专员结算代理佣金。<br/>6.金沙贵宾会代理邮箱：gbhdaili@gmail.com<br/></p>",
                "title" => "代理合作",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_register_link",
                "value" => "",
                "title" => "注册会员",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_offical_link",
                "value" => "https://2124399.com",
                "title" => "官方网址",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_deposit_center_link",
                "value" => "https://gouwu333.com",
                "title" => "充值中心",
                'created_at' => Time::now()

            ],
            [  
                "item" => "nav_vip_list",
                "value" => "https://3992371.com,https://3992372.com,https://3992373.com,https://3992374.com,https://3992375.com,https://3992376.com,https://3992377.com,https://3992378.com,https://3992379.com,https://3992401.com,",
                "title" => "会员登入线路",
                'created_at' => Time::now()

            ],
        ];
        // foreach loop to insert seed data
        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('gbh012')->insert($row);
        }
    }
}
