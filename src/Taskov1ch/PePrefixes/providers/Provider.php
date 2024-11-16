<?php

namespace Taskov1ch\PePrefixes\providers;

use Closure;
use Taskov1ch\PePrefixes\exceptions\ProviderNotFound;
use Taskov1ch\PePrefixes\Main;
use Taskov1ch\PePrefixes\tasks\AsyncQueryToDB;
use Taskov1ch\PePrefixes\utils\SingletonTrait;

class Provider
{
	use SingletonTrait;
	private DataBaseProvider $db;

	public function __construct(private array $config)
	{
		$this->setInstance($this);
		$provider = $config["provider"];

		switch ($provider) {
			case "sqlite":
			case "sqlite3":
				$data = $config["sqlite"];
				$this->db = new SQLite($data["force_path"] ?? Main::getInstance()->getDataFolder() . $data["path"]);
				break;

			case "mysql":
				$data = $config["mysql"];
				$this->db = new MySQL(
					$data["host"],
					$data["scheme"],
					$data["username"],
					$data["password"]
				);
				break;

			default:
				throw new ProviderNotFound("Провайдера {$provider} не существует!");

		}
	}

	public function getDataBase(): DataBaseProvider
	{
		return $this->db;
	}

	public function asyncExecute(string $method, array $params, ?Closure $todo = null): void
	{
		$config = $this->config;

		if ($this->db instanceof SQLite) {
			$config["sqlite"]["force_path"] = $this->db->getPath();
		}

		Main::getInstance()->getServer()->getScheduler()->scheduleAsyncTask(
			new AsyncQueryToDB($config, $method, $params, $todo)
		);
	}
}
