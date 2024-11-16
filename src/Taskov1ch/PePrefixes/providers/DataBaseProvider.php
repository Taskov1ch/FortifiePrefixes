<?php

namespace Taskov1ch\PePrefixes\providers;

use Taskov1ch\PePrefixes\utils\SingletonTrait;

abstract class DataBaseProvider
{
	use SingletonTrait;

	abstract protected function createTable(): void;

	abstract public function createPlayer(string $nickname): void;

	abstract public function getPrefix(string $nickname): ?string;

	abstract public function setPrefix(string $nickname, string $prefix): void;
}
