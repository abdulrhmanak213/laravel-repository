<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WithWhereHas implements Criteria
{

    private $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    public function apply($model)
    {
        return $model->withWhereHas($this->relation);
    }
}
