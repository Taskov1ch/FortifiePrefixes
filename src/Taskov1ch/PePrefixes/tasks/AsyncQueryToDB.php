<?php

namespace Taskov1ch\PePrefixes\tasks;

use Closure;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use Taskov1ch\PePrefixes\provider\SQLite3;

class AsyncQueryToDB extends AsyncTask
{

	public function __construct(
		private string $path,
		private string $method,
		private array $params,
		private ?Closure $todo // Сосать непоточность, сосать потокобезопасность!
	) {}

	public function onRun()
	{
		$method = $this->method;
		SQLite3::init();
		$result = SQLite3::$method($this->params);
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