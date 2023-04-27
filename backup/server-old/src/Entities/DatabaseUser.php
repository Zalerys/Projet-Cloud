<?php

namespace App\Entities;

use DateTimeImmutable;

class DatabaseUser extends BaseEntity
{
    private ?int $id = null;
    private ?int $database_id = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?DateTimeImmutable $created_at = null;

    public function __construct(array $data = [])
    {
        $this->created_at = new DateTimeImmutable();

        parent::__construct($data);
    }
}
