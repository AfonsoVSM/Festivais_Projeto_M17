<?php
if($_SERVER['REQUEST_METHOD']=="GET"){


	if (!isset($_GET['festas']) || !is_numeric($_GET['festas'])) {
		echo '<script>alert("Erro ao abrir festa");</script>';
		echo 'Aguarde um momento. A reencaminhar página';
		header("refresh:5; url=index.php");
		exit();

	}
	$idFesta=$_GET['festas'];
	$con=new mysqli("localhost", "root", "","festa");

	if($con->connect_errno!=0){
		echo "Ocorreu um erro no acesso á base de dados.<br>" .$con->connect_error;
		exit;
	}
	else{
		$sql='select * from festivais where id = ?';
		$stm = $con->prepare ($sql);
		if ($stm!=false) {
			$stm->bind_param("i", $idFesta);
			$stm->execute();
			$res=$stm->get_result();
			$festa = $res->fetch_assoc();
			$stm->close();
		}
		else{
			echo '<br>';
			echo ($con->error);
			echo '<br>';
			echo "Aguarde um momento. A reencaminhar página";
			echo '<br>';
			header("refresh:5;url=index.php");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>Detalhes</title>
</head>
<body>
<h1>Detalhes do festa</h1>
<?php

	if(isset($festa)){
		echo '<br>';
		echo utf8_encode( $festa['id']);
		echo '<br>';
		echo utf8_encode($festa['festival']);
		echo '<br>';
	}
else{
	echo '<h2>Parece que o festa selecionado nao existe. <br>Confirme a sua seleção.</h2>';
}
 ?>
</body>
</html>