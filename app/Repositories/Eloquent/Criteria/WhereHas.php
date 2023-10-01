<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WhereHas implements Criteria
{
    private $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    public function apply($model)
    {
        return $model->whereHas($this->relation);
    }
}
