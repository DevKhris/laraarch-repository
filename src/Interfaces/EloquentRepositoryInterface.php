<?php

/**
 * Repository Design Pattern implementation for Laravel
 * 
 * @category Design_Pattern
 * @package  LoaraArch
 * @author   Khris H. <contact@devkhris.com>
 * @license  MIT https://mit-license.org/
 * @version  GIT: 1.2
 * @link     https://github.com/DevKhris/laraarch-repository
 */

namespace DevKhris\LaraArchRepository\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Base implementation interface for repository pattern
 */
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

    /** 
     * Get all models from database
     *
     * @param array $columns database columns to fetch
     * @param array $relations get models relationships
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /** 
     * Get models with deleted at
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
     */
    public function allDeleted(): Collection;

    /** 
     * Get model from given id
     *
     * @param int   $id        id from model
     * @param array $columns   database columns to fetch
     * @param array $relations get models relationships
     * @param array $data      data to append
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

    /** 
     * Get model from given id with delete_at
     *
     * @param string|int $id id from model
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     */
    public function getOnlyDeletedById(string|int $id): Model;

    /** 
     * Get model from given id only with delete_at
     *
     * @param string|int $id id from model
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     */
    public function getDeletedById(string|int $id): Model;

    /** 
     * Create model from given payload
     *
     * @param array $payload data for creating the model
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     */
    public function store(array $payload = []): Model;

    /** 
     * Update existing model from given id with payload
     *
     * @param string|int $id      id from model
     * @param array      $payload data for creating the model
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     */
    public function update(string|int $id, array $payload = []): Model;

    /** 
     * Restore model from given id
     *
     * @param string|int $id id
     *
     * @return bool
     *
     */
    public function restoreById(string|int $id): bool;

    /**
     * Delete model from given id
     *
     * @param string|int $id id
     *
     * @return bool
     *
     */
    public function deleteById(string|int $id): bool;

    /** 
     * Permanently delete model from given id
     *
     * @param string|int $id id
     *
     * @return bool
     *
     */
    public function permanentlyDeleteById(string|int $id): bool;
}
