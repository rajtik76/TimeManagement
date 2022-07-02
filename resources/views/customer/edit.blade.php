@extends('layout-signed')

@section('title', 'Customers edit')

@section('breadcrumb', 'Customer edit')

@section('content')
    <form method="post" action="{{ route(isset($newItemFlag) ? 'customers.store' : 'customers.update', $customer->id) }}" id="customer-edit-form">
        @csrf
        @if(!isset($newItemFlag))
            @method('PUT')
            <div class="mb-6">
                <label for="customer_name" class="block mb-2 text-sm font-medium text-slate-500">Task ID</label>
                <span id="customer_name"
                      value=""
                      class="border border-slate-300 text-slate-500 text-sm rounded-lg block w-24 p-2.5">
                {{ $customer->id }}
            </span>
            </div>
        @endif

        <div class="mb-6">
            <label for="customer_name" class="block mb-2 text-sm font-medium text-slate-500">Customer name</label>
            <input type="text"
                   name="customer_name"
                   id="customer_name"
                   value="{{ old('customer_name', $customer->name) }}"
                   class="border border-slate-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            @error('customer_name')
            <div class="text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="flex flex-row">
            <div class="grow">
                <button type="submit" form="customer-edit-form" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center grow">
                    Submit
                </button>
            </div>
            @if(!isset($newItemFlag))
                <div>
                    <button type="submit" form="task-delete-form" onclick="return confirm('Are you sure ?');" class="text-white bg-red-600 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Delete task</button>
                </div>
            @endif
        </div>
    </form>
@endsection
