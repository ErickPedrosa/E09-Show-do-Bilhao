<?php
require "../processing/questions.php";

if(count($_GET) == 0){
    $id = 0;
}else{
    $id = $_GET['id'];
}


$dadosPergunta = carregaPergunta($id);

$pergunta = $dadosPergunta->enunciado;
$alt = $dadosPergunta->alternativas;
$resposta = $dadosPergunta->gabarito;

$gab = ["A", "B", "C", "D"];
$resp_usuario = $gab[$_POST["alt"]];



if( !isset($_COOKIE["n_acertos"]) ){

    $nAcertos = 0;

}else{

    $nAcertos = $_COOKIE["n_acertos"];

    if($resp_usuario == retornaGabarito()[$id-1]){
        $nAcertos += 1;
    }
    

}

setcookie("n_acertos", $nAcertos);

?>



<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pergunta <?php echo ($id + 1) ?> - Show dos Otakus</title>

        <link rel="stylesheet" href="../style/reset.css">
        <link rel="stylesheet" href="../style/style.css">
    </head>

    <body>
        <?php include "../templates/menu.inc"?>

        <?php 
        if($id != 0 && $resp_usuario != retornaGabarito()[$id-1]){
            
            setcookie("ultimo_acesso", date("d/m/Y H:i:s"), 0 , "/");
            include "../templates/game-over.inc";

        }else if($id >= 5){

            setcookie("ultimo_acesso", date("d/m/Y H:i:s"), 0 , "/");
            include "../templates/winner.inc";  

        }else{
            include "../templates/questoes.inc";

        } ?>

        <?php include "../templates/rodape.inc"?>
    </body>

</html>