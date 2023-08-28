<?php

namespace App\Controllers;

class Profile extends BaseController
{
    public function index($username = "")
    {
        $get = $this->request->getVar();

        $username = str_replace(["'", "\'", '"', "#"], "", $username);
        $id = model("Core")->select("id", "account", "username = '$username' and status != 0 and presence = 1");
        if ($id != '') {
            $detail = $this->db->query("SELECT id, username,  description, picture  
            FROM account WHERE username = '$username' ");

            $sosialMedia = $this->db->query("SELECT * FROM account_sosmed WHERE accountId = '$id' ");
            $achievement = $this->db->query("SELECT * FROM account_achievement WHERE accountId = '$id' ");
            $journal = $this->db->query("SELECT url, name, image
            FROM journal 
            WHERE accountId = '$id' AND permissionId =  20 AND presence = 1 ORDER BY update_date DESC ");

            $user = array(
                "username" => $username,
                "detail" => $detail->getResultArray()[0],
                "sosial_media" => $sosialMedia->getResultArray(),
                "achievement" => $achievement->getResultArray(),
                "journal" => $journal->getResultArray(),
            );

            $data = array(
                "header" => view('app_global/nav'),
                "username" => $username,
                "user" => $user,
            );

            if (isset($get['data'])) {
                if ($get['data'] == 'json') {
                    return $this->response->setJSON($user);
                }
                return view('json', $data);
            }


            return view('website_global/header')
                . view('profile', $data)
                . view('website_global/footer');
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function sharedSAVE($url = "", $name = "")
    {
        $get = $this->request->getVar();

        $url = str_replace(["'", "\'", '"', "#"], "", $url);
        $name = str_replace(["'", "\'", '"', "#"], "", $name);

        $id = model("Core")->select("id", "journal", "url = '$url'  AND presence = 1 AND permissionId = 20");
        $journalTableViewId = isset($this->request->getVar()['tab']) ? $this->request->getVar()['tab'] : model("Core")->select("id", "journal_table_view", "ilock=1 and journalId = '$id' ");

        $journal = $this->db->query("SELECT * FROM journal WHERE id = '$id' and presence = 1  ");


        $journal_table_view = $this->db->query("SELECT id, name, board 
        FROM journal_table_view 
        WHERE presence = 1 and share = 1 and journalId = '$id' order by input_date ASC");
        $tabs = array_merge(
            array(
                [
                    "id" => model("Core")->select("id", "journal_table_view", "ilock=1 and journalId = '$id' "),
                    "name" => model("Core")->select("name", "journal_table_view", "ilock=1 and journalId = '$id' "),
                    "board" => model("Core")->select("board", "journal_table_view", "ilock=1 and journalId = '$id' "),
                ]
            ), $journal_table_view->getResultArray()
        );


        $q = "SELECT c.id,  c.f, c.name, iType, width, eval
        FROM journal_custom_field AS c
        WHERE c.journalId = '$id' order by sorting ASC";
        $custom_field = [];
        $header = [];
        $f = "";

        array_push($header, [
            "tabs" => model("Core")->select("name", "journal_table_view", "ilock=1 and journalId = '$id' ")
        ]);
        foreach ($this->db->query($q)->getResultArray() as $row) {
            $hide = (bool) model("Core")->select("hide", "journal_table_view_show", " presence = 1 and  journalTableViewId = '$journalTableViewId' AND journalCustomFieldId = '" . $row['id'] . "'");
            if ($hide != true) {
                $selectDb = "SELECT id,value,color
                FROM journal_select  
                WHERE journalId = '$id' and field = 'f" . $row['f'] . "' ORDER BY sorting ASC";

                array_push($custom_field, array_merge($row, [
                    "hide" => $hide,
                    "f" . $row['f'] => $row['name'],
                    "option" => $this->db->query($selectDb)->getResultArray()
                ]));

                $header[] = array(
                    "f" . $row['f'] => $row['name']
                );

                $f .= ", f" . $row['f'] . " ";
            }

        }

        $q = "SELECT id  $f FROM journal_detail 
        WHERE journalId = '$id' and presence = 1 and archives = 0 
        ORDER BY sorting ASC";
        $journal_detail = $this->db->query($q);
        $dev = "";

        foreach ($journal_detail->getResultArray() as $index => $rec) {
            foreach ($rec as $k => $v) {

                $dev .= $index . " " . $k . " | ";
            }

        }

        $data = array(
            // "url" => $url,
            //  "journal" => $journal->getResultArray()[0],
            //  "bookmark" => model("Core")->select("count(id)", "account_bookmark", "journalId = '$id' and presence = 1 "),

            "custom_field" => $custom_field,
            //  "header" => self::mergeArrayOfObjects($header),
            "detail" => $journal_detail->getResultArray(),
            // "tabs" => $tabs,
            "dev" => $dev,


        );

        return $this->response->setJSON($data);
        //return view('welcome_message');
    }

    function shared($url = "", $name = "")
    {
        $order = 0;
        $limit = 100;
        $get = $this->request->getVar();

        $url = str_replace(["'", "\'", '"', "#"], "", $url);
        $name = str_replace(["'", "\'", '"', "#"], "", $name); 

        $id = model("Core")->select("id", "journal", "url = '$url'  AND presence = 1 AND permissionId = 20");
 
        $journalId = model("Core")->select("id", "journal", "url = '$url'  AND presence = 1 AND permissionId = 20");
        $journalTableViewId = isset($this->request->getVar()['tab']) ? $this->request->getVar()['tab'] : model("Core")->select("id", "journal_table_view", "ilock=1 and journalId = '$id' ");

        $id = model("Core")->select("journalId", "journal_access", "journalId = '" . $journalId . "'  AND presence = 1");
        if ($id) {
            $journal_select =  $this->db->query("SELECT id,value, color FROM journal_select WHERE journalId = '$journalId'  ");
            $journalTable = model("Core")->journalTable($id, $journalTableViewId,"",$order,$limit);
            $header = array_merge(
                array(
                    [
                        "tabs" => model("Core")->select("name", "journal_table_view", "ilock=1 and journalId = '$id' "),
                    ]
                ), $journalTable['header']
            );
            $header = self::mergeArrayOfObjects($header);
            $journal = $this->db->query("SELECT * FROM journal WHERE id = '$id' and presence = 1  ");


            $journal_table_view = $this->db->query("SELECT id, name, board 
                FROM journal_table_view 
                WHERE presence = 1 and share = 1 and journalId = '$id' order by input_date ASC");
            $tabs = array_merge(
                array(
                    [
                        "id" => model("Core")->select("id", "journal_table_view", "ilock=1 and journalId = '$id' "),
                        "name" => model("Core")->select("name", "journal_table_view", "ilock=1 and journalId = '$id' "),
                        "board" => model("Core")->select("board", "journal_table_view", "ilock=1 and journalId = '$id' "),
                    ]
                ), $journal_table_view->getResultArray()
            );


            $data = array(
                "error" => false,
                "url" => $url,
                "journal" => $journal->getResultArray()[0],
                "bookmark" => array(
                    "count" => (int) model("Core")->select("count(id)", "account_bookmark", "journalId = '$id' and presence = 1 "),
                ),
              
                "pages" => [
                    "page" => $order + 1,
                    "limit" =>   $limit,
                    "total" =>  $journalTable['total'], 
                ],
                "custom_field" => $journalTable['journal_custom_field'], 
                "header" => $header,
                "detail" => $journalTable['detail'],
                "tabs" => $tabs,
            );

        }
        return $this->response->setJSON($data);
    }

    private function mergeArrayOfObjects($arrays)
    {
        $result = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                $result[$key] = $value;
            }
        }

        return [$result];
    }

    function getSelectValue()
    {

    }

}