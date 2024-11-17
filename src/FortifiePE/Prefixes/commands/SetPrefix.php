<?php

namespace FortifiePE\Prefixes\commands;

use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\lang\BaseLang;
use pocketmine\Player;

class SetPrefix extends PluginCommand
{
	private BaseLang $lang;

	public function __construct(Main $main)
	{
		$this->lang = $main->getLang();
		parent::__construct("setprfx", $main);
		$this->setPermission("prefixes.default");
	}

	public function execute(CommandSender $sender, $commandLabel, array $args): bool
	{
		if (!$sender instanceof Player) {
			return false;
		}

		$prefix = trim(implode(" ", $args));

		if (empty($prefix)) {
			$sender->sendMessage($this->lang->translateString("setprefix.usage"));
			return true;
		}

		$manager = PrefixManager::getInstance();

		if (str_starts_with($prefix, "!")) {
			if (!$sender->hasPermission("prefixes.ready_prefixes")) {
				$sender->sendMessage($this->lang->translateString("setprefix.ready_prefix_not_permission"));
				return true;
			}

			if (!$manager->getReadyPrefix(mb_substr($prefix, 1))) {
				$sender->sendMessage($this->lang->translateString("setprefix.ready_prefix_null"));
				return true;
			}
		} else {
			if (
				strlen($prefix) >= Main::getInstance()->getConfig()->get("limit") and
				!$sender->hasPermission("prefixes.admin")
			) {
				$sender->sendMessage($this->lang->translateString("setprefix.limit"));
				return true;
			}
		}

		$result = ($manager->getPlayer($sender->getName()))->setPrefix($prefix);

		if ($result) {
			$sender->sendMessage($this->lang->translateString("setprefix.success"));
		} else {
			$sender->sendMessage($this->lang->translateString("setprefix.event_cancel"));
		}

		return true;
	}
}
