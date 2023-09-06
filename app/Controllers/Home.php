<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        //return view('welcome_message');
        
        
        return  view('website_global/header')
            .view('website_home')
            .view('website_global/footer');
        
    }

    public function about(): string
    {
        
        return  view('website_global/header')
            .view('website_about')
            .view('website_global/footer');
        
    }

    public function pricing(): string
    {
        
        $data = array(
            "header" => view('website_global/nav'), 
            "pricing" => array(
                [
                    "id" => 1,
                    "level" => "Personal",
                    "price" => "0",
                    "billed" => "forever",
                    "levelPlus" => "What's included",
                    "specialNote" => "Let's Go!",
                    "items" => array('Unlimited Viewers', 'Unlimited Teams', 'Books', 'Journals', 'Chart', 'Personal Pages', 
                    'Share Porfolio', 'Realtime Collaborative', '100 Upload Photo'),
                    "color" => "gray",
                ],
                [
                    "id" => 2,
                    "level" => "Pro",
                    "price" => "5",
                    "billed" => "month", 
                    "specialNote" => "Request free Trial",
                    "levelPlus" => "Included Hobby, plus :",
                    "items" => array('Access Right', '5GB Upload Photo', 'Calculation Real <b>Broker</b>', 'Share Signal','Customer support' ),
                    "color" => "blue",
                ],
                [
                    "id" => 99,
                    "level" => "Custom",
                    "price" => "99",
                    "billed" => "month",
                    "specialNote" => "Contact Us",
                    "levelPlus" => "Included Traders, plus :",
                    "items" => array( 'Unlimted Upload Photo'),
                    "color" => "dark",
                ],
            )
        );
        
        return  view('website_global/header')
            .view('website_pricing',$data)
            .view('website_global/footer');
        
    }
}
