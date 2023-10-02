<?php

namespace App\Repositories\Contracts;

interface IBase
{
    public function withCriteria(...$criteria);

    public function all();

    public function allWithPagination($count = 10);

    public function findOrFail($id);

    public function first();

    public function firstOrCreate($data);

    public function firstOrNew($data);

    public function forceCreate($data);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function forceFill(array $data, $id);

    public function restore($id);

    public function addMedia($record, $media, $collection);

    public function clearMediaCollection($record, $collection);


}
