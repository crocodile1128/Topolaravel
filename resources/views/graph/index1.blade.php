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
                        $label = $value["IP"] . '\n' . "test";
                        if ($value["OS"] == "Windows")
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "image", image: "img/windows.jpg" },');
                        else if ($value["OS"] == "Linux")
                            print ("{ id: " . $i . ", label:'" . $label . "', shape: 'image', image: 'img/linux.jpg' },");
                        else if ($value["OS"] == "Android")
                            print ("{ id: " . $i . ", label:'" . $label . "', shape: 'image', image: 'img/android.jpg' },");
                        else
                            print ('{ id: ' . $i . ', label:"' . $label . '", shape: "image", image: "img/computer.jpg" },');

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
                for($i=0; $i < count($srcip); $i++){
                    print ("{ from: " . $host2id[$srcip[$i]] . ", to:" . $host2id[$dstip[$i]] . ", color: { color: 'blue' } },");
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
            shape: "dot",
            scaling: {
              min: 10,
              max: 30,
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
          configure: {
            filter: function (option, path) {
              if (option === "inherit") {
                return true;
              }
              if (option === "type" && path.indexOf("smooth") !== -1) {
                return true;
              }
              if (option === "roundness") {
                return true;
              }
              if (option === "hideEdgesOnDrag") {
                return true;
              }
              if (option === "hideNodesOnDrag") {
                return true;
              }
              return false;
            },

          },
          physics: {
            stabilization: false,
            barnesHut: {
              gravitationalConstant: -8000,
              springConstant: 0.0001,
              springLength: 2,
            },
          },
        };
        var network = new vis.Network(container, data, options);
    </script>
@endsection
