<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HostController extends Controller
{
    public function __construct()
    {

    }
    public function get_hosts()
    {
        $json_path = env('JSON_PATH');
        $json = file_get_contents($json_path);
        $hosts = json_decode($json, true);
        return $hosts;
    }

    public function get_sql3()
    {
        $csv_path = env('CSV_PATH');
        $first = 1;
        $sqls = [];
        if (($handle = fopen($csv_path, "r")) != FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) != FALSE) {
                if ($first == 1) {
                    $first = 0;
                    continue;
                } // end if
                array_push($sqls, $data);
            } // end while
        } // end if
        return $sqls;
    }

    public function sql_relate($string) {
        $sqls = $this->get_sql3();
        $sql_relate = [];
        foreach($sqls as $sql) {
            for ($i=0; $i<5; $i++) {
                if (str_contains($sql[$i], $string)) {
                    array_push($sql_relate, $sql);
                } // end if
            } // end for
        } // end foreach
        return $sql_relate;
    }

    public function index()
    {
        $hosts = $this->get_hosts();
        $sql_relate = $this->sql_relate($hosts['0']['IP']);
        return view('host.index', array(
            'host' =>$hosts["0"],
            'hosts' => $hosts,
            'sqls' => $sql_relate
        ));
    }

    public function show()
    {
        $hosts = $this->get_hosts();
        $sql_relate = $this->sql_relate($hosts['0']['IP']);
        return view('host.index', array(
            'host' =>$hosts["0"],
            'hosts' => $hosts,
            'sqls' => $sql_relate
        ));
    }

    public function detail(Request $request, $host)
    {
        $hosts = $this->get_hosts();
        $sql_relate = $this->sql_relate($hosts[$host]['IP']);
        return view('host.detail', array(
            'host' =>$hosts[$host],
            'hosts' => $hosts,
            'sqls' => $sql_relate
        ));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
		]);

        $fileName = 'hosts.json';

        request()->file->move(public_path('files'), $fileName);

        return redirect()->route('host');
    }
}
