<?php declare(strict_types=1);

namespace App\Services\Grid;

use Illuminate\Database\Eloquent\Model;

class Column
{
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
     * @param bool $sortable
     * @return Column
     */
    public function setSortable(bool $sortable): Column
    {
        $this->sortable = $sortable;
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
            return call_user_func($this->renderWrapper, $data);
        }

        return $data[$this->name];
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
     * @return ColumnSortOrder
     */
    public function getDefaultSortOrder(): ColumnSortOrder
    {
        return $this->defaultSortOrder;
    }

    /**
     * @param ColumnSortOrder $defaultSortOrder
     * @return Column
     */
    public function setDefaultSortOrder(ColumnSortOrder $defaultSortOrder): Column
    {
        $this->defaultSortOrder = $defaultSortOrder;
        return $this;
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
}
