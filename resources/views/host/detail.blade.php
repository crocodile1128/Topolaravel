@extends('layouts.app')

@section('content')
<div class="flex p-6">
{{-- Tables --}}
    <div class="shadow overflow-hidden w-2/3 sm:rounded-lg p-4">
        <table id="data-table2" class="bg-pink-200  col-start-3 col-end-12">
            <thead>
                <tr>
                    <th>Host</th>
                    <th>MAC Address</th>
                    <th>NIC Vender</th>
                    <th>Operating System</th>
                    <th>More Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hosts as $key=>$val)
                    @if($key!="test")
                    <tr class="hover:bg-pink-300 text-pink-700 font-semibold hover:text-white py-2 px-4 border border-pink-300 hover:border-transparent rounded">
                        <th>{{ $val["IP"] }}</th>
                        @if($val["MAC"] != "Unknown MAC")
                            <th>{{ implode(":", str_split($val["MAC"], 2)) }}</th>
                        @else
                            <th>{{ $val["MAC"] }}</th>
                        @endif
                        <th>{{ $val["NIC Vender"] }}</th>
                        <th>{{ $val["OS"] }}</th>
                        {{-- <th>{{ $val["OS Detail"] }}</th>
                        <th>
                            {{ implode(', ', $val['Queried DNS']) }}
                        </th> --}}
                        <th>
                            <button class="btn btn-blue">
                                <a href="{{ route('detail', $key) }}">Details</a>
                            </button>
                        </th>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
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
<link href="/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="/js/jquery-3.5.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready( function () {
        var table = $('#data-table2').DataTable();
        $('#data-table2 tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            //detailDisplay();
            //alert( 'You clicked on '+data[0]+'\'s row' );
        });
    } );

    // function detailDisplay() {
    //     $("#mac_details").text('OK');
    // }
</script>
@endsection
