@extends('layouts.app')

@section('content')
{{-- array:11 [▼
  "MAC" => "AC202EF945C2"
  "NIC Vender" => "Hitron Technologies. Inc"
  "MAC Age" => "1/4/2017"
  "IP" => "10.4.24.13"
  "OS" => "Unknown"
  "OS Detail" => "Unknown"
  "Host Name" => ""
  "Queried DNS" => []
  "Incoming Sessions" => []
  "Outgoing Sessions" => []
  "Details" => []
] --}}
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
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
                                <span class="ml-2 flex-1 w-0 truncate">
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
                    Operating System
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
@endsection

