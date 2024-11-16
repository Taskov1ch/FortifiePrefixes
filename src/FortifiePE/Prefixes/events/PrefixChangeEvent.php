<?php

namespace FortifiePE\Prefixes\events;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\event\HandlerList;

class PrefixChangeEvent extends Event implements Cancellable
{
	public static ?HandlerList $handlerList = null;

	public function __construct(
		private string $nickname,
		private ?string $new,
		private ?string $old
	) {}

	public function getNickname(): string
	{
		return $this->nickname;
	}

	public function getNewPrefix(): ?string
	{
		return $this->new;
	}

	public function getOldPrefix(): ?string
	{
		return $this->old;
	}
}
