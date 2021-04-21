@extends('layouts.app')

@section('content')
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
            <form action="{{ route("search") }}" method="post">
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
                    <span style="font-weight:bold" class="text-gray-700">Details to show</span>
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
                                <input type="checkbox" name="select_item[]" value="OS Detail">
                                <span class="ml-2">OS Details</span>
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
                                <input type="checkbox" name="select_item[]" value="Open Tcp Ports">
                                <span class="ml-2">Open Tcp Ports</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="Incoming Sessions">
                                <span class="ml-2">Incoming Session Count</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="Outgoing Sessions">
                                <span class="ml-2">Outgoing Session Count</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="select_item[]" value="Sqlite">
                                <span class="ml-2">Sqlite Details</span>
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
    <script type="text/javascript" src="/js/vis-network.min.js"></script>
    <script>
        // create an array with nodes

        var nodes = new vis.DataSet([
            <?php
                $devices = $datas["devices"];
                $venders = $datas["venders"];
                $ages = $datas["ages"];
                $device_conn = $datas["device_conn"];
                $device_count = $datas["device_count"];
                $host2id = [];
                $id = [];
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
                            else if (gettype($value[$l]) == 'array') {
                                $result = '';
                                if ($l == 'Sqlite') {
                                    if ($value[$l] != null) {
                                        foreach($value[$l] as $idx=>$detail) {
                                            $result .= $detail[0] . '.';
                                        } // end foreach
                                    } // end if
                                } // end if
                                $label .= $l . ':' . $result . '\n';
                            } // end if
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
                            else if (gettype($value[$l]) == 'array') {
                                $result = '';
                                if ($l == 'Sqlite') {
                                    if ($value[$l] != null) {
                                        foreach($value[$l] as $idx=>$detail) {
                                            $result .= $detail[0] . '.';
                                        } // end foreach
                                    } // end if
                                } // end if
                                $title .= $l . ':' . $result . '\n';
                            } // end if
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
                    $host2id[$value["IP"]] = $key;
                }
                for($j=0; $j<count($devices); $j++)
                {
                    if ($devices[$j] != "Unknown MAC")
                        $mac = implode(":", str_split($devices[$j], 2)); // $string = "002590733014";$result = implode(":", str_split($string, 2));
                    else
                        $mac = $devices[$j];
                    $label = $mac . '\n' . $venders[$j] . '\n' . $ages[$j];
                    $title = $mac . '\n' . $venders[$j] . '\n' . $ages[$j];
                    $idx = $hcount + $j;
                    print ('{ id: ' . $idx . ', label:"' . $label . '", shape: "image", image: "/img/network_socket.png", title: "' . $title . '", color:{border: "gray", highlight: { border: "gray"},}},');
                    // if (!is_string($device))
                    $host2id[$devices[$j] . "_"]=$idx;
                }
            ?>
        ]);
        // create an array with edges
        var edges = new vis.DataSet([
            <?php
                foreach($hosts as $key=>$host) {
                    for($i=0; $i < count($devices); $i++){
                        $title = "";
                        $thick = 2;
                        if ($host["MAC"] == $devices[$i]) {
                            print ("{ from: " . $host2id[$devices[$i] . "_"] . ", to:" . $host2id[$host["IP"]] . ", value: " . $thick . ", title: '" . $title . "', color: { color: 'rgba(30,30,30,0.2)', highlight: 'purple' }},");
                            break;
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
            smooth: false
          },
          interaction: {
            hideEdgesOnDrag: true,
            tooltipDelay: 200,
          },

          physics: {
            stabilization: false,

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
