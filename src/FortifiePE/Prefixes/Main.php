<?php

namespace FortifiePE\Prefixes;

use FortifiePE\Prefixes\commands\AddReadyPreffix;
use FortifiePE\Prefixes\commands\DeletePrefix;
use FortifiePE\Prefixes\commands\DeletePrefixFrom;
use FortifiePE\Prefixes\commands\SetPrefix;
use FortifiePE\Prefixes\commands\SetPrefixTo;
use FortifiePE\Prefixes\listener\EventsListener;
use FortifiePE\Prefixes\players\PrefixManager;
use FortifiePE\Prefixes\providers\Provider;
use FortifiePE\Prefixes\tasks\SaveTask;
use FortifiePE\Prefixes\utils\SingletonTrait;
use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;

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

		foreach ($this->getResources() as $resource) {
			$this->saveResource($resource->getFilename());
		}

		$config = $this->getConfig();
		$this->manager = new PrefixManager();
		$this->lang = new BaseLang("config", $this->getDataFolder());
		$this->provider = new Provider($config->get("database"));

		$this->getServer()->getPluginManager()->registerEvents(new EventsListener(), $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new SaveTask($this), 20 * 60 * $config->get("save"));
		$this->getServer()->getCommandMap()->registerAll($this->getName(), [
			new AddReadyPreffix($this),
			new DeletePrefix($this),
			new DeletePrefixFrom($this),
			new SetPrefix($this),
			new SetPrefixTo($this)
		]);
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
