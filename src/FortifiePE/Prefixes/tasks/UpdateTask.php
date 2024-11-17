<?php

namespace FortifiePE\Prefixes\tasks;

use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\scheduler\Task;

class UpdateTask extends Task
{
	public function onRun($currentTick)
	{
		foreach (PrefixManager::getInstance()->getAll() as $player) {
			$player->update();
		}
	}
}
