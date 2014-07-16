<?php namespace Ssms;

use Eloquent;

/**
* This class is namespaced due to a class conflict naming with the
* steam condenser package.
*
* Usage: Ssms\Server::method();
*
* @var string
*/

class Server extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'servers';

	/**
	* The guarded table columns.
	*
	* @var array
	*/
	protected $guarded = ['id'];

	/**
	* Automatically encrypts a value entered into the rcon_password field.
	*
	*/
	public function setRconPasswordAttribute($value)
	{
	    $this->attributes['rcon_password'] = \Crypt::encrypt($value);
	}

	/**
	* Automatically decrypts the rcon_password field when called.
	*
	*/
	public function getRconPasswordAttribute($value)
	{
	    return \Crypt::decrypt($value);
	}

	/**
	* One-Many relationship with the game_types table
	*
	*/
	public function gametype()
	{
		return $this->belongsTo('GameType', 'client_appid', 'client_appid');
	}

    public function flags()
    {
        return $this->belongsToMany('Flag', 'flag_server')->orderBy('flag_id');
    }

	/**
	* Refreshes a servers details with a given SourceServer
	* object method.
	*
	*/
	public function refresh($info)
	{
		$this->name = $info['serverName'];
		$this->tags = $info['serverTags'];
		$this->tags = $info['serverTags'];
		$this->operating_system = $info['operatingSystem'];
		$this->version = $info['gameVersion'];
		$this->network = $info['networkVersion'];
		$this->current_map = $info['mapName'];
		$this->current_players = $info['numberOfPlayers'];
		$this->current_bots = $info['botNumber'];
		$this->max_players = $info['maxPlayers'];
		$this->retries = 0;
		$this->touch();
		$this->save();

		return;
	}

	/**
	* Adds a try value to the server
	*
	*/
	public function addRetry($number = 1)
	{
		$this->retries = $this->retries + $number;
		$this->save();

		return;
	}

	/**
	* Sets flags on a server, if they don't already exist
	*
	*/
	public function setFlags($flags)
	{
		foreach ($flags as $flag)
		{
			if (! $this->flags->contains($flag))
			{
				$this->flags()->attach($flag);
			}
		}

		return;
	}

	/**
	* Remove flags on a server, only if they exist
	*
	*/
	public function removeFlags($flags)
	{
		foreach ($flags as $flag)
		{
			if ($this->flags->contains($flag))
			{
				$this->flags()->detach($flag);
			}
		}

		return;
	}

	/**
	* Resets the flags on the server, and assigns it the "all ok" flag
	*
	*/
	public function resetFlags()
	{
		$this->flags()->detach();

		$this->flags()->attach(1);

		return;
	}
}