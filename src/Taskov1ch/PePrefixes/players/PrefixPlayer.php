<?php

namespace Taskov1ch\PePrefixes\players;

use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Taskov1ch\PePrefixes\events\PrefixChangeEvent;
use Taskov1ch\PePrefixes\Main;
use Taskov1ch\PePrefixes\providers\Provider;

class PrefixPlayer
{
	public ?string $prefix = null;

	public function __construct(private string $nickname)
	{
		Provider::getInstance()->asyncExecute("createPlayer", [$this->nickname]);
		Provider::getInstance()->asyncExecute("getPrefix", [$this->nickname], function ($prefix): void
			{
				$this->prefix = $prefix;
				$this->update();
			}
		);
	}

	public function getPrefix(): string
	{
		return $this->prefix;
	}

	public function setPrefix(string $prefix): void
	{
		if (str_starts_with($prefix, "!")) {
			$prefix = PrefixManager::getInstance()->getReadyPrefix(mb_substr($prefix, 1));
		}

		$event = new PrefixChangeEvent($this->nickname, $prefix, $this->prefix);
		Server::getInstance()->getPluginManager()->callEvent($event);

		if ($event->isCancelled()) {
			return;
		}

		$this->prefix = $prefix;
		$this->update();
	}

	public function update(): void
	{
		$player = Server::getInstance()->getPlayerExact($this->nickname);

		if ($player and $this->prefix) {
			$lang = Main::getInstance()->getLang();
			$player->setNameTag($lang->translateString("nametag", [
				"prefix" => $this->prefix . TextFormat::RESET,
				"other" => $player->getNameTag()
			]));
			$player->setDisplayName($lang->translateString("displayname", [
				"prefix" => $this->prefix . TextFormat::RESET,
				"other" => $player->getDisplayName()
			]));
		}
	}

	public function updateChat(string $format): string
	{
		if (!$this->prefix) {
			return $format;
		}

		$lang = Main::getInstance()->getLang();
		return $lang->translateString("chatformat", [
			"prefix" => $this->prefix . TextFormat::RESET,
			"other" => $format
		]);
	}
}
