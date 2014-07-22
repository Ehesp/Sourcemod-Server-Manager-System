<?php namespace Ssms\Repositories;

abstract class EloquentRepository {

	/**
	 * Return everything in the model
	 *
	 * @return object
	 */
	public function getAll()
	{
		return $this->model->get();
	}

	/**
	 * Return a collection of model objects, with parameters
	 *
	 * @return object
	 */
	public function getBy($type, $value, $operator = '=')
	{
		return $this->model->where($type, $operator, $value)->get();
	}

	/**
	 * Return a model object, with parameters
	 *
	 * @return object
	 */
	public function getFirst($type, $value, $operator = '=')
	{
		return $this->model->where($type, $operator, $value)->first();
	}

	/**
	 * Count the number of rows in the model
	 *
	 * @return int
	 */
	public function count()
	{
		return $this->model->count();
	}

	/**
	 * Create a new row in the model, using an array of values
	 *
	 * @param array $array An array on key (column) value items
	 * @return object
	 */
	public function add($array)
	{
		return $this->model->create($array);
	}

	/**
	 * Delete a row in a model by ID
	 *
	 * @param int $id ID of the row to delete
	 * @return void
	 */
	public function delete($id)
	{
		$this->model->destroy($id);
	}

	/**
	 * Edits a row by ID in a model with an array of values
	 *
	 * @param int $id ID of the row to edit
	 * @param array $array An array on key (column) value items
	 * @return object
	 */
	public function edit($id, $array)
	{
		$model = $this->model->find($id);

		foreach ($array as $key => $value)
		{
			$model->$key = $value;
		}

		$model->save();

		return $model;
	}
}