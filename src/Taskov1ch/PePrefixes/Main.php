<?php

namespace Taskov1ch\PePrefixes;

use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use Taskov1ch\PePrefixes\provider\SQLite3;
use Taskov1ch\PePrefixes\utils\SingletonTrait;

class Main extends PluginBase
{
	use SingletonTrait;

	public function onEnable(): void
	{
		$this->setInstance($this);
		SQLite3::init();

		foreach ($this->getResources() as $resource) {
			$this->saveResource($resource->getFilename());
		}

		$lang = new BaseLang("prefixes_lang", $this->getDataFolder());
		var_dump($lang->translateString("pe_prefixes.setprefix.usage"));

	}

}
