<?php


namespace App\Filters;


use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;
    protected $builder ;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value)
        {
            if (method_exists($this, $filter) && !is_null($value))
                $this->$filter($value);
        }

    }

    public function filters()
    {
        return $this->request->all();
    }


}
