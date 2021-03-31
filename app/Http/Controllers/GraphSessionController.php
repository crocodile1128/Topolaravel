<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class GraphSessionController extends Controller
{
    public function index()
    {
        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);

        // $income
        // $outgo
        // Incoming Sessions
        $srcmac = [];
        $dstmac = [];
        $srcip = [];
        $dstip = [];
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
                        array_push($srcip, explode(" ", $str_sec[0])[1]);
                        // Dstip  "Client: 192.168.144.199 TCP 55426 (0 data bytes sent)"
                        array_push($dstip, explode(" ", $str_sec[1])[1]);
                    }
                }
        }
        // dd($hosts["13.35.37.66"]["OS"]);
        return view('graph.index1', array(
            'hosts' => $hosts,
            'srcip' => $srcip,
            'dstip' => $dstip
        ));
    }
}
