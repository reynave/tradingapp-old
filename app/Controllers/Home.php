<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        //return view('welcome_message');
        $header = array(
            "title" => "Unlocking Trader Success, Together on Mirrel.com",
            "description" => "Made by Trader for trader. Journal, Colaboration, and Trading. Unlocking Trader Success, Together",
            "image" => base_url()."assets/banner/banner1.jpg",
            "url" => base_url(),
            "canonical" => base_url(),
        );
        $body = [
            "active"=> "",
        ];
        return  view('website_global/header',$header)
            .view('website_home_simple',$body)
            .view('website_global/footer');
        
    }

    public function about(): string
    {
        $header = array(
            "title" => "Unlocking Trader Success, Together on Mirrel.com",
            "description" => "Made by Trader for trader. Journal, Colaboration, and Trading. Unlocking Trader Success, Together",
            "image" => base_url()."assets/banner/banner1.jpg",
            "url" => base_url(),
            "canonical" => base_url(),
        );
        $body = [
            "active"=> "about",
        ];
        return  view('website_global/header',$header)
            .view('website_about',$body)
            .view('website_global/footer');
        
    }

    public function pricing(): string
    { 
        
        $header = array(
            "title" => "Unlocking Trader Success, Together on Mirrel.com",
            "description" => "Made by Trader for trader. Journal, Colaboration, and Trading. Unlocking Trader Success, Together",
            "image" => base_url()."assets/banner/banner1.jpg",
            "url" => base_url(),
            "canonical" => base_url(),
        );

        $body = [
            "active"=> "pricing",
        ];
        
        return  view('website_global/header',$header)
            .view('website_pricing',$body)
            .view('website_global/footer');
        
    }
}
