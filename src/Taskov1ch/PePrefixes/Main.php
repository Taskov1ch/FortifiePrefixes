<?php

namespace Taskov1ch\PePrefixes;

use Closure;
use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use Taskov1ch\PePrefixes\provider\SQLite3;
use Taskov1ch\PePrefixes\utils\Async;
use Taskov1ch\PePrefixes\utils\SingletonTrait;

class Main extends PluginBase
{
	use SingletonTrait;

	private $test;

	public function onEnable(): void
	{
		$this->setInstance($this);
		SQLite3::init();
		// foreach ($this->getResources() as $resource) {
		// 	$this->saveResource($resource->getFilename());
		// }

		// $lang = new BaseLang("prefixes_lang", $this->getDataFolder());
		// var_dump($lang->translateString("pe_prefixes.setprefix.usage"));

		// $date = function() {
		// 	var_dump("Hello");
		// };
	}

}
