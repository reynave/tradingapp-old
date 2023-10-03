<?php

namespace App\Controllers;

class Profile extends BaseController
{
    function index($username = "")
    {
        $get = $this->request->getVar();
        // self::saveImage();
        $username = str_replace(["'", "\'", '"', "#"], "", $username);
        $id = model("Core")->select("id", "account", "username = '$username' and status != 0 and presence = 1");
        if ($id != '') {
            $detail = $this->db->query("SELECT id, username, concat('".$_ENV['API_APP']."uploads/picture/',picture) as 'picture', description, party
            FROM account WHERE username = '$username' ");
      
            $sosialMedia = $this->db->query("SELECT * FROM account_sosmed WHERE accountId = '$id' ");
            $achievement = $this->db->query("SELECT * FROM account_achievement WHERE accountId = '$id' ");


            $journal = $this->db->query("SELECT url, name, image
            FROM journal 
            WHERE accountId = '$id' AND permissionId =  20 AND presence = 1 ORDER BY update_date DESC ");

            $team = $this->db->query("SELECT   a.id, a.username, a.picture
            FROM account_team AS t
            LEFT JOIN account AS a ON a.id = t.invitedId
            WHERE t.accountId = '$id' AND t.`status` = 1 AND t.presence =1
            ");

            $data = array(
                "username" => $username,
                "detail" => $detail->getResultArray()[0],
                "sosial_media" => $sosialMedia->getResultArray(),
                "achievement" => $achievement->getResultArray(),
                "journal" => $journal->getResultArray(),
                "team" => $team->getResultArray(),
            );




            if (isset($get['data'])) {
                if ($get['data'] == 'json') {
                    return $this->response->setJSON($data);
                }
            }

            return view('website_global/header')
                . view('profile', $data)
                . view('app_global/footer');
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
 
    function saveImage()
    {
        $file = 'https://lh3.googleusercontent.com/a/AAcHTteF-aAeCUrnrEsBw0F8ma24A2kHTqOzCXVzRlwIMfyd6DM=s96-c';


        $newfile = FCPATH . '/upload//yoyo.jpg';

        if (copy($file, $newfile)) {
            echo "Copy success!";
        } else {
            echo "Copy failed.";
        }
    }
   
}