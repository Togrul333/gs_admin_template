<?php


namespace App\Actions;


abstract class AbstractAction implements BaseInterface
{
    protected array $data;

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    abstract public function handle();
}
