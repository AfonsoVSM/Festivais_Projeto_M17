<?php

session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto"&& isset($_SESSION['login'])){
    //conteúdo

if ($_SERVER['REQUEST_METHOD']=="GET") {
    if (isset($_GET['artista'])&& is_numeric($_GET['artista'])) {
        $idArtista=$_GET['artista'];
        $con=new mysqli("localhost","root","","festa");

        if ($con->connect_errno!=0) {
                echo "<h1>Ocorreu um erro no acesso a base de dados.<br>".$connect_error."</h1>";
                exit();
        }
        $sql="Select * from artista where id=?";
        $stm=$con->prepare($sql);
        if ($stm!=false) {
                $stm->bind_param("i",$idArtista);
                $stm->execute();
                $res=$stm->get_result();
                $artista=$res->fetch_assoc();
                $stm->close();
        }

                  ?>
      <!DOCTYPE html>
      <html>
      <head>
          <title>Editar Festivais</title>
      </head>
      <body>
      <h1>Editar Festivais</h1>


<form action="artista_update.php?artista=<?php  echo $artista['id']; ?>" method="post">
<label>id</label><input type="text" name="id" required value="<?php echo $artista['id'];?>"><br>
<label>nome</label><input type="text" name="nome" required value="<?php echo $artista['nome'];?>"><br>
<label>data</label><input type="data" name="data" required value="<?php echo $artista['data'];?>"><br>
<input type="hidden" name="id" value="<?php echo $artista['id'];?>"><br>
<input type="hidden" name="id_festa" required value="<?php echo $artista['id'];?>">
<input type="submit" name="enviar"><br>
</form>


      </body>
      </html>
      <?php
    }
else{
    echo ("<h1>houve um erro ao precessar o seu pedido.<br> Dentro de segundos sera reencaminhado!</h1>");
    header("refresh:5; url=index.php");
    }
    }


}
else{
    echo "Para entrar nesta página necessita de efetuar <a href='login.php'>login</a>";
    header('refresh:2;url=login.php');
}
?>