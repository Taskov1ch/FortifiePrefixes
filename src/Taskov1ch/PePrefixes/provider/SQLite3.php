<?php

namespace Taskov1ch\PePrefixes\provider;

use Closure;
use SQLite3 as SQLite;
use Taskov1ch\PePrefixes\Main;
use Taskov1ch\PePrefixes\tasks\AsyncQueryToDB;

class SQLite3
{
	public static string $path;
	public static SQLite $db;

	const CREATE_TABLE = "CREATE TABLE IF NOT EXISTS prefixes (nickname TEXT, prefix TEXT)";
	const CREATE_PLAYER = "INSERT OR IGNORE INTO prefixes (nickname) VALUES (:nickname)";
	const SET_PREFIX = "UPDATE prefixes SET prefix = :prefix WHERE nickname = :nickname";
	const GET_PREFIX = "SELECT prefix FROM prefixes WHERE nickname = :nickname LIMIT = 1";

	public static function init(?string $path = null): void
	{
		self::$path = $path ?? Main::getInstance()->getDataFolder() . "database.db";
		self::$db = new SQLite(self::$path);
		self::$db->exec(self::CREATE_TABLE);
	}

	public static function asyncExecute(string $method, array $params, Closure $todo): void
	{
		Main::getInstance()->getServer()->getScheduler()->scheduleAsyncTask(
			new AsyncQueryToDB(self::$path, $method, $params, $todo)
		);
	}

	public static function createPlayer(string $nickname): void
	{
		$stmt = self::$db->prepare(self::CREATE_PLAYER);
		$stmt->bindValue(":nickname", $nickname);
		$stmt->execute();
	}

}