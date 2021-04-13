<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraphDeviceController extends Controller
{
    public function index()
    {
        $hosts = $this->get_json();
        $datas = $this->get_mac_details($hosts);
        $labels = ["IP"];
        $titles = ["IP", "Incoming Sessions", "Outgoing Sessions"];

        return view('graph.index0', array(
            'datas' => $datas,
            'hosts' => $datas["hosts"],
            'labels' => $labels,
            'titles' => $titles,
        ));
    }

    public function get_json() {
        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);
        // remove test in the end of element
        unset($hosts["test"]);
        // set icon
        foreach($hosts as $key=>$value) {
            //dd($hosts[$key]["Icon"]);
            $hosts[$key]["Icon"] = str_replace(public_path(), "", $hosts[$key]["Icon"]);
        }
        return $hosts;
    }

    public function get_mac_details($hosts) {
        $devices = [];
        $venders = [];
        $ages = [];

        foreach($hosts as $key=>$value)
            if ($key!="test")
                if (!in_array($value["MAC"], $devices)) {
                    array_push($devices, $value["MAC"]);
                    array_push($venders, $value["NIC Vender"]);
                    array_push($ages, $value["MAC Age"]);
                }
        $device_conn = [];
        $device_count = [];
        foreach($hosts as $key=>$value){
            if($key != "test")
                for($i=0; $i < count($value['Incoming Sessions']); $i++){
                    if ($value['Incoming Sessions'][$i] != null) {
                        $tmp = $value['Incoming Sessions'][$i];
                        $str_sec = explode(", ", $tmp);
                        /*array:4 [▼
                            0 => "Server: 13.35.37.66 TCP 443 (77 data bytes sent)"
                            1 => "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                            2 => "Session start: 2020-06-02 09:30:38 UTC"
                            3 => "Session end: 2020-06-02 09:33:07 UTC"
                            ] */
                        // Srcip  "Server: 13.35.37.66 TCP 443 (77 data bytes sent)"
                        $srcip = explode(" ", $str_sec[0])[1];
                        $src_mac = $hosts[$srcip]["MAC"];
                        // Dstip  "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                        $dstip = explode(" ", $str_sec[1])[1];
                        $dst_mac = $hosts[$dstip]["MAC"];
                        $connect0 = $src_mac . "_" . $dst_mac;
                        $connect1 = $dst_mac . "_" . $src_mac;
                        if (!in_array($connect0, $device_conn) && !in_array($connect1, $device_conn)) {
                            array_push($device_conn, $connect0);
                            array_push($device_count, 0);
                        }
                        else if (in_array($connect0, $device_conn)){
                            $device_count[array_search($connect0, $device_conn)]++;
                        }
                        else if (in_array($connect1, $device_conn)){
                            $device_count[array_search($connect1, $device_conn)]++;
                        }
                    }
                }
        }

        return array(
            'hosts' => $hosts,
            'devices' => $devices,
            'venders' => $venders,
            'ages' => $ages,
            'device_conn' => $device_conn,
            'device_count' => $device_count
        );
    }
//     "3.209.45.230" => array:11 [▼
//     "MAC" => "AC202EF945C2"
//     "NIC Vender" => "Hitron Technologies. Inc"
//     "MAC Age" => "1/4/2017"
//     "IP" => "3.209.45.230"
//     "OS" => "Linux"
//     "OS Detail" => "Linux - Redhat 7.5 (50.00%) Linux - Linux 3.10 (50.00%) "
//     "Host Name" => "expressapisv2.net, www.expressapisv2.net"
//     "Queried DNS" => []
//     "Incoming Sessions" => array:4 [ …4]
//     "Outgoing Sessions" => []
//     "Details" => array:3 [ …3]
//   ]
    public function search(Request $request) {
        $hosts = $this->get_json();
        $datas = $this->get_mac_details($hosts);
        // to search
        $tosearch = $request->search;
        // set label
        $labels = ["IP", "Host Name"];
        $titles = ["IP", "Incoming Sessions", "Outgoing Sessions"];

        $keys = array_keys($hosts);
        // get hosts to plot
        $hosts_plot = [];
        // check IP
        for($i=0;$i<count($hosts);$i++)
            if (str_contains($hosts[$keys[$i]]["IP"], $tosearch)){
                //dd($hosts[$keys[$i]]);
                $hosts_plot[$i] = $hosts[$keys[$i]];
            }

        // check Mac
        // check Domain
        return view('graph.index0', array(
            'datas' => $datas,
            'hosts' => $hosts_plot,
            'labels' => $labels,
            'titles' => $titles,
        ));
    }

    public function detail_to_show(Request $request) {
        $hosts = $this->get_json();
        $datas = $this->get_mac_details($hosts);

        $labels = $request->select_item;
        $titles = $request->select_item;
        //dd($datas);
        return view('graph.index0', array(
            'datas' => $datas,
            'hosts' => $datas["hosts"],
            'labels' => $labels,
            'titles' => $titles,
        ));
    }

    public function scope($hostid) {
        $hosts = $this->get_json();
        $id = (int)$hostid;

        if ($id >= count($hosts)-1) return redirect('/graph0');
        $keys = array_keys($hosts);
        $host = $hosts[$keys[$id]];
        //dd($host);

        $datas = $this->get_mac_details($hosts);
        // sessions
        $conn = [];
        $count = [];
        $srcips = [];
        $dstips = [];
        for($i=0; $i < count($host['Incoming Sessions']); $i++){
            if ($host['Incoming Sessions'][$i] != null) {
                $tmp = $host['Incoming Sessions'][$i];
                $str_sec = explode(", ", $tmp);
                /*array:4 [▼
                    0 => "Server: 13.35.37.66 TCP 443 (77 data bytes sent)"
                    1 => "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                    2 => "Session start: 2020-06-02 09:30:38 UTC"
                    3 => "Session end: 2020-06-02 09:33:07 UTC"
                    ] */
                // Srcip  "Server: 13.35.37.66 TCP 443 (77 data bytes sent)"
                $srcip = explode(" ", $str_sec[0])[1];
                // Dstip  "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                $dstip = explode(" ", $str_sec[1])[1];

                array_push($srcips, $srcip);
                array_push($dstips, $dstip);
                $conn0 = $srcip.'_'.$dstip;
                $conn1 = $dstip.'_'.$srcip;
                if (!in_array($conn0, $conn) && !in_array($conn1, $conn)) {
                    array_push($conn, $conn0);
                    array_push($count, 1);
                }
                else if (in_array($conn0, $conn)) {
                    $count[array_search($conn0, $conn)]++;
                }
                else if (in_array($conn1, $conn)) {
                    $count[array_search($conn1, $conn)]++;
                }
            }
        }
        for($i=0; $i < count($host['Outgoing Sessions']); $i++){
            if ($host['Outgoing Sessions'][$i] != null) {
                $tmp = $host['Outgoing Sessions'][$i];
                $str_sec = explode(", ", $tmp);
                // Srcip  "Server: 13.35.37.66 TCP 443 (77 data bytes sent)"
                $srcip = explode(" ", $str_sec[0])[1];
                // Dstip  "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                $dstip = explode(" ", $str_sec[1])[1];

                array_push($srcips, $srcip);
                array_push($dstips, $dstip);

                $conn0 = $srcip.'_'.$dstip;
                $conn1 = $dstip.'_'.$srcip;
                if (!in_array($conn0, $conn) && !in_array($conn1, $conn)) {
                    array_push($conn, $conn0);
                    array_push($count, 1);
                }
                else if (in_array($conn0, $conn)) {
                    $count[array_search($conn0, $conn)]++;
                }
                else if (in_array($conn1, $conn)) {
                    $count[array_search($conn1, $conn)]++;
                }
            }
        }
        // get hosts to plot
        $hosts_plot = [];
        for($i=0; $i<count($keys)-1; $i++) {
            if (in_array($keys[$i], $srcips))
                $hosts_plot[$i] = $hosts[$keys[$i]];
            else if (in_array($keys[$i], $dstips))
                $hosts_plot[$i] = $hosts[$keys[$i]];
        }
        // set icon
        foreach($hosts_plot as $key=>$value) {
            $hosts_plot[$key]["Icon"] = str_replace(public_path(), "", $hosts_plot[$key]["Icon"]);
        }
        // set label
        $labels = ["IP", "Host Name"];
        $titles = ["IP", "Incoming Sessions", "Outgoing Sessions"];

        return view('graph.scope', array(
            'id' => $hostid,
            'host' => $host,
            'hosts' => $hosts_plot,
            'conn' => $conn,
            'count' => $count,
            'labels' => $labels,
            'titles' => $titles,
        ));
    }

}
