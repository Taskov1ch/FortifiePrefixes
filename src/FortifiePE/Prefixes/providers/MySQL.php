<?php

namespace FortifiePE\Prefixes\providers;

use mysqli;

class MySQL extends DataBaseProvider
{
	private mysqli $db;

	const CREATE_TABLE = "CREATE TABLE IF NOT EXISTS prefixes (nickname TEXT PRIMARY KEY, prefix TEXT)";
	const CREATE_PLAYER = "INSERT IGNORE INTO prefixes (nickname) VALUES (?)";
	const SET_PREFIX = "UPDATE prefixes SET prefix = ? WHERE nickname = ?";
	const GET_PREFIX = "SELECT prefix FROM prefixes WHERE nickname = ? LIMIT 1";

	public function __construct(
		string $host,
		string $scheme,
		string $username,
		string $password
	) {
		$this->setInstance($this);
		$this->db = new mysqli($host, $username, $password, $scheme);
		$this->db->set_charset("utf8mb4");
		$this->createTable();
	}

	protected function createTable(): void
	{
		$this->db->query(self::CREATE_TABLE);
	}

	public function createPlayer(string $nickname): void
	{
		$nickname = strtolower($nickname);
		$stmt = $this->db->prepare(self::CREATE_PLAYER);
		$stmt->bind_param("s", $nickname);
		$stmt->execute();
		$stmt->close();
	}

	public function getPrefix(string $nickname): ?string
	{
		$nickname = strtolower($nickname);
		$stmt = $this->db->prepare(self::GET_PREFIX);
		$stmt->bind_param("s", $nickname);
		$stmt->execute();

		$result = $stmt->get_result();
		$data = $result->fetch_assoc();

		$stmt->close();
		return $data["prefix"] ?? null;
	}

	public function setPrefix(string $nickname, ?string $prefix): void
	{
		$nickname = strtolower($nickname);
		$stmt = $this->db->prepare(self::SET_PREFIX);
		$stmt->bind_param("ss", $prefix, $nickname);
		$stmt->execute();
		$stmt->close();
	}
}