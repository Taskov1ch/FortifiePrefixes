<?php

namespace FortifiePE\Prefixes\players;

use pocketmine\utils\Config;
use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\providers\Provider;
use FortifiePE\Prefixes\utils\SingletonTrait;

class PrefixManager
{
	use SingletonTrait;

	private array $players = [];
	private array $ready_prefixes = [];

	public function __construct() {
		$this->setInstance($this);
		$this->ready_prefixes = (new Config(Main::getInstance()->getDataFolder() . "ready_prefixes.yml"))->getAll();
	}

	public function getPlayer(string $nickname): PrefixPlayer
	{
		$nickname = strtolower($nickname);

		if (isset($this->players[$nickname])) {
			return $this->players[$nickname];
		}

		$this->players[$nickname] = new PrefixPlayer($nickname);
		return $this->getPlayer($nickname);
	}

	public function getReadyPrefix(string $workpiece): ?string
	{
		return $this->ready_prefixes[$workpiece] ?? null;
	}

	public function getAll(): array
	{
		return $this->players;
	}

	public function saveAll(): void
	{
		foreach ($this->getAll() as $nickname => $prefix) {
			Provider::getInstance()->getDataBase()->setPrefix($nickname, $prefix->getPrefix());
		}
	}
}
