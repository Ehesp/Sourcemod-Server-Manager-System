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
	protected function jsonResponse($httpCode, $status, $message, $payload = null, $exceptionCode = null)
	{
		$json['code'] = $httpCode;
		$json['status'] = $status;
		$json['message'] = $message;
		! is_null($payload) ? $json['payload'] = $payload :'';
		! is_null($exceptionCode) ? $json['exceptionCode'] = $exceptionCode :'';

		return Response::json($json);
	}

}
