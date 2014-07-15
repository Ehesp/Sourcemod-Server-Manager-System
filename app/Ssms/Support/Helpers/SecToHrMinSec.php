<?php namespace Ssms\Support\Helpers;

class SecToHrMinSec {

    /**
     * @var string The seconds to convert
     */
	protected $seconds;

    /**
     * Creates a new SecToHrMinSec instance
     *
     */
	public function __construct($seconds)
	{
		$this->seconds = $seconds;
	}

    /**
     * Returns the converted seconds into (H)H:MM:SS format
     *
     */
	public function convert($padHours = false)
	{
		$hms = "";

		$hours = intval(intval($this->seconds) / 3600); 

		$hms .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":" : $hours. ":";

		$minutes = intval(($this->seconds / 60) % 60); 

		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

		$seconds = intval($this->seconds % 60); 

		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

		return $hms;
	}

}