<?php

use Ssms\Repositories\Option\OptionRepository;

class OptionController extends BaseController {

	/**
	 * @var $options OptionRepositoryInterface
	 */
	protected $options;

	public function __construct(OptionRepository $options)
	{
		$this->options = $options;
	}

	/**
	 * Return all of the options
	 * 
	 * @return object
	 */
	public function get()
	{
		return $this->options->getAll();
	}

	/**
	 * Edit an option
	 * 
	 * @return json
	 */
	public function edit()
	{
		$data = Input::all();

		if ($this->isEmpty($data['value'])) return $this->jsonResponse(400, false, "The option value must be present!");

		try
		{
			$option = $this->options->edit($data['id'], ['value' => $data['value']]);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'The option has been updated!', $option);
	}

}