<?php namespace Ssms\Repositories\Notification;

interface NotificationRepository {

	public function getAll();

	public function edit($id, $array);

	public function getServicesState();

	public function getTypeSettings($type);

}