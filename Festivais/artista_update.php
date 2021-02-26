<?php

session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login']="incorreto";
}
if ($_SESSION['login']=="correto" && isset($_SESSION['login'])) {
    //aqui colocamos o conteudo


if ($_SERVER['REQUEST_METHOD']=='POST') {
    $id="";
    $nome="";
    $data="";

    if (isset($_POST['id'])) {
        $id=$_POST['id'];
    }
    else{
        echo '<script>alert("É obrigatório o preenchimento do id.");</script>';
    }
    if (isset($_POST['nome'])) {
        $nome=$_POST["nome"];
    }
    if (isset($_POST['data'])) {
        $data=$_POST['data'];
    }


    $con=new mysqli("localhost","root", "","festa");

    if ($con->connect_errno!=0) {
        echo "Ocorreu um erro no acesso á base de dados. <br>".$con->connect_error;
        exit;
    }
    else{
        $sql="update artista set nome=?, data=? where id=?";
        $stm=$con->prepare($sql);


            if ($stm!=false) {
                $stm->bind_param("ssi", $nome, $data, $id);
                $stm->execute();
                $stm->close();
                echo '<script>alert("artista alterada com sucesso!!")</script>';
                echo "Aguarde um momento. A reencaminhar página";
                header ('refresh:5, url=index.php');
            }
            else{
                echo "erro";
        }
    }
}
else{
    echo ("<h1>Houve um erro ao processar o seu pedido.<br> Dentro de segundos irá ser rencaminhado!</h1>");
                header ("refresh:5; url= index.php");
}



}//login
else{
    echo 'Para entrar nesta página necessita de efetuar <a href="login.php">login</a>';
    header('refresh:2;url=login.php');
}

?>