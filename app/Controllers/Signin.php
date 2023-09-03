<?php

namespace App\Controllers;
use CodeIgniter\HTTP\Response;
class Signin extends BaseController
{
    function index()
    { 
        $data = []; 
        return  view('signin',$data);
        
    }
    function configjs()
    { 
        $response = response();
        $response->setHeader('Content-Type', 'application/javascript');
        echo "var clientId = '".$_ENV['CLIENTID']."';" . "\n";
        echo "var api = '".$_ENV['API_APP']."'"  . "\n";
        echo  "var home = '".$_ENV['HOME_APP']."'"  . "\n";
        
    }
}
