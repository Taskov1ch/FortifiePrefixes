<?php

namespace Taskov1ch\PePrefixes;

use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{

	public function onEnable(): void
	{
		foreach ($this->getResources() as $resource) {
			$this->saveResource($resource->getFilename());
		}

		$lang = new BaseLang("prefixes_lang", $this->getDataFolder());
		var_dump($lang->translateString("pe_prefixes.setprefix.usage"));
	}

}