<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Sistema de Comentarios</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="CSS/entrar.css">
</head>
<body>
	<span>Andre<br>Sistema Ninja</span>
	<form method="POST">
		<h1>Acesse a sua conta</h1>
		<img src="IMAGENS/envelope.png">
		<input type="email" name="email" autocomplete="off" maxlength="40">
		<img src="IMAGENS/cadeado.png">
		<input type="password" name="senha">
		<input type="submit" value="ENTRAR">
		<a href="cadastrar.php">Registre-se agora!</a>
	</form>
</body>
</html>

<?php

if(isset($_POST['email']))
{
	$email = addslashes($_POST['email']);
	$senha = addslashes($_POST['senha']);
	if(!empty($email) && !empty($senha))
	{
		require_once 'CLASSES/usuarios.php';
		$us = new Usuario("projeto_comentarios","localhost","root","");
		if($us->entrar($email, $senha))
		{
			header("location: index.php");
		}else
		{
			echo "Email e/ou senha estão incorretos!";
		}
	}else
	{
		echo "Preencha todos os campos!";
	}
}

?>