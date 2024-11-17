<?php

namespace FortifiePE\Prefixes\commands;

use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\lang\BaseLang;
use pocketmine\Player;

class DeletePrefix extends PluginCommand
{
	private BaseLang $lang;

	public function __construct(Main $main)
	{
		parent::__construct("delprefix", $main);
		$this->setPermission("prefixes.default");
		$this->lang = $main->getLang();
	}

	public function execute(CommandSender $sender, $commandLabel, array $args): bool
	{
		if (!$sender instanceof Player) {
			return false;
		}

		$player = PrefixManager::getInstance()->getPlayer($sender->getName());

		if (!$player->getPrefix()) {
			$sender->sendMessage($this->lang->translateString("delprefix.without_prefix"));
			return true;
		}

		$result = $player->setPrefix(null);

		if ($result) {
			$sender->sendMessage($this->lang->translateString("delprefix.success"));
		} else {
			$sender->sendMessage($this->lang->translateString("delprefix.event_cancel"));
		}

		return true;
	}
}
