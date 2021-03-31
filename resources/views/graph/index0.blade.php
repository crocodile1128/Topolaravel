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
                $i = 0;
                $host2id = [];
                $host = [];
                $id = [];
                foreach($hosts as $key=>$value)
                {
                    if($key != "test"){
                        //dd($value);
                        $label = $value["IP"] . '\n' . $value["Host Name"];
                        $title = "I have a popup!";
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
                for($j=0; $j<count($devices); $j++)
                {
                    // $string = "002590733014";
                    // $result = implode(":", str_split($string, 2));
                    // dd($result);
                    $label = implode(":", str_split($devices[$j], 2)) . '\n' . $venders[$j] . '\n' . $ages[$j];
                    print ('{ id: ' . $i . ', label:"' . $label . '", shape: "circularImage", image: "img/switch.png" },');
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
                            $title = "test";
                            $thick = 2;
                            if ($host["MAC"] == $devices[$i]) {
                                print ("{ from: " . $host2id[$devices[$i] . "_"] . ", to:" . $host2id[$host["IP"]] . ", value: " . $thick . ", title: '" . $title . "'},");
                                break;
                            }
                        }
                    }
                }

                $thick = 3;
                foreach($device_conn as $conn) {
                    $devices = explode('_', $conn);
                    print ("{ from: " . $host2id[$devices[0] . "_"] . ", to:" . $host2id[$devices[1]. "_"] . ", value: " . $thick . ", title: '" . $title . "'},");
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
            borderWidth: 4,
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
    </script>
@endsection
