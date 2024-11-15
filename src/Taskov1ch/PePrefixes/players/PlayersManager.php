<?php

namespace Taskov1ch\PePrefixes\players;

use Taskov1ch\PePrefixes\Main;
use Taskov1ch\PePrefixes\utils\SingletonTrait;

class PlayersManager
{
	use SingletonTrait;

	private array $players = [];

	public function __construct(private Main $main) {
		$this->setInstance($this);
	}

	public function get(string $nickname): void
	{
		$nickname = strtolower($nickname);

		if (isset($this->players[$nickname])) {
			return $this->players[$nickname];
		}

		$this->players[$nickname] = new PrefixPlayer($nickname);
		return $this->get($nickname);
	}

	public function getAll(): array
	{
		return $this->players;
	}

}