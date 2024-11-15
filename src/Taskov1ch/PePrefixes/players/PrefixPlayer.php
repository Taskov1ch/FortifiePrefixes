<?php

namespace Taskov1ch\PePrefixes\players;

use Taskov1ch\PePrefixes\provider\SQLite3;

class PrefixPlayer
{

	private string $prefix;

	public function __construct(private string $nickname)
	{
		SQLite3::asyncExecute("createPlayer", [$this->nickname]);
		// get and save prefix
	}

	public function getPrefix(): string
	{
		return $this->prefix;
	}

	public function setPrefix(string $prefix): void
	{
		$this->prefix = $prefix;
	}

}