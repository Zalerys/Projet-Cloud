<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user_single', 'user_list', 'server_single', 'database_single'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user_single', 'user_list', 'server_single', 'database_single'])]
    private ?string $username = null;

    #[ORM\Column]
    #[Groups(['user_single', 'user_list'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(['user_single'])]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user_single', 'user_list'])]
    private ?string $email = null;

    #[ORM\Column(length: 10000, nullable: true)]
    #[Groups(['user_single', 'server_single'])]
    private ?string $public_ssh_key = null;

    #[ORM\Column]
    #[Groups(['user_single'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToMany(targetEntity: Server::class, mappedBy: 'users')]
    #[Groups(['user_single'])]
    private Collection $servers;

    #[ORM\ManyToMany(targetEntity: Database::class, mappedBy: 'users')]
    #[Groups(['user_single'])]
    private Collection $dbs;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
        $this->dbs = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
    public function getDbs(): Collection
    {
        return $this->dbs;
    }

    public function addDb(Database $db): self
    {
        if (!$this->dbs->contains($db)) {
            $this->dbs->add($db);
            $db->addUser($this);
        }

        return $this;
    }

    public function removeDb(Database $db): self
    {
        if ($this->dbs->removeElement($db)) {
            $db->removeUser($this);
        }

        return $this;
    }
}
