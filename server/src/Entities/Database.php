<?php

namespace App\Entities;

use App\Factories\PDOFactory;
use App\Managers\DatabaseManager;
use DateTimeImmutable;

class Database extends BaseEntity
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $server_id = null;
    private ?DateTimeImmutable $created_at = null;
    private array $db_users = [];

    public function __construct(array $data = [])
    {
        $this->created_at = new DateTimeImmutable();

        parent::__construct($data);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Database
     */
    public function setId(?int $id): Database
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Database
     */
    public function setName(?string $name): Database
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getServerId(): ?int
    {
        return $this->server_id;
    }

    /**
     * @param int|null $server_id
     * @return Database
     */
    public function setServerId(?int $server_id): Database
    {
        $this->server_id = $server_id;
        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param DateTimeImmutable|null $created_at
     * @return Database
     */
    public function setCreatedAt(?DateTimeImmutable $created_at): Database
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return DatabaseUser[]
     */
    public function getDbUsers(): array
    {
        if (empty($this->db_users) && $this->id !== null) {
            $this->db_users = (new DatabaseManager(new PDOFactory()))->findDatabaseUsers($this->id);
        }
        return $this->db_users;
    }

}
