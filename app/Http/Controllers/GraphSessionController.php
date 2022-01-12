<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class GraphSessionController extends Controller
{
    public function index()
    {
        $json_path = env('JSON_PATH');
        $json = file_get_contents($json_path);
        $hosts = json_decode($json, true);

        // $income
        // $outgo
        $conn = [];
        $count = [];
        foreach($hosts as $key=>$value){
            if($key != "test") {
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
                        // Dstip  "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                        $dstip = explode(" ", $str_sec[1])[1];
                        $conn0 = $srcip.'_'.$dstip;
                        $conn1 = $dstip.'_'.$srcip;
                        if (!in_array($conn0, $conn) && !in_array($conn1, $conn)) {
                            array_push($conn, $conn0);
                            array_push($count, 0);
                        }
                        else if (in_array($conn0, $conn)) {
                            $count[array_search($conn0, $conn)]++;
                        }
                        else if (in_array($conn1, $conn)) {
                            $count[array_search($conn1, $conn)]++;
                        }
                    }
                }
                for($i=0; $i < count($value['Outgoing Sessions']); $i++){
                    if ($value['Outgoing Sessions'][$i] != null) {
                        $tmp = $value['Outgoing Sessions'][$i];
                        $str_sec = explode(", ", $tmp);
                        // Srcip  "Server: 13.35.37.66 TCP 443 (77 data bytes sent)"
                        $srcip = explode(" ", $str_sec[0])[1];
                        // Dstip  "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                        $dstip = explode(" ", $str_sec[1])[1];
                        $conn0 = $srcip.'_'.$dstip;
                        $conn1 = $dstip.'_'.$srcip;
                        if (!in_array($conn0, $conn) && !in_array($conn1, $conn)) {
                            array_push($conn, $conn0);
                            array_push($count, 0);
                        }
                        else if (in_array($conn0, $conn)) {
                            $count[array_search($conn0, $conn)]++;
                        }
                        else if (in_array($conn1, $conn)) {
                            $count[array_search($conn1, $conn)]++;
                        }
                    }
                }
            }
        }
        // dd($hosts["13.35.37.66"]["OS"]);
        return view('graph.index1', array(
            'hosts' => $hosts,
            'conn' => $conn,
            'count' => $count
        ));
    }

    public function scope($hostid) {
        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);
        $id = (int)$hostid;
        $keys = array_keys($hosts);
        $host = $hosts[$keys[$id]];
        //dd($host);
        return view('host.detail', array(
            'host' => $host,
            'hosts' => $hosts
        ));
    }
}
