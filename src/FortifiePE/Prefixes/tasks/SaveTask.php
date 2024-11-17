<?php

namespace FortifiePE\Prefixes\tasks;

use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\scheduler\Task;

class SaveTask extends Task
{
	public function onRun($currentTick)
	{
		PrefixManager::getInstance()->saveAll(true);
	}
}
