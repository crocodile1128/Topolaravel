@extends('layouts.app')

@section('content')
    {{-- <div class="flex justify-center p-6">
        <div class="w-6/12 bg-white p-6 rounded-lg">
            Graph
        </div>
    </div> --}}

    {{-- <div class="flex flex-end shadow p-4">
        <form class="shadow p-4 flex flex-end" action="">
            <input class="w-full rounded p-2" type="text" placeholder="Search...">
            <button class="bg-blue hover:bg-red-lighter rounded text-white p-2 pl-4 pr-4">
                <p class="font-semibold text-xl">Search</p>
            </button>
        </form>
    </div> --}}

    {{-- plot network --}}
    {{-- <link rel="stylesheet" href="{{ asset("css/mynetwork.css") }}"> --}}
    <style>
        body {
            font: 10pt arial;
        }
        #mynetwork {
            height: 800px;
            border: 1px solid lightgray;
        }
    </style>
<div class="flex p-6">
    <div class="shadow overflow-hidden w-2/3 sm:rounded-lg p-4 bg-gray-100">
    {{-- <div class="flex justify-center p-4"> --}}
        <div id="mynetwork">
            <div class="vis-network" style="position: relative; overflow: hidden; touch-action: pan-y; user-select: none; width: 100%; height: 100%;">
                <canvas style="position: relative; touch-action: none; user-select: none; width: 100%; height: 100%; top: 0px; left: 0px;" >
                </canvas>
            </div>
        </div>
    </div>
    <div class="bg-white shadow overflow-hidden w-1/3 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <form action="{{ route("search0") }}" method="post">
                @csrf
                <div class="p-8">
                    <div class="flex rounded-lg bg-white shadow p-4">
                        <input class="w-full py-4 px-6 text-gray-700 leading-tight focus:outline-none" id="search" name="search" type="text" placeholder="Ip/Mac/Domain/Os...">
                        <button type="submit" class="bg-green-500 hover:bg-green-400 rounded-lg text-white p-2 pl-4 pr-4">
                            <p class="font-semibold text-xs">Search</p>
                        </button>
                    </div>
                </div>
            </form>
            <form action="{{ route("detail0") }}" method="post">
                @csrf
                <div class="block">
                    <span class="text-gray-700">Details to show</span>
                    <div class="mt-2">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="IP">
                                <span class="ml-2">IP Address</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="MAC">
                                <span class="ml-2">MAC Address</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="NIC Vender">
                                <span class="ml-2">NIC Vender</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="MAC Age">
                                <span class="ml-2">MAC Age</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="OS">
                                <span class="ml-2">Operating System</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="Host Name">
                                <span class="ml-2">Host Name</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="Details">
                                <span class="ml-2">Other Details</span>
                            </label>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-400 rounded-lg text-white p-2 pl-4 pr-4">
                            <p class="font-semibold text-xs">Apply</p>
                        </button>
                    </div>
                </div>
            </form>
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
                $hosts = $datas["hosts"];
                $devices = $datas["devices"];
                $venders = $datas["venders"];
                $ages = $datas["ages"];
                $device_conn = $datas["device_conn"];
                $device_count = $datas["device_count"];
                $i = 0;
                $host2id = [];
                $host = [];
                $id = [];
                foreach($hosts as $key=>$value)
                {
                    if($key != "test"){
                        //dd($value);
                        $label = '';
                        foreach($labels as $l) $label .= $l . ':' . $value[$l] . '\n';
                        $title = '';
                        foreach($titles as $t) $title .= $t . ':' . $value[$t] . '\n';
                        if ($value["OS"] == "Windows")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", borderWidth: 4, image: "img/windows.jpg", title: "' . $title . '", color:{border: "red", highlight: { border: "red"},}},');
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
                for($j=0; $j<count($devices); $j++)
                {
                    // $string = "002590733014";
                    // $result = implode(":", str_split($string, 2));
                    // dd($result);
                    $label = implode(":", str_split($devices[$j], 2)) . '\n' . $venders[$j] . '\n' . $ages[$j];
                    $title = implode(":", str_split($devices[$j], 2)) . '\n' . $venders[$j] . '\n' . $ages[$j];
                    print ('{ id: ' . $i . ', label:"' . $label . '", shape: "image", image: "img/switch.png", size: 40, borderWidth: 1, title: "' . $title . '", color:{border: "gray", highlight: { border: "red"},}},');
                    // if (!is_string($device))
                    array_push($host, $devices[$j] . "_");
                    $i++;
                }
                $host2id = array_flip($host);
            ?>
        ]);
        // create an array with edges
        var edges = new vis.DataSet([
            <?php
                foreach($hosts as $key=>$host) {
                    if($key!="test"){
                        for($i=0; $i < count($devices); $i++){
                            $title = "";
                            $thick = 2;
                            if ($host["MAC"] == $devices[$i]) {
                                print ("{ from: " . $host2id[$devices[$i] . "_"] . ", to:" . $host2id[$host["IP"]] . ", value: " . $thick . ", title: '" . $title . "', color: { color: 'rgba(30,30,30,0.2)', highlight: 'purple' }},");
                                break;
                            }
                        }
                    }
                }

                for($i=0; $i<count($device_conn); $i++) {
                    $thick = $device_count[$i];
                    $title = $device_count[$i];
                    $devices = explode('_', $device_conn[$i]);
                    print ("{ from: " . $host2id[$devices[0] . "_"] . ", to:" . $host2id[$devices[1]. "_"] . ", value: " . $thick . ", title: '" . $title .  "', color: { color: 'rgba(30,30,30,0.2)', highlight: 'purple' }},");
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
            borderWidth: 2,
            borderWidthSelected: 8,
            size: 24,
            color: {
              border: "black",
              background: "white",
              highlight: {
                border: "purple",
                background: "white",
              },
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
            shapeProperties: {
                useBorderWithImage: true,
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
            hideEdgesOnDrag: false,
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
            window.location.href = '/graph0/' + params['nodes'];
        });
    </script>
@endsection
