<?php namespace Ssms\Repositories\QuickLink;

interface QuickLinkRepository {

	public function getAll();

	public function add($array);

	public function delete($id);

	public function edit($id, $array);

}