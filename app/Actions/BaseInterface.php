<?php

namespace App\Actions;

interface BaseInterface
{
    public function setData(array $data);

    public function handle();
}
