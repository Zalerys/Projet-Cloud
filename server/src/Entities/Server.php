<?php

namespace App\Entities;

use App\Exceptions\ServerException;
use App\Exceptions\UserException;
use App\Factories\PDOFactory;
use App\Helpers\Regex;
use App\Managers\DatabaseManager;
use App\Managers\ServerManager;
use App\Managers\UserManager;
use DateTimeImmutable;

class Server extends BaseEntity
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $backups_folder_path = null;
    private ?DateTimeImmutable $auto_backups_time = null;
    private ?DateTimeImmutable $created_at = null;
    private array $databases = [];
    private array $users = [];

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
     * @return Server
     */
    public function setId(?int $id): Server
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
     * @return Server
     * @throws UserException
     */
    public function setName(?string $name): Server
    {
        if (Regex::validateName($name)) {
            $this->name = $name;
        } else {
            throw new UserException('Invalid username');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBackupsFolderPath(): ?string
    {
        return $this->backups_folder_path;
    }

    /**
     * @param string|null $backups_folder_path
     * @return Server
     * @throws ServerException
     */
    public function setBackupsFolderPath(?string $backups_folder_path): Server
    {
        if (Regex::validatePath($backups_folder_path)) {
            is_dir($backups_folder_path) || mkdir($backups_folder_path, 0777, true);
            $this->backups_folder_path = $backups_folder_path;
        } else {
            throw new ServerException('Invalid path');
        }
        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getAutoBackupsTime(): ?DateTimeImmutable
    {
        return $this->auto_backups_time;
    }

    /**
     * @param DateTimeImmutable|null $auto_backups_time
     * @return Server
     */
    public function setAutoBackupsTime(?DateTimeImmutable $auto_backups_time): Server
    {
        $this->auto_backups_time = $auto_backups_time;
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
     * @return Server
     * @throws ServerException
     */
    public function setCreatedAt(DateTimeImmutable|string|null $created_at): Server
    {
        if (!empty($created_at)) {
            if (is_string($created_at)) {
                $created_at = new DateTimeImmutable($created_at);
            } elseif (is_object($created_at)) {
                $created_at = new DateTimeImmutable($created_at->format('Y-m-d H:i:s'));
            }
            $this->created_at = $created_at;
        } else {
            throw new ServerException('created_at is empty');
        }
        return $this;
    }

    /**
     * @return Database[]
     */
    public function getDatabases(): array
    {
        if (!empty($this->id) && empty($this->databases)) {
            $this->databases = (new DatabaseManager(new PDOFactory()))->findServerDatabases($this->id);
        }
        return $this->databases;
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        if (!empty($this->id) && empty($this->users)) {
            $this->users = (new ServerManager(new PDOFactory()))->findServerUsers($this->id);
        }
        return $this->users;
    }

    /**
     * @param array $users
     * @return Server
     */
    public function setUsers(array $users): Server
    {
        $this->users = $users;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'backups_folder_path' => $this->backups_folder_path,
            'auto_backups_time' => $this->auto_backups_time?->format('H:i'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'databases' => array_map(function (Database $database) {
                return $database->toArray();
            }, $this->getDatabases()),
            'users' => array_map(function (User $user) {
                return $user->toArray();
            }, $this->getUsers()),
        ];
    }
}
