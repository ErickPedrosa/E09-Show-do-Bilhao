
<?php

session_start();





require "processing/login.php";

if (!isset($_SESSION["autenticado"])) {
    
    if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nome"], $_POST["email"], $_POST["login"], $_POST["senha"]) ){
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $login = $_POST["login"];
        $senha = $_POST["senha"];

        cadastraAluno($nome, $email, $login, $senha);

    }else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuario"], $_POST["senha"])) {
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

     
        if (autenticar($usuario, $senha)) {
            $_SESSION["usuario"] = $usuario;


            $_SESSION["autenticado"] = true;
            setcookie("n_acertos", 0);
            header("Location: /pages/perguntas.php?id=0"); 

        } else {
            $erroLogin = "Usuário ou senha inválidos.";
        }
    }




} elseif (isset($_GET["logout"])) {
   
    session_unset();
    session_destroy();
    setcookie("n_acertos");
    
    header("Location: index.php"); 
}


?>



<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Show dos Otakus</title>

        <link rel="stylesheet" href="style/reset.css">
        <link rel="stylesheet" href="style/style.css">
    </head>

    <body>
        <?php include "templates/menu.inc"?>

        <main style="flex-direction:column">
            <h2>Login</h2>

            <?php if (isset($erroLogin)){ ?>
                <p><?php echo $erroLogin; ?></p>
            <?php } ?>
            
            <?php if (!isset($_SESSION["autenticado"])){ ?>
                <form method="post" action="index.php">

                    <label for="usuario">Login:</label>
                    <input type="text" name="usuario" required><br>
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" required><br>
                    <input type="submit" value="Entrar">

                </form>

                <a href="pages/cadastro.php">Cadastre-se</a>
            <?php } else { ?>
                <p>Você está autenticado como <?php echo $_SESSION["usuario"]; ?></p>
                <p>Última vez logado: <?php echo $_COOKIE["ultimo_acesso"]; ?></p>
                <p>Última pontuação: <?php echo $_COOKIE["n_acertos"]; ?></p>

                <?php setcookie('n_acertos'); ?>
                
                <a href="pages/perguntas.php?id=0">Iniciar o jogo</a><br>
                <a href="?logout">Logout</a>

            <?php } ?>
        
        </main>

        <?php include "templates/rodape.inc"?>
    </body>

</html>