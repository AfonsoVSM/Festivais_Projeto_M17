<?php

session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto"&& isset($_SESSION['login'])){
    //conteúdo

if ($_SERVER['REQUEST_METHOD']=="GET") {
    if (isset($_GET['festa'])&& is_numeric($_GET['festa'])) {
        $idFesta=$_GET['festa'];
        $con=new mysqli("localhost","root","","festa");

        if ($con->connect_errno!=0) {
                echo "<h1>Ocorreu um erro no acesso a base de dados.<br>".$connect_error."</h1>";
                exit();
        }
        $sql="Select * from festivais where id=?";
        $stm=$con->prepare($sql);
        if ($stm!=false) {
                $stm->bind_param("i",$idFesta);
                $stm->execute();
                $res=$stm->get_result();
                $festa=$res->fetch_assoc();
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


<form action="festa_update.php"method="post">
<label>id</label><input type="text" name="id" required value="<?php echo $festa['id'];?>"><br>
<label>Festivais</label><input type="text" name="Festivais" required value="<?php echo $festa['festival'];?>"><br>
<input type="hidden" name="id" value="<?php echo $festa['id'];?>"><br>
<input type="hidden" name="id_festa" required value="<?php echo $festa['id'];?>">
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