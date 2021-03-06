<?php declare(strict_types=1);

namespace App\Services\Grid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Column
{
    public const FILTER_ALL_OPTION = 'all';

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $label;

    /**
     * @var bool
     */
    protected bool $sortable = false;

    /**
     * @var ColumnSortOrder
     */
    protected ColumnSortOrder $defaultSortOrder = ColumnSortOrder::NONE;

    /**
     * @var ColumnSortOrder
     */
    protected ColumnSortOrder $currentSortOrder = ColumnSortOrder::NONE;

    /**
     * @var string|null
     */
    protected string|null $sortRawColumn;

    /**
     * @var bool
     */
    protected bool $filterable = false;

    /**
     * @var array<int|string, string>
     */
    protected array $filterOptions = [];

    /**
     * @var mixed
     */
    protected mixed $defaultFilterOption = self::FILTER_ALL_OPTION;

    /**
     * @var mixed
     */
    protected mixed $currentFilter = self::FILTER_ALL_OPTION;

    /**
     * @var callable|null
     */
    protected $renderWrapper = null;

    /**
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Column
     */
    public function setName(string $name): Column
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Column
     */
    public function setLabel(string $label): Column
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param ColumnSortOrder $default
     * @param null|string $rawColumn
     * @return Column
     */
    public function sortable(ColumnSortOrder $default = ColumnSortOrder::NONE, null|string $rawColumn = null): Column
    {
        $this->sortable = true;
        $this->defaultSortOrder = $default;
        $this->sortRawColumn = $rawColumn;

        return $this;
    }


    /**
     * @return callable|null
     */
    public function getRenderWrapper(): ?callable
    {
        return $this->renderWrapper;
    }

    /**
     * @param callable $renderWrapper
     * @return Column
     */
    public function setRenderWrapper(callable $renderWrapper): Column
    {
        $this->renderWrapper = $renderWrapper;
        return $this;
    }

    /**
     * @param Model $data
     * @return string
     */
    public function render(Model $data): string
    {
        if ($this->renderWrapper) {
            return strval(call_user_func($this->renderWrapper, $data));
        }

        return strval($data[$this->name]);
    }

    /**
     * @return string
     */
    public function getSortLink(): string
    {
        return request()->fullUrlWithQuery(['order' => match ($this->currentSortOrder) {
            ColumnSortOrder::ASC => "{$this->name},desc",
            ColumnSortOrder::DESC => "{$this->name},none",
            ColumnSortOrder::NONE => "{$this->name},asc",
        }]);
    }

    /**
     * @param mixed $option
     * @return string
     */
    public function getFilterLink(mixed $option): string
    {
        $filters = (array)request()->query('filter', []);
        $filters[$this->name] = $option;

        return request()->fullUrlWithQuery(['page' => 1, 'filter' => $filters]);
    }

    /**
     * @return ColumnSortOrder
     */
    public function getDefaultSortOrder(): ColumnSortOrder
    {
        return $this->defaultSortOrder;
    }

    /**
     * @return ColumnSortOrder
     */
    public function getCurrentSortOrder(): ColumnSortOrder
    {
        return $this->currentSortOrder;
    }

    /**
     * @param ColumnSortOrder $currentSortOrder
     * @return Column
     */
    public function setCurrentSortOrder(ColumnSortOrder $currentSortOrder): Column
    {
        $this->currentSortOrder = $currentSortOrder;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    /**
     * @param array<int|string, string> $options
     * @param mixed $default
     * @return Column
     */
    public function filterable(array $options, mixed $default = self::FILTER_ALL_OPTION): Column
    {
        $this->filterable = true;
        $this->filterOptions = $options;
        $this->defaultFilterOption = $default;

        return $this;
    }

    /**
     * @return array<string|int, string>
     */
    public function getFilterOptions(): array
    {
        return Arr::add($this->filterOptions, 'all', 'All');
    }

    /**
     * @return mixed
     */
    public function getCurrentFilter(): mixed
    {
        return $this->currentFilter;
    }

    /**
     * @param mixed|string $currentFilter
     * @return Column
     */
    public function setCurrentFilter(mixed $currentFilter): Column
    {
        $this->currentFilter = $currentFilter;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getDefaultFilterOption(): mixed
    {
        return $this->defaultFilterOption;
    }

    /**
     * @return string|null
     */
    public function getSortRawColumn(): ?string
    {
        return $this->sortRawColumn;
    }
}
