<?php

namespace App\Controllers;

class Shared extends BaseController
{
 
    function index($url = "", $name = "")
    {
        $order = 0;
        $limit = 100;
        $get = $this->request->getVar();

        $url = str_replace(["'", "\'", '"', "#"], "", $url);
        $name = str_replace(["'", "\'", '"', "#"], "", $name);
        $id = model("Core")->select("id", "journal", "url = '$url'  AND presence = 1 AND permissionId = 20");
        $journalId = $id;

        $id = model("Core")->select("journalId", "journal_access", "journalId = '" . $journalId . "'  AND presence = 1");
        $journalTableViewId = isset($this->request->getVar()['tab']) ? $this->request->getVar()['tab'] : model("Core")->select("id", "journal_table_view", "ilock=1 and journalId = '$id' ");
        $data['tabs'] = [];
        if ($id && $journalTableViewId !== null) {

            $obj = [
                "order" => 0,
                "limit" => 1000,
                "id" => $id,
                "journalId" => $journalId,
                "journalTableViewId" => $journalTableViewId,
            ];

            $board = model("Core")->select("board", "journal_table_view", "id = '$journalTableViewId' ");
            if ($board == 'table') {
                $data = self::table($obj);
            } else if ($board == 'chart') {
                $data = self::chart($obj);
            }


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
                ),
                $journal_table_view->getResultArray()
            );
            $data['tabs'] = $tabs;

        }

        $q = "SELECT  j.*, a.username, a.picture,  p.name AS 'plan', a.party, p.icon
        FROM journal as j
        JOIN account as a on a.id = j.accountId
        JOIN plans AS p ON p.id = a.plansId
        where j.url = '$url' and j.presence = 1";

        $data['journal'] = $this->db->query($q)->getResultArray()[0];
        $data['journalTableViewId'] = $journalTableViewId;
        $data['totalTask'] = (int) model("Core")->select("count(id)", "journal_detail", "journalId = '$id'");


        if (isset($get['data'])) {
            if ($get['data'] == 'json') {
                return $this->response->setJSON($data);
            }
        }

        if ($id && $journalTableViewId !== null) {

            $header = array(
                "title" => $data['journal']['name'] . " by " . ucwords($data['journal']['username']) . " on Mirrel.com",
                "description" => $data['journal']['name'] . " by " . ucwords($data['journal']['username']) . " on Mirrel.com. Unlocking Trader Success, Together on Mirrel.com; the global community for trader professionals.",
                "image" => $data['journal']['image'],
                "url" => base_url() . "shared/" . $data['journal']['url'] . "/" . url_title($data['journal']['name']),
                "canonical" => base_url() . "shared/" . $data['journal']['url'] . "/" . url_title($data['journal']['name'])
            );

            return view('website_global/header', $header)
                . view("share_" . $board, $data)
                . view('app_global/footer');
        }
        return view('website_global/header', model("Core")->headerNotFound())
            . view('notfound', )
            . view('app_global/footer');
    }
 
    function shorcut($url)
    {
        $get = $this->request->getVar();

        $url = str_replace(["'", "\'", '"', "#"], "", $url);
        $id = model("Core")->select("id", "journal", "url = '$url'  AND presence = 1 AND permissionId = 20");

        $q = "SELECT  j.*, a.username, a.picture,  p.name AS 'plan', a.party, p.icon
        FROM journal as j
        JOIN account as a on a.id = j.accountId
        JOIN plans AS p ON p.id = a.plansId
        where j.url = '$url' and j.presence = 1";
        $data['journal'] = $this->db->query($q)->getResultArray()[0];

        if (isset($get['data'])) {
            if ($get['data'] == 'json') {
                return $this->response->setJSON($data);
            }
        }

        if ($id) {
            $header = array(
                "title" => $data['journal']['name'] . " by " . ucwords($data['journal']['username']) . " on Mirrel.com",
                "description" => $data['journal']['name'] . " by " . ucwords($data['journal']['username']) . " on Mirrel.com. Unlocking Trader Success, Together on Mirrel.com; the global community for trader professionals.",
                "image" => $data['journal']['image'],
                "url" => base_url() . "shared/" . $data['journal']['url'] . "/" . url_title($data['journal']['name']),
                "canonical" => base_url() . "shared/" . $data['journal']['url'] . "/" . url_title($data['journal']['name'])
            );

            return view('website_global/header', $header)
                . view('share_shortcut', $header)
                . view('app_global/footer');
        }
        return view('website_global/header', model("Core")->headerNotFound())
            . view('notfound')
            . view('app_global/footer');
    }

    function d($url, $journal_detail_id)
    {
        $get = $this->request->getVar();
        $url = str_replace(["'", "\'", '"', "#"], "", $url);
        $id = model("Core")->select("id", "journal", "url = '$url'  AND presence = 1 AND permissionId = 20");
        $journal_detail_id = model("Core")->select("id", "journal_detail", "id = '$journal_detail_id'  AND presence = 1");

        if ($id && $journal_detail_id != "") {

            $images = [];

            $q = "SELECT  j.*, a.username, a.picture,  p.name AS 'plan', a.party, p.icon
            FROM journal as j
            JOIN account as a on a.id = j.accountId
            JOIN plans AS p ON p.id = a.plansId
            where j.url = '$url' and j.presence = 1";
            $data['journal'] = $this->db->query($q)->getResultArray()[0];

            $q1 = "SELECT  f, name, iType, suffix, eval, hide from journal_custom_field where journalId = '$id' and presence = 1 order by sorting ASC";
            $detail = $this->db->query($q1)->getResultArray();
            $items = [];

            $evaluateFormula = function ($data, $formula) {
                extract($data);
                return eval("return $formula;");
            };


            for ($i = 1; $i < 32; $i++) {
                $array['f' . $i] = (int) model("Core")->select("f" . $i, "journal_detail", "id=$journal_detail_id");
            }

            foreach ($detail as $row) {

                $value = model("Core")->select("f" . $row['f'], "journal_detail", "id=$journal_detail_id");

                if ($row['iType'] == 'select') {
                    $value = model("Core")->select("value", "journal_select", " id = '$value' ");
                }
                if ($row['iType'] == 'user') {
                    $value = ucwords(model("Core")->select("username", "account", " id = '$value' "));
                }
                if ($row['iType'] == 'formula') {
                    $value = $evaluateFormula($array, $row['eval']);
                }
                if ($row['iType'] == 'image') {
                    $q1 = "SELECT path, fileName, caption, '" . $row['name'] . "' as 'column'  from journal_detail_images
                     where journalDetailId = '$journal_detail_id' and presence = 1 
                     order by sorting ASC ,input_date ASC";
                    $images = $this->db->query($q1)->getResultArray(); 
                }

                array_push($items, [
                    "key" => 'f' . $row['f'],
                    "name" => $row['name'],
                    "iType" => $row['iType'],
                    "hide" => (boolean) $row['hide'],
                    "value" => $value . $row['suffix'],
                ]);
            }

            $data['detail'] = $detail;
            $data['items'] = $items;
            $data['images'] = $images;
            $data['journal_detail_id'] = $journal_detail_id;
            $header = array(
                "title" => $data['journal']['name'] . " by " . ucwords($data['journal']['username']) . " on Mirrel.com",
                "h1" => $data['journal']['name'],
                "description" => $data['journal']['name'] . " by " . ucwords($data['journal']['username']) . " on Mirrel.com. Unlocking Trader Success, Together on Mirrel.com; the global community for trader professionals.",
                "image" => count($images) > 0 ? $images[0]['path'] . $images[0]['fileName'] : $data['journal']['image'],
                "url" => base_url() . "shared/" . $data['journal']['url'] . "/" . url_title($data['journal']['name']),
                "canonical" => base_url() . "shared/" . $data['journal']['url'] . "/" . url_title($data['journal']['name']),
            );
            $data['header'] = $header;

            if (isset($get['data'])) {
                if ($get['data'] == 'json') {
                    return $this->response->setJSON($data);
                }
            }
            return view('website_global/header', $header)
                . view('share_detail', $data)
                . view('app_global/footer');
        }

        return view('website_global/header', model("Core")->headerNotFound())
            . view('notfound')
            . view('app_global/footer');

    }

    function chart($obj = [])
    {



        // $id = $obj['id'];
        $journalId = $obj['journalId'];
        $journalTableViewId = $obj['journalTableViewId'];


        /* $data = array(
             "error" => true,
             "request" => $this->request->getVar(),
         );*/
        // $journalId = $data['request']['id'];
        //   $journalTableViewId = $data['request']['journalTableViewId'];



        $id = model("Core")->select("journalId", "journal_access", "journalId = '" . $journalId . "' and presence = 1");
        if ($id) {


            $journalTable = model("Core")->journalChart($id, $journalTableViewId);
            $customField = $journalTable['journal_custom_field'];

            $y = [];
            $iWhere = [];
            // yAxis
            foreach ($customField as $row) {

                $q1 = "SELECT a.id, a.value, IF(s.status = 1, TRUE, FALSE) as checkbox  , a.field
                FROM journal_select AS a 
                LEFT JOIN journal_chart_where_select AS s ON s.journalSelectId = a.id
                WHERE   a.presence = 1   and a.field = '" . $row['key'] . "'  AND  s.journalTableViewId = $journalTableViewId 
                ORDER BY a.sorting ASC";
                $option = $this->db->query($q1)->getResultArray();


                if (count($option) < 1) {

                    $q2 = "SELECT * 
                    FROM journal_select
                    WHERE  presence = 1  AND field = '" . $row['key'] . "' and journalId = '" . $id . "'
                    ORDER BY sorting ASC";
                    $optionMaster = $this->db->query($q2)->getResultArray();

                    foreach ($optionMaster as $res) {
                        $this->db->table('journal_chart_where_select')->insert([
                            "journalTableViewId" => $journalTableViewId,
                            "journalSelectId" => $res['id'],
                            "status" => 0,
                            "presence" => 1,
                        ]);

                    }
                    $q1 = "SELECT a.id, a.value, IF(s.status = 1, TRUE, FALSE) as checkbox  , a.field
                    FROM journal_select AS a 
                    LEFT JOIN journal_chart_where_select AS s ON s.journalSelectId = a.id
                    WHERE   a.presence = 1   and a.field = '" . $row['key'] . "'  AND  s.journalTableViewId = $journalTableViewId 
                    ORDER BY a.sorting ASC";
                    $option = $this->db->query($q1)->getResultArray();
                }


                $temp = array(
                    "key" => $row['key'],
                    "name" => $row['name'],
                    "iType" => $row['iType'],
                    "check" => model("Core")->select("status", "journal_chart_yaxis", "value= '" . $row['key'] . "' and journalTableViewId = $journalTableViewId "),
                    "fill" => (bool) model("Core")->select("fill", "journal_chart_yaxis", "value= '" . $row['key'] . "' and journalTableViewId = $journalTableViewId "),
                    "presence" => $row['presence'],
                    "option" => $option,

                );

                if ($row['iType'] == 'number' || $row['iType'] == 'formula') {
                    array_push($y, $temp);
                } else if ($row['iType'] == 'select') {
                    array_push($iWhere, $temp);
                }
            }


            $q1 = "SELECT id, itype, label FROM chartjs_type
            WHERE status = 1 
            ORDER BY sorting ASC ";
            $typeOfChart = $this->db->query($q1)->getResultArray();

            $chartjsTypeId = model("Core")->select("chartjsTypeId", "journal_chart_type", "journalTableViewId = '$journalTableViewId'  AND  status = 1 ");
            $xaxis = model("Core")->select("value", "journal_chart_xaxis", "journalTableViewId = '$journalTableViewId'  AND  status = 1 ");
            $idWhere = model("Core")->select("value", "journal_chart_where", "journalTableViewId = '$journalTableViewId'  AND  status = 1 ");

            $q1 = "SELECT id, value, status, fill FROM journal_chart_yaxis
            WHERE  journalTableViewId = '$journalTableViewId' AND presence = 1 ";
            $yaxis = $this->db->query($q1)->getResultArray();

            $journal_chart = [
                "chartjsTypeId" => $chartjsTypeId ? $chartjsTypeId : 0,
                "type" => $chartjsTypeId ? $chartjsTypeId : 0,
                "xaxis" => $xaxis != null ? $xaxis : "",
                "yaxis" => $yaxis,
                "idWhere" => $idWhere ? $idWhere : "",
            ];

            $index = model("Core")->index2d($typeOfChart, $journal_chart['chartjsTypeId']);
            $journal_chart['type'] = $typeOfChart[$index]['itype'];


            $selectWhereOption = [];
            foreach ($iWhere as $k) {
                if ($k['key'] == $journal_chart['idWhere']) {
                    $selectWhereOption = $k['option'];
                }
            }
            $startup = true;
            if ($journal_chart['xaxis'] != "") {
                $startup = false;
            }


            $data = array(
                "error" => false,

                "bookmark" => array(
                    "count" => (int) model("Core")->select("count(id)", "account_bookmark", "journalId = '$id' and presence = 1 "),
                ),
                "type_chart" => $typeOfChart,
                "field_chart" => $journal_chart,
                "where_chart" => $selectWhereOption,
                "data_chart" => $startup == false ? model("Core")->chartJsData($journal_chart, $journalTable['detail'], $y, $selectWhereOption) : [],

            );


        }
        return $data;
    }

    private function tableVer1($obj = [])
    {
        $id = $obj['id'];
        $journalId = $obj['journalId'];
        $journalTableViewId = $obj['journalTableViewId'];
        $order = $obj['order'];
        $limit = $obj['limit'];

        $journalTable = model("Core")->journalTable($id, $journalTableViewId, "", $order, $limit);
        // $header = array_merge(
        //     array(
        //         [
        //             "tabs" => model("Core")->select("name", "journal_table_view", "ilock=1 and journalId = '$id' "),
        //         ]
        //     ), $journalTable['header']
        // );
        //$header = self::mergeArrayOfObjects($header);
        $header = $journalTable['header'];

        $data = array(
            "error" => false,

            "bookmark" => array(
                "count" => (int) model("Core")->select("count(id)", "account_bookmark", "journalId = '$id' and presence = 1 "),
            ),
            "pages" => [
                "page" => $order + 1,
                "limit" => $limit,
                "total" => $journalTable['total'],
            ],
            "headers" => $header,
            "journal_custom_field" => $journalTable['journal_custom_field'],
            "detail" => $journalTable['detail'],

        );

        return $data;
    }
    private function table($obj = [])
    {
        $id = $obj['id'];
        $journalId = $obj['journalId'];
        $journalTableViewId = $obj['journalTableViewId'];
        $order = $obj['order'];
        $limit = $obj['limit'];


        $q1 = "SELECT  id, f, name, iType, suffix, eval, hide from journal_custom_field 
        where journalId = '$journalId' and presence = 1 order by sorting ASC";
        $journal_custom_field = $this->db->query($q1)->getResultArray();
       
        $q2 = "SELECT * from journal_detail 
        where journalId = '$journalId' and presence = 1 and archives = 0 
        order by sorting ASC
        limit  $order, $limit  ";
        $journal_detail = $this->db->query($q2)->getResultArray();

        $evaluateFormula = function ($data, $formula) {
            extract($data);
            return eval("return $formula;");
        };
    
        $items = []; 
        foreach ($journal_detail as $row) {

            $item = [];
            for ($i = 1; $i < 32; $i++) {
                $array['f' . $i] = (int) $row['f'.$i];
            }
            foreach( $journal_custom_field as $f){
                $hide = model("Core")->select("hide","journal_table_view_show","journalTableViewId = '$journalTableViewId' and journalCustomFieldId = '".$f['id']."' and presence = 1 ");
                if( $hide != 1 ){
                    $value = $row['f'.$f['f']];
                    if ($f['iType'] == 'select') {
                        $value = model("Core")->select("value", "journal_select", " id = '$value' ");
                    }
                    if ($f['iType'] == 'user') {
                        $value = ucwords(model("Core")->select("username", "account", " id = '$value' "));
                    }
                    if ($f['iType'] == 'image') {
                        $value = $value .' '.$f['iType'].'s';
                    } 
                    if ($f['iType'] == 'formula') {
                        $value = $evaluateFormula($array, $f['eval']);
                    }
                   if( $f['hide'] != 1 ){
                        $item[] =  [
                            // "journalTableViewId" =>  $journalTableViewId ,
                            // "journalCustomFieldId" => $f['id'],
                            "id" => $row['id'],
                            "key" => 'f'.$f['f'],
                            "name" =>  $f['name'],
                            "hide" =>  $f['hide'],
                            "iType" =>  $f['iType'],
                            "value" =>   $value.$f['suffix'],
                        ];
                   }
                    
                }
              
            } 

            $items[] = $item; 
            
        }
 

        $data = array(
            "error" => false, 
            "bookmark" => array(
                "count" => (int) model("Core")->select("count(id)", "account_bookmark", "journalId = '$id' and presence = 1 "),
            ),
            "pages" => [
                "page" => $order + 1,
                "limit" => $limit,
                "total" => count($items),
            ], 
            "items" => $items,

        );

        return $data;
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

    private function arrayStaticToDinamic($arrays)
    {
        $result = [];
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                $result[] = array(
                    "key" => $key,
                    "label" => $value,
                );

            }
        }
        return [$result];
    }

    function getSelectValue()
    {

    }

}