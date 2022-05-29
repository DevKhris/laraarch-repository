<?php

namespace DevKhris\LaravelRepository\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface EloquentRepositoryInterface
{
	/**
	 * Get model instance from repository
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function getModel(): Model;

    /**
     * Set model repository
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function setModel(Model $model): void;

	/*
	* Get all models from database
	*
	* @param array $columns database columns to fetch
	* @param array $relations get models relationships
	*
	* @return \Illuminate\Database\Eloquent\Collection
	*
	*/
	public function all(array $columns = ['*'],array $relations = []): Collection;

	/*
	* Get models with deleted at
	*
	* @return \Illuminate\Database\Eloquent\Collection
	*
	*/
	public function allDeleted(): Collection;

	/*
	* Get model from given id
	*
	* @param int $id id from model
	* @param array $columns database columns to fetch
	* @param array $relations get models relationships
	* @param array $data data to append
	*
	* @return \Illuminate\Database\Eloquent\Model
	*
	*/
	public function getById(
		int $id,
		array $columns = ['*'],
		array $relations = [],
		array $data = []
	): Model;

	/*
	* Get model from given id with delete_at
	*
	* @param int $id id from model
	*
	* @return \Illuminate\Database\Eloquent\Model
	*
	*/
	public function getOnlyDeletedById(int $id): Model;

	/*
	* Get model from given id only with delete_at
	*
	* @param int $id id from model
	*
	* @return \Illuminate\Database\Eloquent\Model
	*
	*/
	public function getDeletedById(int $id): Model;

	/*
	*
	* Create model from given payload
	*
	* @param array $payload data for creating the model
	*
	* @return \Illuminate\Database\Eloquent\Model
	*
	*/
	public function store(array $payload = []): Model;

	/*
	*
	* Update existing model from given id with payload
	*
	* @param int $id id from model
	* @param array $payload data for creating the model
	*
	* @return \Illuminate\Database\Eloquent\Model
	*
	*/
	public function update(int $id, array $payload = []): Model;

	/*
	*
	* Restore model from given id
	*
	* @param int id
	*
	* @return bool
	*
	*/
	public function restoreById(int $id): bool;

	/*
	*
	* Delete model from given id
	*
	* @param int $id
	*
	* @return bool
	*
	*/
	public function deleteById(int $id): bool;

	/*
	*
	* Permanently delete model from given id
	*
	* @param int $id
	*
	* @return bool
	*
	*/
	public function permanentlyDeleteById(int $id): bool;
}
