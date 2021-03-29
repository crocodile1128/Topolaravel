@extends('layouts.app')

@section('content')
    {{-- <div class="flex justify-center p-6">
        <div class="w-6/12 bg-white p-6 rounded-lg">
            Graph
        </div>
    </div> --}}
    {{-- plot network --}}
    <link rel="stylesheet" href="{{ asset("css/mynetwork.css") }}">
    <div class="flex justify-center">
        <div id="mynetwork">
            <div class="vis-network" style="position: relative; overflow: hidden; touch-action: pan-y; user-select: none; width: 100%; height: 100%;">
                <canvas style="position: relative; touch-action: none; user-select: none; width: 100%; height: 100%; top: 0px; left: 0px;" >
                </canvas>
            </div>
        </div>
    </div>
@endsection
@section('extend-js')
    <script type="text/javascript" src="js/vis-network.min.js"></script>
    <script>
        // create an array with nodes
        var nodes = new vis.DataSet([
            <?php
                for($i=0; $i < count($srcip); $i++){
                    // Windows
                    if ($hosts[$srcip[$i]]["OS"] == "Windows")
                        print ("{ id: " . $i . ", label:'" . $srcip[$i] . "', shape: 'image', image: 'img/windows.jpg' },");
                    // Linux
                    else if ($hosts[$srcip[$i]]["OS"] == "Linux")
                        print ("{ id: " . $i . ", label:'" . $srcip[$i] . "', shape: 'image', image: 'img/linux.jpg' },");
                    // Android
                    else if ($hosts[$srcip[$i]]["OS"] == "Linux")
                        print ("{ id: " . $i . ", label:'" . $srcip[$i] . "', shape: 'image', image: 'img/android.jpg' },");
                    // Unknown
                    else
                        print ("{ id: " . $i . ", label:'" . $srcip[$i] . "', shape: 'image', image: 'img/computer.jpg' },");
                }
                $j = $i;

                for($i = 0; $i < count($dstip); $i++){
                    // Windows
                    // dd($hosts);
                    if ($hosts[$dstip[$i]]["OS"] == "Windows")
                        print ("{ id: " . $i+$j . ", label:'" . $dstip[$i] . "', shape: 'image', image: 'img/windows.jpg' },");
                    // Linux
                    else if ($hosts[$dstip[$i]]["OS"] == "Linux")
                        print ("{ id: " . $i+$j . ", label:'" . $dstip[$i] . "', shape: 'image', image: 'img/linux.jpg' },");
                    // Android
                    else if ($hosts[$dstip[$i]]["OS"] == "Linux")
                        print ("{ id: " . $i+$j . ", label:'" . $dstip[$i] . "', shape: 'image', image: 'img/android.jpg' },");
                    // Unknown
                    else
                        print ("{ id: " . $i+$j . ", label:'" . $dstip[$i] . "', shape: 'image', image: 'img/computer.jpg' },");
                }
            ?>
        ]);
        // create an array with edges
        var edges = new vis.DataSet([
            <?php
                for($i=0; $i < count($srcip); $i++){
                    print ("{ from: " . $i . ", to:" . $i+8 . ", color: { color: 'blue' } },");
                }
            ?>
        ]);

        // create a network
        var container = document.getElementById("mynetwork");
        var data = {
            nodes: nodes,
            edges: edges,
        };
        var options = {
            nodes: {
                shape: "circle",
                font: {
                    size: 12,
                    color: "#000000",
                },
            },
        };
        var network = new vis.Network(container, data, options);
    </script>
@endsection
