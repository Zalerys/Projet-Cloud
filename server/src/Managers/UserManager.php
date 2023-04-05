<?php

namespace App\Managers;

use App\Entities\Project;
use App\Entities\User;
use App\Exceptions\UserException;
use App\Helpers\Regex;

class UserManager extends BaseManager
{
    /**
     * @param int $id
     * @return User
     * @throws UserException
     */
    public function findOne(int $id): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @throws UserException
     */
    public function findOneByAuthenticationMethod(string $value): User
    {
        if (Regex::validateEmail($value)) {
            return $this->findOneByEmail($value);
        } else {
            return $this->findOneByUsername($value);
        }
    }

    /**
     * @param string $email
     * @return User
     * @throws UserException
     */
    public function findOneByEmail(string $email): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(":email", $email);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @param string $username
     * @return User
     * @throws UserException
     */
    public function findOneByUsername(string $username): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(":username", $username);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @param int|null $i
     * @return User[]
     */
    public function findAll(int $i = null): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users ORDER BY id ASC";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = [];
        $k = 0;
        if ($i == null) {
            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = new User($data);
            }
        } else {
            while (($data = $statement->fetch(\PDO::FETCH_ASSOC)) && ($k < $i)) {
                $users[] = new User($data);
                $k++;
            }
        }
        return $users;
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    public function insertOne(User $user): User
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            INSERT INTO users (username, email, hashed_password, created_at)
            VALUES (?, ?, ?, ?);");
            $request->execute(array(
                $user->getUsername(),
                $user->getEmail(),
                $user->getHashedPassword(),
                $user->getCreatedAt(),
            ));
            $user->setId($db->lastInsertId());
            return $user;
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new UserException("Email or username already exists");
            } else {
                throw new UserException($e->getMessage());
            }
        }
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    public function updateOne(User $user): User
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            UPDATE users
            SET username = ?, email = ?, hashed_password = ?
            WHERE id = ?;");

            $request->execute(array(
                $user->getUsername(),
                $user->getEmail(),
                $user->getHashedPassword(),
                $user->getId()
            ));
            return $user;
        } catch (\Exception $e) {
            throw new UserException("An error occurred while updating the user");
        }
    }

    /**
     * @param User $user
     * @return void
     * @throws UserException
     */
    public function deleteOne(User $user): void
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            DELETE FROM users
            WHERE id = ?;");
            $request->execute(array($user->getId()));
        } catch (\Exception $e) {
            throw new UserException("An error occurred while deleting the user");
        }
    }

    /**
     * @param int $id
     * @return User[]
     */
    public function findUserProjects(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM projects WHERE id IN (SELECT project_id FROM project_users WHERE user_id = :id)";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();

        $projects = [];
        while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $projects[] = new Project($data);
        }
        return $projects;
    }
}
