<?php

namespace FortifiePE\Prefixes\utils;

trait SingletonTrait
{
	private static self $instance;

	protected function setInstance(self $instance): void
	{
		self::$instance = $instance;
	}

	public static function getInstance(): self
	{
		return self::$instance;
	}
}
