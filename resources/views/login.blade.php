@extends('layout')

@section('title', 'Login')

@section('root-content')
    <div class="flex h-screen justify-center items-center">
        <div class="border-solid border-4 border-blue-600/50 rounded-lg p-6 bg-slate-50 text-sm">
            <form method="post" action="{{ route('login') }}">
                @csrf
                <label class="block">
                    <span class="text-center block font-medium text-slate-700">Username</span>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full px-4 py-2 bg-white border border-slate-300 rounded-md shadow-sm placeholder-slate-400
                    focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
                    invalid:border-pink-500 invalid:text-pink-600
                    focus:invalid:border-pink-500 focus:invalid:ring-pink-500"/>
                </label>
                @error('email')
                <div class="text-sm text-red-500 pt-2">
                    {{ $message }}
                </div>
                @enderror
                <label class="block pt-4">
                    <span class="text-center block font-medium text-slate-700">Password</span>
                    <input type="password" name="password" class="mt-1 block w-full px-4 py-2 bg-white border border-slate-300 rounded-md shadow-sm placeholder-slate-400
                    focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500"/>
                </label>
                @error('password')
                <div class="text-sm text-red-500 pt-2">
                    {{ $message }}
                </div>
                @enderror
                <div class="text-center pt-6">
                    <button class="bg-violet-400 text-white hover:bg-violet-600 hover:text-white p-2 px-8 rounded-md mt-2 sm:text-sm">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
