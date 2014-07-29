<?php namespace Ssms\Repositories\Option;

interface OptionRepository {

	public function getAll();

	public function edit($id, $array);

}