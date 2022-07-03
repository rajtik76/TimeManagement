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
     * @var ColumnAction[]
     */
    protected array $actions = [];

    /**
     * @var callable|null
     */
    protected $conditionalRowClass = null;

    /**
     * @return LengthAwarePaginator
     */
    public function getData(): LengthAwarePaginator
    {
        $builder = clone $this->builder;

        foreach ($this->getColumns() as $column) {

            if ($column->isSortable() && $this->getColumnSortOrder($column) != ColumnSortOrder::NONE) {
                $builder->orderBy($column->getSortRawColumn() ?? $column->getName(), $this->getColumnSortOrder($column)->value);
            }

            if ($column->isFilterable() && $this->getColumnFilter($column) != 'all') {
                $builder->where($column->getName(), $column->getCurrentFilter());
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
        $this->updateColumnsFilter();
        $this->updateColumnsSortOrder();

        return $this->columns;
    }

    /**
     * @param Column $column
     * @return Grid
     */
    public function addColumn(Column $column): Grid
    {
        $this->columns[] = $column;
        return $this;
    }

    /**
     * @return ColumnAction[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param ColumnAction $action
     * @return $this
     */
    public function addAction(ColumnAction $action): Grid
    {
        $this->actions[$action->getName()] = $action;
        return $this;
    }

    /**
     * @return callable|null
     */
    public function getConditionalRowClass(): ?callable
    {
        return $this->conditionalRowClass;
    }

    /**
     * @param callable|null $conditionalRowClass
     * @return Grid
     */
    public function setConditionalRowClass(?callable $conditionalRowClass): Grid
    {
        $this->conditionalRowClass = $conditionalRowClass;
        return $this;
    }

    /**
     * @param Column $column
     * @return ColumnSortOrder
     */
    protected function getColumnSortOrder(Column $column): ColumnSortOrder
    {
        $orderFromRequest = request()->query('order');

        if (is_string($orderFromRequest)) {
            list($name, $order) = explode(',', $orderFromRequest);
            return $name === $column->getName() ? ColumnSortOrder::from($order) : ColumnSortOrder::NONE; // return column sort order from request otherwise return none
        }

        return $column->getDefaultSortOrder();
    }

    /**
     * @param Column $column
     * @return mixed
     */
    protected function getColumnFilter(Column $column): mixed
    {
        $filtersFromRequest = request()->query('filter');

        if (is_array($filtersFromRequest) && array_key_exists($column->getName(), $filtersFromRequest)) {
            return $filtersFromRequest[$column->getName()];
        }

        return $column->getDefaultFilterOption();
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

    /**
     * @return void
     */
    protected function updateColumnsFilter(): void
    {
        foreach ($this->columns as $column) {
            $column->setCurrentFilter($this->getColumnFilter($column));
        }
    }
}
