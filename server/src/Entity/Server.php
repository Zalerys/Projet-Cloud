<?php

namespace App\Entity;

use App\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
class Server
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $storage_size = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backups_folder_path = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $auto_backups_time = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'server', targetEntity: Database::class, orphanRemoval: true)]
    private Collection $dbs;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'servers')]
    private Collection $users;

    public function __construct()
    {
        $this->dbs = new ArrayCollection();
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

    public function getStorageSize(): ?float
    {
        return $this->storage_size;
    }

    public function setStorageSize(?float $storage_size): self
    {
        $this->storage_size = $storage_size;

        return $this;
    }

    public function getBackupsFolderPath(): ?string
    {
        return $this->backups_folder_path;
    }

    public function setBackupsFolderPath(?string $backups_folder_path): self
    {
        $this->backups_folder_path = $backups_folder_path;

        return $this;
    }

    public function getAutoBackupsTime(): ?\DateTimeImmutable
    {
        return $this->auto_backups_time;
    }

    public function setAutoBackupsTime(?\DateTimeImmutable $auto_backups_time): self
    {
        $this->auto_backups_time = $auto_backups_time;

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
     * @return Collection<int, Database>
     */
    public function getDbs(): Collection
    {
        return $this->dbs;
    }

    public function addDbs(Database $database): self
    {
        if (!$this->dbs->contains($database)) {
            $this->dbs->add($database);
            $database->setServer($this);
        }

        return $this;
    }

    public function removeDbs(Database $database): self
    {
        if ($this->dbs->removeElement($database)) {
            // set the owning side to null (unless already changed)
            if ($database->getServer() === $this) {
                $database->setServer(null);
            }
        }

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
            $user->addServer($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeServer($this);
        }

        return $this;
    }
}
