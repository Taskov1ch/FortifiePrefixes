<?php

namespace FortifiePE\Prefixes\tasks;

use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\scheduler\PluginTask;

class SaveTask extends PluginTask
{

	public function __construct(Main $main)
	{
		parent::__construct($main);
	}

	public function onRun($currentTick)
	{
		PrefixManager::getInstance()->saveAll(true);
	}
}
