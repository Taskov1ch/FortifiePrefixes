<?php

namespace Taskov1ch\PePrefixes\players;

use Taskov1ch\PePrefixes\provider\SQLite3;

class PlayerPrefixes
{

	private string $prefix;

	public function __construct(private string $nickname)
	{
		$this->init();
	}

	private function init(): void
	{
		SQLite3::asyncExecute("createPlayer", [$this->nickname]);
		// $stmt = PlayersManager::getInstance()->db->prepare(SQLite3::GET_PREFIX);
		// $stmt->bindValue(":nickname", $this->nickname);
		// $this->prefix = $stmt->execute()->fetchArray(SQLITE3_ASSOC)[0];
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