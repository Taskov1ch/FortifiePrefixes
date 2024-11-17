<?php

namespace FortifiePE\Prefixes\commands;

use FortifiePE\Prefixes\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

class AddReadyPreffix extends PluginCommand
{
	public function __construct(Main $main)
	{
		parent::__construct("addreadyprefix", $main);
		$this->setPermission("prefixes.admin");
	}

	public function execute(CommandSender $sender, $commandLabel, array $args): bool
	{
		return true;
	}
}
