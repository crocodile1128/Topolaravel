@extends('layouts.app')

@section('content')
    {{-- <div class="flex justify-start p-6">
        <div class="w-6/12 bg-white rounded-lg p-6">
            Host
        </div>
    </div> --}}
    <div row class="flex justify-start p-6">
        <div class="px-4">
            <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
                @csrf
                <input name="file" id="poster" type="file" class="form-control">
                <input type="submit"  value="Submit" class="p-6 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            </form>
        </div>
        <div class="px-4">
            <form method="post" action="{{ route('show') }}" enctype="multipart/form-data">
                @csrf
                <input type="submit"  value="Show" class="p-6 bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded active:bg-green-700">
            </form>
        </div>
    </div>

    <div row class="flex justify-center p-6">
        <table id="data-table" class="bg-green-300">
            <thead>
                <tr>
                    <th>Host</th>
                    <th>MAC Address</th>
                    <th>NIC Vender</th>
                    <th>Operating System</th>
                    <th>OS Detail</th>
                    <th>Queried DNS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hosts as $key=>$val)
                    @if($key!="test")
                    <tr class="hover:bg-green-300 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-300 hover:border-transparent rounded">
                        <th>{{ $val["IP"] }}</th>
                        <th>{{ $val["MAC"] }}</th>
                        <th>{{ $val["NIC Vender"] }}</th>
                        <th>{{ $val["OS"] }}</th>
                        <th>{{ $val["OS Detail"] }}</th>
                        {{-- queried dns --}}
                        <th>
                            {{ implode(", ", $val['Queried DNS']) }}
                        </th>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('extend-js')
<link href="css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="js/jquery-3.5.1.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#data-table').DataTable();
    } );
</script>
@endsection
