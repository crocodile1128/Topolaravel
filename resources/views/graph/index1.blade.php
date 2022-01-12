@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/graph-search.css">
    {{-- <div class="flex justify-center p-6">
        <div class="w-6/12 bg-white p-6 rounded-lg">
            Graph
        </div>
    </div> --}}
    {{-- plot network --}}
    {{-- <div class="flex flex-end shadow p-4">
        <form class="shadow p-4 flex flex-end" action="">
            <input class="w-full rounded p-2" type="text" placeholder="Search...">
            <button class="bg-blue hover:bg-red-lighter rounded text-white p-2 pl-4 pr-4">
                <p class="font-semibold text-xl">Search</p>
            </button>
        </form>
    </div> --}}

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
                $i = 0;
                $host2id = [];
                $host = [];
                $id = [];
                foreach($hosts as $key=>$value)
                {
                    if($key != "test"){
                        //dd($value);
                        $label = $value["IP"] . '\n' . $value["Host Name"];
                        $title = $value["IP"] . '\nIncoming Sessions: ' . count($value["Incoming Sessions"]) . '\nOutgoing Sessions: ' . count($value["Outgoing Sessions"]);
                        if ($value["OS"] == "Windows")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "img/windows.jpg", title: "' . $title . '" },');
                        else if ($value["OS"] == "Linux")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "img/linux.jpg", title: "' . $title . '" },');
                        else if ($value["OS"] == "Android")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "img/android.jpg", title: "' . $title . '" },');
                        else
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "img/computer.jpg", title: "' . $title . '" },');

                        array_push($host, $value["IP"]);
                        $i++;
                    }
                }
                $host2id = array_flip($host);
                //dd($host2id);
            ?>
        ]);
        // create an array with edges
        var edges = new vis.DataSet([
            <?php
                for($i=0; $i < count($conn); $i++){
                    $ips = explode('_', $conn[$i]);
                    $thick = $count[$i];
                    $title = $count[$i] . " Sessions";
                    print ("{ from: " . $host2id[$ips[0]] . ", to:" . $host2id[$ips[1]] . ", value: " . $thick . ", title: '" . $title .  "', color: { color: 'rgba(30,30,30,0.2)', highlight: 'purple' }},");
                }
            ?>
        ]);

        // create a network
        var container = document.getElementById("mynetwork");
        var data = {
            nodes: nodes,
            edges: edges,
        };
        // var options = {
        //     nodes: {
        //         shape: "circle",
        //         font: {
        //             size: 12,
        //             color: "#000000",
        //         },
        //     },
        //     physics: {
        //         enabled: false
        //     }
        // };

        var options = {
            nodes: {
                borderWidth: 2,
                borderWidthSelected: 8,
                size: 30,
                color: {
                    border: "#222222"
                },
                shape: "dot",
                scaling: {
                min: 8,
                max: 20,
                },
                font: {
                size: 12,
                face: "Tahoma",
                },
            },
            edges: {
                color: { inherit: true },
                width: 0.15,
                smooth: {
                type: "continuous",
                },
            },
            interaction: {
                hideEdgesOnDrag: true,
                tooltipDelay: 200,
            },

            physics: {
                stabilization: false,
                barnesHut: {
                gravitationalConstant: -8000,
                springConstant: 0.0001,
                springLength: 1,
                },
            },
        };
        var network = new vis.Network(container, data, options);
        network.on("doubleClick", function (params) {
            window.location.href = '/graph1/' + params['nodes'];
        });
    </script>
@endsection
