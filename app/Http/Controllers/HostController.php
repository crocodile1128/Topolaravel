<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HostController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $json_path = env('JSON_PATH');
        $json = file_get_contents($json_path);
        $hosts = json_decode($json, true);
        // $hosts = [];
        return view('host.index', array(
            'host' =>$hosts["0"],
            'hosts' => $hosts
        ));
    }

    public function show()
    {
        // "/NetworkMiner/NetworkMiner/bin/Release/hosts.json"
        $json_path = env('JSON_PATH');
        $json = file_get_contents($json_path);
        $hosts = json_decode($json, true);
        return view('host.index', array(
            'host' =>$hosts["0"],
            'hosts' => $hosts
        ));
    }

    public function detail(Request $request, $host)
    {
        $json_path = env('JSON_PATH');
        $json = file_get_contents($json_path);
        $hosts = json_decode($json, true);
        return view('host.detail', array(
            'host' =>$hosts[$host],
            'hosts' => $hosts
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
