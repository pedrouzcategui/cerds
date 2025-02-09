<?php
require_once "../middleware.php";
require_once "./User.php";

checkAuth();

$is_edit = isset($_GET['is_edit']);
$user_id = isset($_GET['user_id']);
$user = null;
if ($is_edit && $user_id) {
    $user = User::findById($user_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? "Edit User" : "Create User" ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 40px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div>
        <h2><?= $is_edit ? "Edit User" : "Create User" ?></h2>
        <form method="POST" action="<?= $is_edit ? "update.php?user_id=" . $user->getId() : "create.php" ?>">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= $user !== null ? $user->getUsername() : "" ?>" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $user !== null ? $user->getEmail() : "" ?>" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="************" <?= $is_edit ? "" : "required" ?>>
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= $user !== null ? $user->getPhone() : "" ?>" required>
            </div>
            <button type="submit"> <?= $is_edit ? "Update" : "Create" ?> </button>
        </form>
    </div>
</body>

</html>