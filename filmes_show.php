<?php 
session_start();
if (!isset($_SESSION['login'])) {
	$_SESSION['login']="incorreto";
}
if($_SESSION['login']=="correto"&& isset($_SESSION['login'])){
	//conteúdo

 ?>



<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="fa/css/all.css">
	<script type="text/javascript" src="fa/js/all.js"></script>
	 <script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<?php 

if ($_SERVER['REQUEST_METHOD']=="GET") {
	if (!isset($_GET['filme'])|| !is_numeric($_GET['filme'])) {
		echo "<script>alert('Erro ao abrir livro');</script>";
		echo "Aguarde um momento.A reencaminhar pagina";
		header("refresh:5;url=index.php");
	}
	$idFilme=$_GET['filme'];
	$con=new mysqli("localhost","root","","filmes");

	if ($con->connect_errno!=0) {
		echo "Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error;
		exit;
	}
	else{
		$sql='select * from filmes where id_filme= ?';
		$stm=$con->prepare($sql);
		if ($stm!=false) {
			$stm->bind_param('i',$idFilme);
			$stm->execute();
			$res=$stm->get_result();
			$filme=$res->fetch_assoc();
			$stm->close();

		}
		else{
			echo "<br>";
			echo ($con->error);
			echo "<br>";
			echo "Aguarde um momento. A reencaminhar pagina";
			echo "<br>";
			header("refresh:5; url=index.php");
		}
	}//end if 
}//if($_server...)
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Detalhes</title>
</head>
<body>
<h1>Detalhes do filme</h1>
<?php 
if (isset($filme)) {
	echo "<br>";
	echo utf8_encode($filme['titulo']);
	echo "<br>";
	echo utf8_encode($filme['sinopse']);
	echo "<br>";
	echo $filme['idioma'];
	echo "<br>";
	echo $filme['data_lancamento'];
	echo "<br>";
	echo $filme['quantidade'];
	echo "<br>";
}
else{
 echo "<h2>Parece que o filme selecionado nao existe. <br> confirme a sua seleção</h2>";
}

?>

</body>
</html>



<?php
}
else{
	echo "Para entrar nesta página necessita de efetuar <a href='login.php'>login</a>";
	header('refresh:2;url=login.php');
}
  ?>