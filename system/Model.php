<?php

class Model
{
	protected ?PDO $pdo = null;
	protected ?PDOStatement $statement = null;

	public function __construct()
	{
		$this->pdo = DB::instance();
	}

	public function __destruct()
	{
		$this->pdo = null;
		$this->statement = null;
	}

	public function prepare(string $sql): void
	{
		$this->statement = $this->pdo->prepare($sql);
	}

	public function execute(array $params = [], int $type = PDO::FETCH_ASSOC): array
	{
		if ($this->statement && $this->statement->execute($params)) {
			return $this->statement->fetch($type);
		}

		return [];
	}

	public function countAffected(): int
	{
		if ($this->statement) {
			return $this->statement->rowCount();
		}

		return 0;
	}

	public function getLastId(): mixed
	{
		return $this->pdo->lastInsertId();
	}
}