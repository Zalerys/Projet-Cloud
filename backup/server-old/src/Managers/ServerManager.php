<?php

namespace App\Managers;

use App\Entities\Server;
use App\Entities\User;
use App\Exceptions\ServerException;
use App\Exceptions\UserException;

class ServerManager extends BaseManager
{
    /**
     * @param int $id
     * @return Server
     * @throws ServerException
     */
    public function findOne(int $id): Server
    {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`Servers` WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new Server($data);
        } else {
            throw new ServerException("Server not found");
        }
    }

    /**
     * @param int $serverId
     * @return User[]
     */
    public function findServerUsers(int $serverId): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`ServersUsers` WHERE server_id = :server_id";
        $statement = $db->prepare($query);
        $statement->bindValue(":server_id", $serverId);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];
        foreach ($data as $user) {
            $users[] = new User($user);
        }
        return $users;
    }

    /**
     * @return Server[]
     */
    public function findAll(): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM `tp-data`.`Servers`";
        $statement = $db->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $servers = [];
        foreach ($data as $server) {
            $servers[] = new Server($server);
        }
        return $servers;
    }

    /**
     * @param Server $server
     * @return Server
     * @throws ServerException
     */
    public function insertOne(Server $server): Server
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            INSERT INTO Servers (name, backups_folder_path, auto_backups_time)
            VALUES (?, ?, ?);");

            $request->execute(array(
                $server->getName(),
                $server->getBackupsFolderPath(),
                $server->getAutoBackupsTime()
            ));
            $server->setId($db->lastInsertId());
            return $server;
        } catch (\Exception $e) {
            throw new ServerException("An error occurred while creating the server");
        }
    }

    /**
     * @param Server $server
     * @return Server
     * @throws ServerException
     */
    public function updateOne(Server $server): Server
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            UPDATE Servers
            SET name = ?, backups_folder_path = ?, auto_backups_time = ?
            WHERE id = ?;");

            $request->execute(array(
                $server->getName(),
                $server->getBackupsFolderPath(),
                $server->getAutoBackupsTime(),
                $server->getId()
            ));
            return $server;
        } catch (\Exception $e) {
            throw new ServerException("An error occurred while updating the server");
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws ServerException
     */
    public function deleteOne(int $id): void
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            DELETE FROM Servers
            WHERE id = ?;");

            $request->execute(array($id));
        } catch (\Exception $e) {
            throw new ServerException("An error occurred while deleting the server");
        }
    }
}
