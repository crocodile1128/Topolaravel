<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraphDeviceController extends Controller
{
    public function index()
    {
        $hosts = $this->get_json();
        $datas = $this->get_mac_details($hosts);
        $labels = ["IP", "Host Name"];
        $titles = ["IP", "Incoming Sessions", "Outgoing Sessions"];
        return view('graph.index0', array(
            'datas' => $datas,
            'labels' => $labels,
            'titles' => $titles,
        ));
    }

    public function get_json() {
        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);
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

    public function search(Request $request) {
        dd($request->search);
    }

    public function detail_to_show(Request $request) {
        $hosts = $this->get_json();
        dd($request);
    }

    public function scope($hostid) {
        $hosts = $this->get_json();
        $id = (int)$hostid;

        if ($id >= count($hosts)-1) return redirect('/graph0');
        $keys = array_keys($hosts);
        $host = $hosts[$keys[$id]];
        //dd($host);

        $datas = $this->get_mac_details($hosts);

        $labels = ["IP", "Host Name"];
        $titles = ["IP", "Incoming Sessions", "Outgoing Sessions"];
        return view('graph.scope', array(
            'host' => $host,
            'datas' => $datas,
            'labels' => $labels,
            'titles' => $titles,
        ));
    }

}
