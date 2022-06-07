@extends('layout')

@section('root-content')
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @includeIf('menu', [auth()])
    <div class="px-4 py-6">
        @yield('content')
    </div>
@endsection
