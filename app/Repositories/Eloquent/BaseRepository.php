<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IBase;
use App\Repositories\Criteria\Criteria;
use App\Traits\HttpResponse;
use Illuminate\Support\Arr;

abstract class BaseRepository implements IBase
{
    use HttpResponse;

    protected $model;
    public $languages = ['ar', 'en'];

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    public function withCriteria(...$criteria): BaseRepository
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }
        return $this;
    }

    protected function getModelClass()
    {
        if (!method_exists($this, 'model')) {
            return self::failure('no model defined', 422);
        }

        return app()->make($this->model());
    }

    public function all()
    {
        return $this->model->get();
    }

    public function allWithPagination($count = 10)
    {
        return $this->model->paginate($count);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findWhere($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    public function firstOrCreate($data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function firstOrNew($data)
    {
        return $this->model->firstOrNew($data);
    }

    public function forceCreate($data)
    {
        return $this->model->forceCreate($data);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function forceFill(array $data, $id = null)
    {
        $record = $this->find($id);
        return $record->forceFill($data)->save();
    }

    public function addMedia($record, $media, $collection)
    {
        $record->addMedia($media)->toMediaCollection($collection);
        $record->save();
    }

    public function clearMediaCollection($record, $collection)
    {
        $record->clearMediaCollection($collection);
        $record->save();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->where('id', $id)->restore();
    }

}
