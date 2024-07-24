<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Gbhvip399Seed extends Seeder
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
                "item" => "dcenter_link",
                "value" => "https://3992369.com:9900/infe/mcenter/paybitcoin/#/deposit/payfast",
                "title" => "快速充值",
                'created_at' => Time::now()
            ],
            [
                "item" => "kefu_link",
                "value" => "https://gbh758.com",
                "title" => "客服自助中心",
                'created_at' => Time::now()
            ],
            [
                "item" => "customer_service_link",
                "value" => "https://sdoiuewa.cz5avlwg.com/chatwindow.aspx?siteId=60000733&planId=a435ce1e-ab1f-49cd-971a-9268e8712358",
                "title" => "在线客服",
                'created_at' => Time::now()
            ],
        ];
        // foreach loop to insert seed data
        foreach($data as $row)
        {
            // insert data to table
            $this->db->table('gbhvip399')->insert($row);
        }
    }
}
