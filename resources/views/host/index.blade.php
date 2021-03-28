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

@endsection
