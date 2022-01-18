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
                                    <span id="mac_details" class="ml-2 flex-1 w-0">
                                        {{ $host["MAC"] }}
                                    </span>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0">
                                        {{ $host["NIC Vender"] }}
                                    </span>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0">
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
                                    <span class="ml-2 flex-1 w-0">
                                        {{ $host["OS"] }}
                                    </span>
                                </div>
                            </li>
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0">
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
                        Open Tcp Ports
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $host["Open Tcp Ports"] }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Network Service List
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                            @foreach($host["Net Meta"] as $detail)
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0">
                                        {{ $detail }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
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
                                        <span class="ml-2 flex-1 w-0">
                                            {{ $key . ": " . $value }}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Sqlite3
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                            @foreach($sqls as $sql)
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <span class="ml-2 flex-1 w-0">
                                        {{ $sql[0] . ':' . $sql[1] }}
                                    </span>
                                </div>
                            </li>
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
                $collect = [];
                foreach($hosts as $key=>$value)
                {
                    $label = '';
                    foreach($labels as $l) {
                        if ($l=="Incoming Sessions" || $l=="Outgoing Sessions") {
                            $label .= $l . ':' . count($value[$l]) . '\n';
                        }
                        else {
                            if (gettype($value[$l]) == 'string')
                                $label .= $l . ': ' . $value[$l] . '\n';
                        } // end if
                    } // end foreach

                    $title = '';
                    foreach($titles as $l) {
                        if ($l=="Incoming Sessions" || $l=="Outgoing Sessions") {
                            $title .= $l . ':' . count($value[$l]) . '\n';
                        }
                        else {
                            if (gettype($value[$l]) == 'string')
                                $title .= $l . ': ' . $value[$l] . '\n';
                        } // end if
                    } // end foreach

                    print ('{ id: ' . $key . ', label:"' . $label . '", title: "' . $title . '", shape: "circularImage",');

                    if ($value["Icon"] != "null")
                        print ('image: "' . str_replace("\\", "\/" , $value["Icon"]) . '"},');
                    else
                        if ($value["OS"] == "Windows")
                            print ('image: "/img/windows.jpg"},');
                        else if ($value["OS"] == "Linux")
                            print ('image: "/img/linux.jpg" },');
                        else if ($value["OS"] == "Android")
                            print ('image: "/img/android.jpg" },');
                        else {
                            if ($value["Open Tcp Ports"] == "80" || $value["Open Tcp Ports"] == "443")
                                print ('image: "/img/webserver.png" },');
                            else if ($value["Open Tcp Ports"] == "21")
                                print ('image: "/img/ftp.png" },');
                            else if ($value["Open Tcp Ports"] == "25")
                                print ('image: "/img/mail.png" },');
                            else if ($value["Open Tcp Ports"] == "53")
                                print ('image: "/img/dns.png" },');
                            else
                                print ('image: "/img/computer.jpg"},');
                        }

                    $collect[$value["IP"]] = $key;
                }
            ?>
        ]);
        // create an array with edges
        var edges = new vis.DataSet([
            <?php
                for($i=0; $i < count($conn); $i++){
                    $ips = explode('_', $conn[$i]);
                    $thick = $count[$i];
                    $title = $count[$i] . " Sessions";
                    print ("{ from: " . $collect[$ips[0]] . ", to:" . $collect[$ips[1]] . ", value: " . $thick . ", title: '" . $title .  "', color: { color: 'rgba(30,30,30,0.2)', highlight: 'purple' }},");
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
            size: 16,
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
            smooth: false
          },
          interaction: {
            hideEdgesOnDrag: true,
            tooltipDelay: 200,
          },
        //   physics: {
        //     forceAtlas2Based: {
        //       gravitationalConstant: -26,
        //       centralGravity: 0.005,
        //       springLength: 230,
        //       springConstant: 0.18,
        //     },
        //     maxVelocity: 146,
        //     solver: "forceAtlas2Based",
        //     timestep: 0.35,
        //     stabilization: { iterations: 150 },
        //   },
          physics: {
            stabilization: false,
            maxVelocity: 100,
            solver: "forceAtlas2Based",
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
