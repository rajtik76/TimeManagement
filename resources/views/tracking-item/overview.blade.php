@extends('layout-signed')

@section('title', 'Tracking items overview')
@section('breadcrumb', 'Tracking items overview')

@section('content')
    <form method="post" action="{{ route('tracking.printable-overview') }}">
        @csrf
        <div class="mb-6">
            <label for="overview_date" class="block mb-2 text-sm font-medium text-slate-500">Date</label>
            <input datepicker datepicker-format="mm/yyyy" datepicker-autohide type="text"
                   name="overview_date"
                   id="overview_date"
                   value="{{ old('overview_date', now()->format('m/Y')) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 p-2.5" required>
            @error('overview_date')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="overview_date" class="block mb-2 text-sm font-medium text-slate-500">Customer</label>
            <select name="customer"
                    id="customer"
                    class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" required>
                @foreach($customers as $key => $value)
                    <option value="{{ $key }}" @selected(old('customer') == $key)>{{ $value }}</option>
                @endforeach
            </select>
                @error('customer')
                <div class="text-sm text-red-600">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="flex flex-row">
            <div class="grow">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center grow">
                    Submit
                </button>
            </div>
        </div>
    </form>
@endsection
