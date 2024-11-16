<?php

namespace FortifiePE\Prefixes\providers;

use SQLite3;
use FortifiePE\Prefixes\Main;

class SQLite extends DataBaseProvider
{
	private string $path;
	private SQLite3 $db;

	const CREATE_TABLE = "CREATE TABLE IF NOT EXISTS prefixes (nickname TEXT PRIMARY KEY, prefix TEXT)";
	const CREATE_PLAYER = "INSERT OR IGNORE INTO prefixes (nickname) VALUES (?)";
	const SET_PREFIX = "UPDATE prefixes SET prefix = ? WHERE nickname = ?";
	const GET_PREFIX = "SELECT prefix FROM prefixes WHERE nickname = ? LIMIT 1";

	public function __construct(?string $path = null)
	{
		$this->setInstance($this);
		$this->path = $path ?? Main::getInstance()->getDataFolder() . "database.db";

		$this->db = new SQLite3($this->path);

		$this->db->exec("PRAGMA synchronous = NORMAL");
		$this->db->exec("PRAGMA journal_mode = WAL");
		$this->db->exec("PRAGMA encoding = \"UTF-8\"");

		$this->createTable();
	}

	protected function createTable(): void
	{
		$this->db->exec(self::CREATE_TABLE);
	}

	public function createPlayer(string $nickname): void
	{
		$nickname = strtolower($nickname);
		$stmt = $this->db->prepare(self::CREATE_PLAYER);
		$stmt->bindValue(1, $nickname, SQLITE3_TEXT);
		$stmt->execute();
		$stmt->close();
	}

	public function getPrefix(string $nickname): ?string
	{
		$nickname = strtolower($nickname);
		$stmt = $this->db->prepare(self::GET_PREFIX);
		$stmt->bindValue(1, $nickname, SQLITE3_TEXT);
		$result = $stmt->execute();

		$data = $result->fetchArray(SQLITE3_ASSOC);
		$stmt->close();

		return $data["prefix"] ?? null;
	}

	public function setPrefix(string $nickname, string $prefix): void
	{
		$nickname = strtolower($nickname);
		$stmt = $this->db->prepare(self::SET_PREFIX);
		$stmt->bindValue(1, $prefix, SQLITE3_TEXT);
		$stmt->bindValue(2, $nickname, SQLITE3_TEXT);
		$stmt->execute();
		$stmt->close();
	}

	public function getPath(): string
	{
		return $this->path;
	}
}
