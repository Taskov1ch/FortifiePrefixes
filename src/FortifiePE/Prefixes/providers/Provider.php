<?php

namespace FortifiePE\Prefixes\providers;

use Closure;
use FortifiePE\Prefixes\exceptions\ProviderNotFound;
use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\tasks\AsyncQueryToDB;
use FortifiePE\Prefixes\utils\SingletonTrait;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class Provider
{
	use SingletonTrait;
	private DataBase $db;

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

	public function getDataBase(): DataBase
	{
		return $this->db;
	}

	public function asyncExecute(string $method, array $params, ?Closure $todo = null): AsyncTask
	{
		$config = $this->config;

		if ($this->db instanceof SQLite) {
			$config["sqlite"]["force_path"] = $this->db->getPath();
		}

		$task = new AsyncQueryToDB($config, $method, $params, $todo);
		Server::getInstance()->getAsyncPool()->submitTask($task);

		return $task;
	}
}
