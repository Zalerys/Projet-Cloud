<?php

namespace App\Entities;

use App\Exceptions\UserException;
use App\Helpers\Regex;

class User extends BaseEntity
{
    private ?int $id = null;
    private ?string $username = null;
    private ?string $email = null;
    private ?string $hashed_password = null;
    private ?\DateTimeImmutable $created_at = null;
    private array $projects = [];

    public function __construct(array $data = [])
    {
        $this->created_at = new \DateTimeImmutable();

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
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeImmutable|null $created_at
     * @return User
     */
    public function setCreatedAt(?\DateTimeImmutable $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Project[]
     */
    public function getProjects(): array
    {
        if (empty($this->projects)) {
            $this->projects = $this->getEntityManager()->getProjectManager()->getProjectsByUser($this);
        }
        return $this->projects;
    }

    public function toArray(): array
    {
        $projects = [];
        foreach ($this->getProjects() as $project) {
            $projects[] = $project->toArray();
        }

        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'hashed_password' => $this->getHashedPassword(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'projects' => $projects
        ];
    }
}
