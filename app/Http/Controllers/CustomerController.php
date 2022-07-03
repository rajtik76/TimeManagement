<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\GridInstancesForControllers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class CustomerController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('customer.index', ['grid' => GridInstancesForControllers::customerControllerIndex(Customer::query()->withCount('tasks'))]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('customer.create', ['customer' => new Customer(), 'newItemFlag' => true]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'customer_name' => [
                'required',
                'string',
                Rule::unique('customers', 'name')
            ]
        ]);

        $customer = new Customer();
        $customer->name = $attributes['customer_name'];
        $customer->save();

        return to_route('customers.index')->with('success', "Customer `{$customer->name}` was successfully created");
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('customer.edit', ['customer' => Customer::find($id)]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $attributes = $request->validate([
            'customer_name' => [
                'required',
                'string',
                Rule::unique('customers', 'name')->ignore($id)
            ]
        ]);

        if ($customer = Customer::find($id)) {
            $customer->name = $attributes['customer_name'];
            $customer->save();
        } else {
            throw new InvalidArgumentException('Missing customer');
        }

        return to_route('customers.index')->with('success', "Customer `{$customer->name}` was successfully updated");
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if ($customer = Customer::find($id)) {
            $customer->delete();
        } else {
            throw new InvalidArgumentException("Missing customer");
        }

        return to_route('customers.index')->with('success', "Customer `{$customer->name}` was successfully deleted");
    }
}
