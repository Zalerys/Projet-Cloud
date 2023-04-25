<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $public_ssh_key = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToMany(targetEntity: Server::class, mappedBy: 'users')]
    private Collection $servers;

    #[ORM\ManyToMany(targetEntity: Database::class, mappedBy: 'users')]
    private Collection $databases;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
        $this->databases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPublicSshKey(): ?string
    {
        return $this->public_ssh_key;
    }

    public function setPublicSshKey(?string $public_ssh_key): self
    {
        $this->public_ssh_key = $public_ssh_key;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Server>
     */
    public function getServers(): Collection
    {
        return $this->servers;
    }

    public function addServer(Server $server): self
    {
        if (!$this->servers->contains($server)) {
            $this->servers->add($server);
            $server->addUser($this);
        }

        return $this;
    }

    public function removeServer(Server $server): self
    {
        if ($this->servers->removeElement($server)) {
            $server->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Database>
     */
    public function getDatabases(): Collection
    {
        return $this->databases;
    }

    public function addDatabase(Database $database): self
    {
        if (!$this->databases->contains($database)) {
            $this->databases->add($database);
            $database->addUser($this);
        }

        return $this;
    }

    public function removeDatabase(Database $database): self
    {
        if ($this->databases->removeElement($database)) {
            $database->removeUser($this);
        }

        return $this;
    }
}
