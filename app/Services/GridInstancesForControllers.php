<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Customer;
use App\Services\Grid\Column;
use App\Services\Grid\ColumnAction;
use App\Services\Grid\ColumnSortOrder;
use App\Services\Grid\Grid;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Html\Elements\A;
use Spatie\Html\Elements\Button;

class GridInstancesForControllers
{
    /**
     * @param Builder $builder
     * @return Grid
     */
    public static function taskControllerIndex(Builder $builder): Grid
    {
        /** @var array<int, string> $customers */
        $customers = Customer::pluck('name', 'id')->toArray();

        return (new Grid())
            ->setBuilder($builder)
            ->setConditionalRowClass(fn($data) => $data->is_active == 0 ? 'bg-red-200' : '')
            ->addColumn(
                (new Column('customer_id', 'Customer'))
                    ->sortable(rawColumn: 'customers.name')
                    ->filterable($customers)
                    ->setRenderWrapper(fn($data) => $data->customer->name)
            )
            ->addColumn(
                (new Column('name', 'Task name'))
                    ->sortable()
                    ->setRenderWrapper(fn($data) => $data->task_url
                        ? A::create()
                            ->href($data->task_url)
                            ->target('_blank')
                            ->class('font-medium hover:underline text-blue-500')
                            ->text($data->task_name)
                            ->toHtml()
                        : $data->task_name))
            ->addColumn(
                (new Column('is_active', 'Active'))
                    ->sortable()
                    ->setRenderWrapper(fn($data) => $data->is_active ? 'Yes' : 'No')
                    ->filterable([0 => 'No', 1 => 'Yes'], 1)
            )
            ->addColumn(
                (new Column('tracking_items_sum_item_hours', 'Hours'))
                    ->sortable()
                    ->setRenderWrapper(fn($data) => A::create()->href(route('task.tracking', $data->id))->attribute('target', '_blank')->class('font-medium hover:underline text-blue-500')->text($data->tracking_items_sum_item_hours ?? '0.0'))
            )
            ->addColumn((new Column('task_notes', 'Task notes'))->sortable())
            ->addColumn((new Column('created_at', 'Created'))->sortable(ColumnSortOrder::DESC))
            ->addAction(new ColumnAction('edit', fn($data) => self::getEditAnchorTag(route('task.edit', $data->id))));
    }

    /**
     * @param Builder $builder
     * @return Grid
     */
    public static function taskControllerTrackingTimeIndex(Builder $builder): Grid
    {
        return (new Grid())
            ->setBuilder($builder)
            ->addColumn((new Column('item_date', 'Date'))->sortable(ColumnSortOrder::DESC))
            ->addColumn((new Column('item_hours', 'Time spent'))->sortable())
            ->addColumn(new Column('item_note', 'Note'))
            ->addColumn((new Column('updated_at', 'Updated'))->sortable())
            ->addAction(new ColumnAction('edit', fn($data) => self::getEditAnchorTag(route('tracking.edit', $data->id))))
            ->addAction(new ColumnAction('delete', fn($data) => self::getDeleteFormWithButton((int)$data->id, route('tracking.destroy', $data->id))));
    }

    /**
     * @param Builder $builder
     * @return Grid
     */
    public static function customerControllerIndex(Builder $builder): Grid
    {
        return (new Grid())
            ->setBuilder($builder)
            ->addColumn((new Column('name', 'Name'))->sortable(ColumnSortOrder::ASC))
            ->addColumn(new Column('tasks_count', 'Tasks count'))
            ->addAction(new ColumnAction('edit', fn($data) => self::getEditAnchorTag(route('customers.edit', $data->id))))
            ->addAction(new ColumnAction('delete', fn($data) => self::getDeleteFormWithButton((int)$data->id, route('customers.destroy', $data->id))));
    }

    /**
     * @param string $route
     * @return string
     */
    private static function getEditAnchorTag(string $route): string
    {
        return A::create()->href($route)->class('font-bold text-white bg-blue-500 py-1.5 px-4 rounded')->text('Edit')->toHtml();
    }

    /**
     * @param int $id
     * @param string $route
     * @return string
     */
    private static function getDeleteFormWithButton(int $id, string $route): string
    {
        $form = html()->form('DELETE', $route)->id('delete-form-' . $id)->toHtml();
        $button = Button::create()
            ->type('submit')
            ->class('text-white bg-red-500 py-1 px-4 rounded')
            ->text('Delete')
            ->attributes(['onclick' => 'return confirm("Are you sure ?");', 'form' => 'delete-form-' . $id])
            ->toHtml();

        return $form . $button;

    }
}
