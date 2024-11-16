<?php

namespace FortifiePE\Prefixes\tasks;

use Closure;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use FortifiePE\Prefixes\providers\Provider;

class AsyncQueryToDB extends AsyncTask
{
	public function __construct(
		private array $config,
		private string $method,
		private array $params,
		private ?Closure $todo // Сосать непоточность, сосать потокобезопасность!
	) {}

	public function onRun()
	{
		$db = (new Provider(get_object_vars($this->config)))->getDataBase();
		$result = call_user_func_array([$db->getInstance(), $this->method], get_object_vars($this->params));
		$this->setResult($result);
	}

	public function onCompletion(Server $server)
	{
		if ($todo = $this->todo) {
			$result = $this->getResult();
			$todo($result);
		}
	}

}