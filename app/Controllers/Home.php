<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        //return view('welcome_message');
        
        
        return  view('website_global/header')
            .view('website_home_simple')
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
                    "items" => array('Unlimited Viewers', 'Unlimited Teams', 'Unlimited Books', 'Unlimited Journals',
                    '1k task per journal','Chart', 'Personal Pages', 
                    'Share Porfolio', 'Realtime Collaborative'),
                    "color" => "gray",
                ],
                [
                    "id" => 2,
                    "level" => "Pro",
                    "price" => "5",
                    "billed" => "month", 
                    "specialNote" => "SOON",
                    "levelPlus" => "Included Hobby, plus :",
                    "items" => array('No Ads','10k task per journal','Access Right', '5GB Upload Photo', 'Calculation Real <b>Broker</b>', 'Share Signal','Customer support', ),
                    "color" => "blue",
                ],
                [
                    "id" => 99,
                    "level" => "Custom",
                    "price" => "99",
                    "billed" => "month",
                    "specialNote" => "Contact Us",
                    "levelPlus" => "Included Traders, plus :",
                    "items" => array( 'Contact Us'),
                    "color" => "dark",
                ],
            )
        );
        
        return  view('website_global/header')
            .view('website_pricing',$data)
            .view('website_global/footer');
        
    }
}
