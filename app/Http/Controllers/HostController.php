<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        return view('host.index');
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
        dd((json_decode($json, true)));
        return view('host.index');
    }
}
