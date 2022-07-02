@extends('layout-signed')

@section('title', 'Customers')

@section('content')
    <div class="pb-4 text-right">
        <a href="{{ route('customers.create') }}" class="focus:outline-none text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-base px-5 py-2.5 mb-2">Create new customer</a>
    </div>

    <x-grid :grid="$grid"/>
@endsection
