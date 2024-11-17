<?php

namespace FortifiePE\Prefixes\commands;

use FortifiePE\Prefixes\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\lang\BaseLang;

class DeleteReadyPreffix extends PluginCommand
{
	private BaseLang $lang;

	public function __construct(Main $main)
	{
		parent::__construct("delreadyprfx", $main);
		$this->setPermission("prefixes.admin");
		$this->lang = $main->getLang();
	}

	public function execute(CommandSender $sender, $commandLabel, array $args): bool
	{
		return true;
	}
}
