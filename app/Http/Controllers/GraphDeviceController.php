<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraphDeviceController extends Controller
{
    public function index()
    {
        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);

//         "152.195.11.6" => array:11 [▼
//     "MAC" => "10FEED3F8D22"
//     "NIC Vender" => "TP-LINK TECHNOLOGIES CO.,LTD."
//     "MAC Age" => "2012/7/25"
//     "IP" => "152.195.11.6"
//     "OS" => "Unknown"
//     "OS Detail" => "Unknown"
//     "Host Name" => "cs611.wpc.edgecastcdn.net, wu.wpc.apr-52dd2.edgecastdns.net, ctldl.windowsupdate.com"
//     "Queried DNS" => []
//     "Incoming Sessions" => array:1 [▶]
//     "Outgoing Sessions" => []
//     "Details" => array:1 [▶]
//   ]
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
                        if (!in_array($connect0, $device_conn) && !in_array($connect1, $device_conn))
                            array_push($device_conn, $connect0);
                    }
                }
        }


        // dd($hosts["13.35.37.66"]["OS"]);
        return view('graph.index0', array(
            'hosts' => $hosts,
            'devices' => $devices,
            'venders' => $venders,
            'ages' => $ages,
            'device_conn' => $device_conn
        ));
    }

}
