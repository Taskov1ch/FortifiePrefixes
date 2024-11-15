<?php

namespace Taskov1ch\PePrefixes;

use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use Taskov1ch\PePrefixes\listener\EventsListener;
use Taskov1ch\PePrefixes\players\PrefixManager;
use Taskov1ch\PePrefixes\provider\SQLite3;
use Taskov1ch\PePrefixes\utils\SingletonTrait;

class Main extends PluginBase
{
	use SingletonTrait;

	private PrefixManager $manager;
	private BaseLang $lang;

	public function onEnable(): void
	{
		if (!is_dir($this->getDataFolder())) {
			mkdir($this->getDataFolder());
		}

		$this->setInstance($this);
		$this->manager = new PrefixManager();
		$this->lang = new BaseLang("config", $this->getDataFolder());
		SQLite3::init();

		foreach ($this->getResources() as $resource) {
			$this->saveResource($resource->getFilename());
		}

		$this->getServer()->getPluginManager()->registerEvents(new EventsListener(), $this);
	}

	public function onDisable(): void
	{
		$this->getLogger()->info("Сохранение префиксов...");
		$this->manager->saveAll();
	}

	public function getManager(): PrefixManager
	{
		return $this->manager;
	}

	public function getLang(): BaseLang
	{
		return $this->lang;
	}
}
