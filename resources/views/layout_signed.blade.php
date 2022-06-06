@extends('layout')

@section('root-content')
    @includeIf('menu', [auth()])
    <div class="p-4">
        @yield('content')
    </div>
@endsection
