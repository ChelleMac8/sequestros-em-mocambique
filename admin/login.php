<?php
session_start();
include('../includes/db.php');

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $_SESSION["admin"] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $erro = "Utilizador ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }

        .login-box h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #7f1d1d;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .erro {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Área Administrativa</h1>

        <?php if (!empty($erro)): ?>
            <p class="erro"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Utilizador" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>