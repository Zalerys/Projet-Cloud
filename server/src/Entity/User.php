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

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user_single', 'user_list', 'server_single', 'database_single'])]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user_single', 'user_list'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user_single'])]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups(['user_single', 'user_list'])]
    private array $roles = [];

    #[ORM\Column(length: 1000, nullable: true)]
    #[Groups(['user_single'])]
    private ?string $public_ssh_key = null;

    #[ORM\Column]
    #[Groups(['user_single'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToMany(targetEntity: Server::class, inversedBy: 'users')]
    #[Groups(['user_single'])]
    private Collection $servers;

    #[ORM\ManyToMany(targetEntity: Database::class, inversedBy: 'users')]
    #[Groups(['user_single'])]
    private Collection $affectedDatabases;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
        $this->affectedDatabases = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeServer(Server $server): self
    {
        $this->servers->removeElement($server);

        return $this;
    }

    /**
     * @return Collection<int, Database>
     */
    public function getAffectedDatabases(): Collection
    {
        return $this->affectedDatabases;
    }

    public function addAffectedDatabase(Database $affectedDatabase): self
    {
        if (!$this->affectedDatabases->contains($affectedDatabase)) {
            $this->affectedDatabases->add($affectedDatabase);
        }

        return $this;
    }

    public function removeAffectedDatabase(Database $affectedDatabase): self
    {
        $this->affectedDatabases->removeElement($affectedDatabase);

        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Returns the identifier for this user (e.g. username or email address).
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
