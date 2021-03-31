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
        $hosts = [];
        return view('host.index', array('hosts' => $hosts));
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

    public function show()
    {

        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);
        // dd($hosts);
        return view('host.index', array('hosts' => $hosts));
    }

    public function detail(Request $request, $host)
    {
        $json = file_get_contents('files/hosts.json');
        $hosts = json_decode($json, true);
        return view('host.detail', array(
            'host' =>$hosts[$host],
        ));
    }
}
