<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Return a structured Json response.
	 *
	 * @return json
	 */
	protected function jsonResponse($httpCode, $status, $message)
	{
		$json['code'] = $httpCode;
		$json['status'] = $status;
		$json['message'] = $message;

		return Response::json($json);
	}

}
