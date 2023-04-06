<?php

namespace App\Managers;

use App\Entities\Database;
use App\Entities\DatabaseUser;
use App\Exceptions\DatabaseException;

class DatabaseManager extends BaseManager
{
    /**
     * @param int $id
     * @return Database
     * @throws DatabaseException
     */
    public function findOne(int $id): Database
    {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`Databases` WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new Database($data);
        } else {
            throw new DatabaseException("Database not found");
        }
    }

    /**
     * @param int $serverId
     * @return array
     */
    public function findServerDatabases(int $serverId): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`Databases` WHERE server_id = :server_id";
        $statement = $db->prepare($query);
        $statement->bindValue(":server_id", $serverId);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $databases = [];
        foreach ($data as $database) {
            $databases[] = new Database($database);
        }
        return $databases;
    }

    /**
     * @param int $id
     * @return DatabaseUser[]
     */
    public function findDatabaseUsers(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`DatabasesUsers` WHERE database_id = :database_id";
        $statement = $db->prepare($query);
        $statement->bindValue(":database_id", $id);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $db_users = [];
        foreach ($data as $db_user) {
            $db_users[] = new DatabaseUser($db_user);
        }
        return $db_users;
    }

    /**
     * @return Database[]
     */
    public function findAll(): array {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`Databases`";
        $statement = $db->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $databases = [];
        foreach ($data as $database) {
            $databases[] = new Database($database);
        }
        return $databases;
    }

    /**
     * @param Database $database
     * @throws DatabaseException
     */
    public function updateOne(Database $database): void
    {
        try {
            $db = $this->pdo;
            $query = "UPDATE `tp-data`.`Databases` SET name = :name, server_id = :server_id WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(":id", $database->getId());
            $statement->bindValue(":name", $database->getName());
            $statement->bindValue(":server_id", $database->getServerId());
            $statement->execute();
        } catch (\PDOException $e) {
            throw new DatabaseException("Database not found");
        }
    }

    /**
     * @param Database $database
     * @throws DatabaseException
     */
    public function deleteOne(Database $database): void
    {
        try {
            $db = $this->pdo;
            $query = "DELETE FROM `tp-data`.`Databases` WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(":id", $database->getId());
            $statement->execute();
        } catch (\PDOException $e) {
            throw new DatabaseException("Database not found");
        }
    }
}
