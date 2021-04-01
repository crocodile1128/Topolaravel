@extends('layouts.app')

@section('content')
<div class="flex p-6">
    {{-- Tables --}}
    <style>
        body {
            font: 10pt arial;
        }
        #mynetwork {
            height: 800px;
            border: 1px solid lightgray;
        }
    </style>
    <div class="shadow overflow-hidden w-2/3 sm:rounded-lg p-4">
        <div id="mynetwork">
            <div class="vis-network" style="position: relative; overflow: hidden; touch-action: pan-y; user-select: none; width: 100%; height: 100%;">
                <canvas style="position: relative; touch-action: none; user-select: none; width: 100%; height: 100%; top: 0px; left: 0px;">
                </canvas>
            </div>
        </div>
    </div>
    {{-- Details --}}
    <div class="bg-white shadow overflow-hidden w-1/3 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ $host["IP"] }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Hosts details.
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    MAC Address
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span id="mac_details" class="ml-2 flex-1 w-0 truncate">
                                        {{ $host["MAC"] }}
                                    </span>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0 truncate">
                                        {{ $host["NIC Vender"] }}
                                    </span>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0 truncate">
                                        {{ $host["MAC Age"] }}
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        IP Address
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $host["IP"] }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Operation System
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0 truncate">
                                        {{ $host["OS"] }}
                                    </span>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0 truncate">
                                        {{ $host["OS Detail"] }}
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Host Name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $host["Host Name"] }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Other Details
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                            @foreach($host["Details"] as $detail)
                                @foreach($detail as $key=>$value)
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                    <div class="w-0 flex-1 flex items-center">
                                        <span class="ml-2 flex-1 w-0 truncate">
                                            {{ $key . ": " . $value }}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
@section('extend-js')
    <script type="text/javascript" src="/js/vis-network.min.js"></script>
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
                //dd($datas);
                foreach($hosts as $key=>$value)
                {
                    if($key != "test"){
                        //dd($value);
                        $label = $value["IP"] . '\n' . $value["Host Name"];
                        $title = $value["IP"] . '\nIncoming Sessions: ' . count($value["Incoming Sessions"]) . '\nOutgoing Sessions: ' . count($value["Outgoing Sessions"]);
                        if ($value["OS"] == "Windows")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", borderWidth: 4, image: "/img/windows.jpg", title: "' . $title . '", color:{border: "red", highlight: { border: "red"},}},');
                        else if ($value["OS"] == "Linux")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "/img/linux.jpg", title: "' . $title . '" },');
                        else if ($value["OS"] == "Android")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "/img/android.jpg", title: "' . $title . '" },');
                        else
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "/img/computer.jpg", title: "' . $title . '" },');

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
                    print ('{ id: ' . $i . ', label:"' . $label . '", shape: "image", image: "/img/switch.png", size: 40, borderWidth: 1, title: "' . $title . '", color:{border: "gray", highlight: { border: "red"},}},');
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
