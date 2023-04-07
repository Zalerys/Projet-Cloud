<?php

namespace App\Entities;

use App\Exceptions\DatabaseException;
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
     * @param DateTimeImmutable|string|null $created_at
     * @return Database
     * @throws DatabaseException
     */
    public function setCreatedAt(DateTimeImmutable|string|null $created_at): Database
    {
        if (!empty($created_at)) {
            if (is_string($created_at)) {
                $created_at = new DateTimeImmutable($created_at);
            } elseif (is_object($created_at)) {
                $created_at = new DateTimeImmutable($created_at->format('Y-m-d H:i:s'));
            }
            $this->created_at = $created_at;
        } else {
            throw new DatabaseException('created_at is empty');
        }
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'server_id' => $this->server_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'db_users' => array_map(fn(DatabaseUser $db_user) => $db_user->toArray(), $this->db_users),
        ];
    }

}
