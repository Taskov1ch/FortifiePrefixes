<?php

namespace FortifiePE\Prefixes\commands;

use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\lang\BaseLang;

class DeletePrefixFrom extends PluginCommand
{
	private BaseLang $lang;

	public function __construct(Main $main)
	{
		parent::__construct("delprfxfrom", $main);
		$this->setPermission("prefixes.admin");
		$this->lang = $main->getLang();
	}

	public function execute(CommandSender $sender, $commandLabel, array $args): bool
	{
		if (!isset($args[0])) {
			$sender->sendMessage($this->lang->translateString("delprefixfrom.usage"));
			return true;
		}

		$player = PrefixManager::getInstance()->getPlayer($args[0]);

		if (!$player->getPrefix()) {
			$sender->sendMessage($this->lang->translateString("delprefixfrom.without_prefix"));
			return false;
		}

		$result = $player->setPrefix(null);

		if ($result) {
			$sender->sendMessage($this->lang->translateString("delprefixfrom.success"));
		} else {
			$sender->sendMessage($this->lang->translateString("delprefixfrom.event_cancel"));
		}

		return true;
	}
}
