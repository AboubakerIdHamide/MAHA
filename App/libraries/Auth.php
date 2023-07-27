<?php

namespace App\Libraries;

use App\Libraries\Database;

class Auth
{
    public function login($email, $password)
    {
        // Logic to authenticate the user
        // You can replace this with your own authentication logic
        if ($this->validateCredentials($email, $password)) {
            $_SESSION['user'] = $email;
            return true;
        }

        return false;
    }

    public function logout()
    {
        // Logic to log out the user
        session_destroy();
    }

    public function isAuthenticated()
    {
        // Check if the user is authenticated
        return isset($_SESSION['user']);
    }

    private function validateCredentials($email, $password)
    {
        $connection = Database::getConnection();
        // Prepare a query to retrieve the user with the provided email
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $connection->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();

        // Fetch the user from the database
        $userRow = $statement->fetch(\PDO::FETCH_OBJ);

        if ($userRow) {
            // Verify the password against the stored hash
            $storedPasswordHash = $userRow->password;

            if (password_verify($password, $storedPasswordHash)) {
                // Authentication successful
                return true;
            }
        }
        return false;
    }
}
