<?php
session_start();
if(!isset($_SESSION['login'])){
    $_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto" && isset($_SESSION['login'])){
    if($_SERVER['REQUEST_METHOD']=="POST"){
    $id="";
    $festival="";


    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    else{
        echo '<scipt>alert("É obrigatorio o preenchimento do id.");</script>';
    }
    if(isset($_POST['festival'])){
        $festival = $_POST['festival'];
    }

    $con = new mysqli("localhost","root","","festa");
    if($con->connect_errno!=0){
        echo "Ocorreu um erro no acesso á base de dados.<br>".$con->connect_error;
        exit;
    }
    else {
        $sql = 'insert into festivais(id,festival) values (?,?)';
        $stm = $con->prepare ( $sql);
        if($stm!=false){
            $stm->bind_param('ss',$id,$festival);
            $stm->execute();
            $stm->close();

            echo '<script>alert("festival adicionado com sucesso");</script>';
            echo "Aguarde um momento.A reencaminhar página";
            header("refresh:5;url=index.php");

        }
        else{
            echo ($con->error);
            echo  "Aguarde um momento.A reencaminhar página";
            header("refresh:5;url=index.php");
        }

    }//end if -if($con->connect_errno!=0)

}//if($_SERVER['REQUEST_METHOD']=="POST")
else{//else if($SERVER['REQUEST_METHOD']=="POST")
    ?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Adicionar festival</title>
    </head>
    <body>
        <h1>Adicionar festival</h1>
        <form action="festa_create.php" method="post">
            <label>id</label><input type="text" name="id" required><br>
            <label>festival</label><input type="text" name="festival"><br>
            <input type="submit" name="enviar"><br>

        </form>

    </body>
    </html>
    <?php
}//end if -if($SERVER['REQUEST_METHOD']=="POST")
?>
<?php
}
else{
    echo 'Para entrar nesta pagina necessita de efetuar<a href="login.php">login</a>';
    header('refresh:2;url=login.php');
}
?>