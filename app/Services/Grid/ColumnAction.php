<?php declare(strict_types=1);

namespace App\Services\Grid;

class ColumnAction
{
    public function __construct(protected readonly string $name, /** @var callable $callback */ protected $callback)
    {
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     * @return ColumnAction
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function render(mixed $data): string
    {
        return strval(call_user_func($this->callback, $data));
    }
}
