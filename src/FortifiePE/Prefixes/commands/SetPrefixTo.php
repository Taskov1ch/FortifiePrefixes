<?php

namespace FortifiePE\Prefixes\commands;

use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\lang\BaseLang;

class SetPrefixTo extends PluginCommand
{
	private BaseLang $lang;

	public function __construct(Main $main)
	{
		$this->lang = $main->getLang();
		parent::__construct("setprfxto", $main);
		$this->setPermission("prefixes.admin");
	}

	public function execute(CommandSender $sender, $commandLabel, array $args): bool
	{
		$player = array_shift($args);
		$prefix = trim(implode(" ", $args));

		if (empty($prefix)) {
			$sender->sendMessage($this->lang->translateString("setprefixto.usage"));
			return true;
		}

		$result = (PrefixManager::getInstance()->getPlayer($player))->setPrefix($prefix);

		if ($result) {
			$sender->sendMessage($this->lang->translateString("setprefixto.success"));
		} else {
			$sender->sendMessage($this->lang->translateString("setprefixto.event_cancel"));
		}

		return true;
	}
}
