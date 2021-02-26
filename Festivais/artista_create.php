<?php
session_start();
if(!isset($_SESSION['login'])){
    $_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto" && isset($_SESSION['login'])){
    if($_SERVER['REQUEST_METHOD']=="POST"){
    $id="";
    $nome="";
    $data="";

    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    else{
        echo '<scipt>alert("É obrigatorio o preenchimento do id.");</script>';
    }
    if(isset($_POST['nome'])){
        $nome = $_POST['nome'];

     }
    if(isset($_POST['data'])){
        $data = $_POST['data'];
    }
        
    $con = new mysqli("localhost","root","","festa");
    if($con->connect_errno!=0){
        echo "Ocorreu um erro no acesso á base de dados.<br>".$con->connect_error;
        exit;
    }
    else {
        $sql = 'insert into artista(id,nome,data) values (?,?,?)';
        $stm = $con->prepare ( $sql);
        if($stm!=false){
            $stm->bind_param('isi',$id,$nome,$data);
            $stm->execute();
            $stm->close();

            echo '<script>alert("Artista adicionado com sucesso");</script>';
            echo "Aguarde um momento.A reencaminhar página";
            header("refresh:5;url=index.php");

        }
        else{
            echo ($con->error);
            echo  "Aguarde um momento.A reencaminhar página";
            header("refresh:5;url=index.museus.php");
        }

    }//end if -if($con->connect_errno!=0)

}//if($_SERVER['REQUEST_METHOD']=="POST")
else{//else if($SERVER['REQUEST_METHOD']=="POST")
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Adicionar Artista</title>
    </head>
    <body>
        <h1>Adicionar Artista</h1>
        <form action="artista_create.php" method="post">
            <label>id</label><input type="text" name="id" required><br>
            <label>nome</label><input type="text" name="nome"><br>
            <label>data</label><input type="text" name="data"><br>
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