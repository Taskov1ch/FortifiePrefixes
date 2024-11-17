<?php

namespace FortifiePE\Prefixes\providers;

use FortifiePE\Prefixes\utils\SingletonTrait;

abstract class DataBase
{
	use SingletonTrait;

	abstract protected function createTable(): void;

	abstract public function createPlayer(string $nickname): void;

	abstract public function getPrefix(string $nickname): ?string;

	abstract public function setPrefix(string $nickname, string $prefix): void;

	abstract public function beginTransaction(): void;

	abstract public function commit(): void;
}
