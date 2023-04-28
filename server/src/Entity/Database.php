<?php

namespace App\Entity;

use App\Repository\DatabaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DatabaseRepository::class)]
#[ORM\Table(name: 'program_db')]
class Database
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['database_single', 'database_list', 'user_single', 'server_single'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['database_single', 'database_list', 'user_single', 'server_single'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'dbs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['database_single'])]
    private ?Server $server = null;

    #[ORM\Column]
    #[Groups(['database_single'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'dbs')]
    #[Groups(['database_single'])]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): self
    {
        $this->server = $server;

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
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
