<?php

use Ssms\Repositories\QuickLink\QuickLinkRepository;

class QuickLinkController extends BaseController {

	/**
	 * @var $quicklinks QuickLinkRepositoryInterface
	 */
	protected $quicklinks;

	public function __construct(QuickLinkRepository $quicklinks)
	{
		$this->quicklinks = $quicklinks;
	}

	/**
	 * Get the quick links
	 * 
	 * @return object
	 */
	public function get()
	{
		return $this->quicklinks->getAll();
	}

	/**
	 * Add a quick link
	 * 
	 * @return json
	 */
	public function add()
	{
		$data = Input::all();

		if ($this->isEmpty($data['name'])) return $this->jsonResponse(400, false, "The name value must be present!");
		
		if ($this->isEmpty($data['url'])) return $this->jsonResponse(400, false, "The url value must be present!");

		if ($this->isEmpty($data['icon'])) return $this->jsonResponse(400, false, "The icon value must be present!");

		// If invalid URL
		if (! $this->isValidUrl($data['url'])) return $this->jsonResponse(400, false, "The URL must be valid, starting with 'http://' or 'https://'!");

		// If invalid font awesome name 
		if (! $this->isValidFontAwesome($data['icon'])) return $this->jsonResponse(400, false, "The icon name supplied is not a valid Font Awesome icon!");

		try
		{
			$array = [
				'name' => $data['name'],
				'url' => $data['url'],
				'icon' => $data['icon']		
			];

			$add = $this->quicklinks->add($array);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Quick Link has successfully been added!', $add);
	}

	/**
	 * Delete a quick link
	 * 
	 * @return json
	 */
	public function delete()
	{
		$id = Input::all()[0];

		try
		{
			$this->quicklinks->delete($id);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Quick Link has successfully been deleted!');
	}

	/**
	 * Edit a quick link
	 * 
	 * @return json
	 */
	public function edit()
	{
		$data = Input::all();

		if ($this->isEmpty($data['edit']['name'])) return $this->jsonResponse(400, false, "The name value must be present!");
		
		if ($this->isEmpty($data['edit']['url'])) return $this->jsonResponse(400, false, "The url value must be present!");

		if ($this->isEmpty($data['edit']['icon'])) return $this->jsonResponse(400, false, "The icon value must be present!");

		// If invalid font awesome name 
		if (! $this->isValidFontAwesome($data['edit']['icon'])) return $this->jsonResponse(400, false, "The icon name supplied is not a valid Font Awesome icon!");

		// If invalid URL
		if (! $this->isValidUrl($data['edit']['url'])) return $this->jsonResponse(400, false, "The URL must be valid, starting with 'http://' or 'https://'!");

		try
		{
			$edit = [
				'name' => $data['edit']['name'],
				'url' => $data['edit']['url'],
				'icon' => $data['edit']['icon'],
			];

			$update = $this->quicklinks->edit($data['id'], $edit);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Quick Link updated successfully!', $update);
	}

}