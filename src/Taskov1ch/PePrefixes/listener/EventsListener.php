<?php

namespace Taskov1ch\PePrefixes\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use Taskov1ch\PePrefixes\players\PrefixManager;

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
		$prefix = PrefixManager::getInstance()->getPlayer($event->getPlayer()->getName());
	}
}
