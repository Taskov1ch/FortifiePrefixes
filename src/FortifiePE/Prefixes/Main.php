<?php

namespace FortifiePE\Prefixes;

use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use FortifiePE\Prefixes\listener\EventsListener;
use FortifiePE\Prefixes\players\PrefixManager;
use FortifiePE\Prefixes\providers\Provider;
use FortifiePE\Prefixes\utils\SingletonTrait;

class Main extends PluginBase
{
	use SingletonTrait;

	private PrefixManager $manager;
	private BaseLang $lang;
	private Provider $provider;

	public function onEnable(): void
	{
		if (!is_dir($this->getDataFolder())) {
			mkdir($this->getDataFolder());
		}

		$this->setInstance($this);
		$this->manager = new PrefixManager();
		$this->lang = new BaseLang("config", $this->getDataFolder());
		$this->provider = new Provider($this->getConfig()->get("database"));

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
