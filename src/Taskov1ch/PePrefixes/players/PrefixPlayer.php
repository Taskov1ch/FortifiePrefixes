<?php

namespace Taskov1ch\PePrefixes\players;

use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Taskov1ch\PePrefixes\Main;
use Taskov1ch\PePrefixes\provider\SQLite3;

class PrefixPlayer
{
	public ?string $prefix = null;

	public function __construct(private string $nickname)
	{
		SQLite3::asyncExecute("createPlayer", [$this->nickname]);
		SQLite3::asyncExecute("getPrefix", [$this->nickname], function ($prefix): void
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
