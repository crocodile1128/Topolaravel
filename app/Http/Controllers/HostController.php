<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // foreach($hosts as $key=>$val)
        //     dd($val['Queried DNS']);
        return view('host.index', array('hosts' => $hosts));
    }
}
