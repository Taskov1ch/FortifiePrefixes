<?php

namespace Taskov1ch\PePrefixes\utils;

trait SingletonTrait
{
	private static self $instance;

	private static function setInstance(self $instance): void
	{
		self::$instance = $instance;
	}

	public static function getInstance(): self
	{
		return self::$instance;
	}
}
