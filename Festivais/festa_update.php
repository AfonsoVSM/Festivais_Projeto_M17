<?php

if($_SERVER['REQUEST_METHOD']='POST'){
	$id="";
	$Festival="";

	if(isset($_POST['id'])){
		$id=$_POST['id'];
	}
	else{
		echo '<script>alert("É obrigatorio o preenchimento do id.");</script>';
	}
	if(isset($_POST['Festivais'])){
		$Festival = $_POST['Festivais'];
}

$con = new mysqli("localhost","root","","festa");

if($con->connect_errno!=0){
	echo "Ocorreu um erro no acesso à base de dados.<br>". $con->connect_error;
	exit;
}
else{
	$sql= "update Festivais set festival=? where id=?";
	$stm = $con->prepare ($sql);

	if($stm!=false){
		$stm->bind_param("si",$Festival,$id);
		$stm->execute();
		$stm->execute();
		$stm->close();

		echo '<script>alert("Festival alterado com sucesso!!");</script>';
		echo "Aguarde um momento.A reencaminhar página";
		header('refresh:5;url=index.php');

	}
	else{
}
	}
}
else{
	echo "<h1>Houve um erro ao processar o seu pedido! <br>Irá ser reencaminhado!</h1>";
	header("refresh:5; url=index.php");
}