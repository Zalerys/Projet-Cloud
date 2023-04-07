<?php

namespace App\Entities;

use App\Exceptions\UserException;
use App\Factories\PDOFactory;
use App\Helpers\Regex;
use App\Managers\UserManager;
use DateTimeImmutable;

class User extends BaseEntity
{
    private ?int $id = null;
    private ?string $username = null;
    private ?string $email = null;
    private ?string $hashed_password = null;
    private ?string $public_ssh_key = null;
    private ?DateTimeImmutable $created_at = null;
    private array $servers = [];

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
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return User
     * @throws UserException
     */
    public function setUsername(?string $username): User
    {
        if (Regex::validateUsername($username)) {
            $this->username = $username;
        } else {
            throw new UserException('Invalid username');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     * @throws UserException
     */
    public function setEmail(?string $email): User
    {
        if (Regex::validateEmail($email)) {
            $this->email = $email;
        } else {
            throw new UserException('Invalid email');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHashedPassword(): ?string
    {
        return $this->hashed_password;
    }

    /**
     * @param string|null $hashed_password
     * @return User
     */
    public function setHashedPassword(?string $hashed_password): User
    {
        $this->hashed_password = $hashed_password;
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
     * @return User
     */
    public function setCreatedAt(?DateTimeImmutable $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPublicSshKey(): ?string
    {
        return $this->public_ssh_key;
    }

    /**
     * @param string|null $public_ssh_key
     * @return User
     */
    public function setPublicSshKey(?string $public_ssh_key): User
    {
        $this->public_ssh_key = $public_ssh_key;
        return $this;
    }

    /**
     * @return array
     */
    public function getServers(): array
    {
        if (empty($this->servers)) {
            $this->servers = (new UserManager(new PDOFactory()))->findUserServers($this->getId());
        }
        return $this->servers;
    }

    public function toArray(): array
    {
        $servers = [];
        foreach ($this->getServers() as $server) {
            $servers[] = $server->toArray();
        }

        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'hashed_password' => $this->getHashedPassword(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'servers' => $servers
        ];
    }
}
