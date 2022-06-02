<?php

namespace DevKhris\LaraArchRepository\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use DevKhris\LaravelRepository\Interfaces\EloquentRepositoryInterface;

class BaseRepository implements EloquentRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

	public function all(array $columns = ['*'], array $relations = []): Collection
	{
		return $this->model->with($relations)->get($columns);
	}

	public function allDeleted(): Collection
	{
		return $this->model->onlyTrashed()->get();
	}

	public function getById(
		int $id,
		array $columns = ['*'],
		array $relations = [],
		array $data = []
	): Model {
		return $this->model->select($columns)->with($relations)->findOrFail($id)->append($data);
	}

	public function getDeletedById(int $id): Model
	{
		return $this->model->withTrashed()->findOrFail($id);
	}

	public function getOnlyDeletedById(int $id): Model
	{
		return $this->model->onlyTrashed()->findOrFail($id);
	}

	public function store(array $payload = []): Model
	{
		$model = $this->model->create($payload);

		return $model->fresh();
	}

	public function update(int $id, array $payload = []): Model
	{
		$model = $this->getById($id);

		return $model->update($payload);
	}

	public function restoreById(int $id): bool
	{
		return $this->getOnlyDeletedById($id)->restore();
	}

	public function deleteById(int $id): bool
	{
		return $this->getById($id)->delete();
	}

	public function permanentlyDeleteById(int $id): bool
	{
		return $this->getDeletedById($id)->forceDelete();
	}
}
