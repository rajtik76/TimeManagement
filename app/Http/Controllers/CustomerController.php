<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\Grid\Column;
use App\Services\Grid\ColumnAction;
use App\Services\Grid\ColumnSortOrder;
use App\Services\Grid\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Html\Elements\A;
use Spatie\Html\Elements\Button;

class CustomerController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $grid = new Grid();
        $grid->setBuilder(Customer::query()->withCount('tasks'))
            ->setColumn((new Column('name', 'Name'))->setSortable(true)->setDefaultSortOrder(ColumnSortOrder::ASC))
            ->setColumn(new Column('tasks_count', 'Tasks count'))
            ->setAction(new ColumnAction('edit', fn($data) => A::create()->href(route('customers.edit', $data->id))->target('_blank')->class('font-bold text-white bg-blue-500 py-1.5 px-4 rounded')->text('Edit')))
            ->setAction(new ColumnAction('delete', fn($data) => html()
                    ->form('DELETE', route('customers.destroy', $data->id))
                    ->id('delete-form-' . $data->id)
                    ->toHtml() .
                Button::create()
                    ->type('submit')
                    ->class('font-bold text-white bg-red-500 py-1 px-4 rounded')
                    ->text('Delete')
                    ->attributes(['onclick' => 'return confirm("Are you sure ?");', 'form' => 'delete-form-' . $data->id])
                    ->toHtml()));

        return view('customer.index', compact('grid'));
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
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('customer.edit', ['customer' => Customer::find($id)]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $attributes = $request->validate([
            'customer_name' => [
                'required',
                'string',
                Rule::unique('customers', 'name')->ignore($id)
            ]
        ]);

        $customer = Customer::find($id);
        $customer->name = $attributes['customer_name'];
        $customer->save();

        return to_route('customers.index')->with('success', "Customer `{$customer->name}` was successfully updated");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $customer = Customer::find($id);
        $customer->delete();

        return to_route('customers.index')->with('success', "Customer `{$customer->name}` was successfully deleted");
    }
}
