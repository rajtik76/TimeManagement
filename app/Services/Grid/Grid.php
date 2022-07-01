<?php declare(strict_types=1);

namespace App\Services\Grid;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Grid
{
    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @var Column[]
     */
    protected array $columns = [];

    /**
     * @return LengthAwarePaginator
     */
    public function getData(): LengthAwarePaginator
    {
        $builder = $this->builder;

        foreach ($this->getColumns() as $column) {

            if ($column->isSortable() && $this->getColumnSortOrder($column) != ColumnSortOrder::NONE) {

                $builder->orderBy($column->getName(), $this->getColumnSortOrder($column)->value);

            }

        }

        return $builder->paginate();
    }

    /**
     * @param Builder $builder
     * @return Grid
     */
    public function setBuilder(Builder $builder): Grid
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        $this->updateColumnsSortOrder();

        return $this->columns;
    }

    /**
     * @param Column $column
     * @return Grid
     */
    public function setColumn(Column $column): Grid
    {
        $this->columns[] = $column;
        return $this;
    }

    /**
     * @param Column $column
     * @return ColumnSortOrder
     */
    protected function getColumnSortOrder(Column $column): ColumnSortOrder
    {
        $orderFromRequest = request()->query('order');

        if ($orderFromRequest) {

            list($name, $order) = explode(',', $orderFromRequest);
            return $name === $column->getName() ? ColumnSortOrder::from($order) : ColumnSortOrder::NONE; // return column sort order from request otherwise return none

        }

        return $column->getDefaultSortOrder();
    }

    /**
     * @return void
     */
    protected function updateColumnsSortOrder(): void
    {
        foreach ($this->columns as $column) {
            $column->setCurrentSortOrder($this->getColumnSortOrder($column));
        }
    }
}
