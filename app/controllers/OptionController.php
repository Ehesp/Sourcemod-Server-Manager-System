<?php

use Ssms\Repositories\Option\OptionRepositoryInterface;

class OptionController extends BaseController {

	protected $options;

	public function __construct(OptionRepositoryInterface $options)
	{
		$this->options = $options;
	}

	public function editOption()
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