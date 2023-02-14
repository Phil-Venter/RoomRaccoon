<?php

class Shopping extends Model
{
	public function all()
	{
		$this->prepare("SELECT * FROM " . __CLASS__ . ";");
		return $this->execute();
	}

	public function save(array $data): int
	{
		$this->prepare("INSERT INTO " . __CLASS__ . " (text, status) VALUES (:text, :status);");
		$this->execute($data);
		return $this->getLastId();
	}

	public function update(int $id, array $data)
	{
		$data['id'] = $id;

		$this->prepare("UPDATE " . __CLASS__ . " text=:text, status=:status WHERE id=:id;");
		$this->execute($data);
		return $this->getLastId();
	}

	public function delete(int $id)
	{
		$this->prepare("DELETE FROM " . __CLASS__ . " WHERE id=:id");
		$this->execute(['id' => $id]);
		return $this->countAffected() > 0;
	}
}