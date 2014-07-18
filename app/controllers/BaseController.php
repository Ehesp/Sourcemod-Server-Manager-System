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

	/**
	 * Return whether a given value is "empty"
	 *
	 * @return bool
	 */
	protected function isEmpty($value)
	{
		if ($value === null || $value == '' || $value == 'null') return true;

		return false;
	}

	/**
	 * Return whether a given value starts with the Font Awesome
	 * class declaration.
	 *
	 * @return bool
	 */
	protected function isValidFontAwesome($value)
	{
		if (strpos($value, 'fa fa-') !== false) return true;

		return false;
	}

	/**
	 * Return whether a given value is a URL
	 *
	 * @return bool
	 */
	protected function isValidUrl($value)
	{
		if (strpos($value, 'http://') !== false || strpos($value, 'https://') !== false) return true;

		return false;
	}

	/**
	 * Return whether a given string are all valid email addresses
	 *
	 * @return bool
	 */
	protected function isValidEmails($value)
	{
		$value = preg_replace('/\s+/', '', $value);

		if (strpos($value, ';') !== false)
		{
			$emails = explode(';', $value);

			foreach ($emails as $email)
			{
				if(! $this->validateEmail($email)) return false;
			}

			return true;
		}
		else
		{
			return $this->validateEmail($value);
		}		
	}

	private function validateEmail($email)
	{
		if(! filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

		return true;
	}

}
