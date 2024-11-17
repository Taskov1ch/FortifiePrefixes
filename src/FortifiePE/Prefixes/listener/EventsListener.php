<?php

namespace FortifiePE\Prefixes\listener;

use FortifiePE\Prefixes\players\PrefixManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\Server;

class EventsListener implements Listener
{
	public function onChat(PlayerChatEvent $event): void
	{
		$player = $event->getPlayer();
		$prefix = PrefixManager::getInstance()->getPlayer($player->getName());
		$format = Server::getInstance()->getLanguage()->translateString($event->getFormat(), [
			$player->getName(), $event->getMessage()
		]);
		$event->setFormat($prefix->updateChat($format));
	}

	public function onJoin(PlayerJoinEvent $event): void
	{
		$player = PrefixManager::getInstance()->getPlayer($event->getPlayer()->getName());
		$player->update();
	}

	public function onPreLogin(PlayerPreLoginEvent $event): void
	{
		PrefixManager::getInstance()->getPlayer($event->getPlayer()->getName());
	}
}
