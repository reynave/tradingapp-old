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
        $data['tabs']  = [];
        if ($id && $journalTableViewId !== null) {

            $obj = [
                "order" => 0,
                "limit" => 100,
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
                ), $journal_table_view->getResultArray()
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

            return view('website_global/header')
                . view($board, $data)
                . view('app_global/footer');
        }
        return view('website_global/header')
            . view('notfound',$data)
            . view('app_global/footer');
    }


    private function table($obj = [])
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