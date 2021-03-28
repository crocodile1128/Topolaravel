@extends('layouts.app')

@section('content')
    {{-- <div class="flex justify-center p-6">
        <div class="w-6/12 bg-white p-6 rounded-lg">
            Graph
        </div>
    </div> --}}
    {{-- plot network --}}
    <link rel="stylesheet" href="{{ asset("css/mynetwork.css") }}">
    <div class="flex justify-center p-6">
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
            { id: 1, label: "node\none", shape: "image", image: "img/windows.jpg" },
            { id: 2, label: "node\ntwo", shape: "image", image: "img/computer.jpg"},
            { id: 3, label: "node\nthree", shape: "image", image: "img/computer.jpg"},
            {
                id: 4,
                label: "node\nfour",
                shape: "dot",
                size: 10,
                color: "#7BE141",
            },
            { id: 5, label: "node\nfive", shape: "image", image: "img/computer.jpg"},
            { id: 6, label: "node\nsix", shape: "image", image: "img/linux.jpg"},
            { id: 7, label: "node\nseven", shape: "image", image: "img/computer.jpg"},
            {
                id: 8,
                label: "node\neight",
                shape: "triangleDown",
                color: "#6E6EFD",
            },
        ]);

        // create an array with edges
        var edges = new vis.DataSet([
            { from: 1, to: 8, color: { color: "red" } },
            { from: 1, to: 3, color: "rgb(20,24,200)" },
            {
                from: 1,
                to: 2,
                color: { color: "rgba(30,30,30,0.2)", highlight: "blue" },
            },
            { from: 2, to: 4, color: { inherit: "to" } },
            { from: 2, to: 5, color: { inherit: "from" } },
            { from: 5, to: 6, color: { inherit: "both" } },
            { from: 6, to: 7, color: { color: "#ff0000", opacity: 0.3 } },
            { from: 6, to: 8, color: { opacity: 0.3 } },
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
