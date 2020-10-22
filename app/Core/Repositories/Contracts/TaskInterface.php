<?php

namespace App\Core\Repositories\Contracts;

interface TaskInterface extends BaseInterface
{
    public function getListByStatus($status, $options = []);
}
