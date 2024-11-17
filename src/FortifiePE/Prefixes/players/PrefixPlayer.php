<?php

namespace FortifiePE\Prefixes\players;

use FortifiePE\Prefixes\events\PrefixChangeEvent;
use FortifiePE\Prefixes\Main;
use FortifiePE\Prefixes\providers\Provider;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class PrefixPlayer
{
	public ?string $old_prefix = null;
	public ?string $prefix = null;

	public function __construct(private string $nickname)
	{
		Provider::getInstance()->asyncExecute("createPlayer", [$this->nickname]);
		Provider::getInstance()->asyncExecute("getPrefix", [$this->nickname], function ($prefix): void
			{
				$this->prefix = $prefix;
			}
		);
	}

	public function getPrefix(): ?string
	{
		return $this->prefix;
	}

	public function setPrefix(?string $prefix): bool
	{
		if ($prefix and str_starts_with($prefix, "!")) {
			$prefix = PrefixManager::getInstance()->getReadyPrefix(mb_substr($prefix, 1));
		}

		$event = new PrefixChangeEvent($this->nickname, $prefix, $this->prefix);
		Server::getInstance()->getPluginManager()->callEvent($event);

		if ($event->isCancelled()) {
			return false;
		}

		$this->old_prefix = $this->prefix;
		$this->prefix = $prefix;
		$this->update();
		return true;
	}

	public function update(): void
	{
		$player = Server::getInstance()->getPlayerExact($this->nickname);

		if (!$player) {
			return;
		}

		$lang = Main::getInstance()->getLang();
		$prefix = $this->prefix . TextFormat::RESET;
		$oldPrefix = $this->old_prefix . TextFormat::RESET;
		$nametagFormats = explode("{%other}", $lang->get("nametag"));
		$displayNameFormats = explode("{%other}", $lang->get("displayname"));

		$nameTag = $player->getNameTag();
		$displayName = $player->getDisplayName();

		if ($this->prefix) {
			$nameTag = $lang->translateString("nametag", [
				"prefix" => $prefix,
				"other" => $nameTag
			]);

			$displayName = $lang->translateString("displayname", [
				"prefix" => $prefix,
				"other" => $displayName
			]);
		}

		foreach ($nametagFormats as $format) {
			$nameTag = str_replace(str_replace("{%prefix}", $oldPrefix, $format), "", $nameTag);
		}

		foreach ($displayNameFormats as $format) {
			$displayName = str_replace(str_replace("{%prefix}", $oldPrefix, $format), "", $displayName);
		}

		$player->setNameTag($nameTag);
		$player->setDisplayName($displayName);
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
