<?php
if($_SERVER['REQUEST_METHOD']=="GET"){


	if (!isset($_GET['artista']) || !is_numeric($_GET['artista'])) {
		echo '<script>alert("Erro ao abrir artista");</script>';
		echo 'Aguarde um momento. A reencaminhar página';
		header("refresh:5; url=index.php");
		exit();

	}
	$idArtista=$_GET['artista'];
	$con=new mysqli("localhost", "root", "","festa");

	if($con->connect_errno!=0){
		echo "Ocorreu um erro no acesso á base de dados.<br>" .$con->connect_error;
		exit;
	}
	else{
		$sql='select * from artista where id=?';
		$stm = $con->prepare ($sql);
		if ($stm!=false) {
			$stm->bind_param("i", $idArtista);
			$stm->execute();
			$res=$stm->get_result();
			$artista = $res->fetch_assoc();
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
<h1>Detalhes do artista</h1>
<?php

	if(isset($artista)){
		echo '<br>';
		echo utf8_encode( $artista['id']);
		echo '<br>';
		echo utf8_encode($artista['nome']);
		echo '<br>';
		echo utf8_encode($artista['data']);
		echo '<br>';
	}
else{
	echo '<h2>Parece que o artista selecionado nao existe. <br>Confirme a sua seleção.</h2>';
}
 ?>
</body>
</html>