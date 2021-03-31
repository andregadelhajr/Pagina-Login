<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Sistema de Comentarios</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="CSS/cadastrar.css">
</head>
<body>
	<form method="POST">
		<h1>CADASTRE-SE</h1>
		<label for="nome">NOME</label>
		<input type="text" name="nome" id="nome" maxlength="40">
		<label for="email">EMAIL</label>
		<input type="email" name="email" autocomplete="off" id="email" maxlength="40">
		<label for="senha">SENHA</label>
		<input type="password" name="senha" id="senha">
		<label for="confSenha">CONFIRMAR SENHA</label>
		<input type="password" name="confSenha" id="confSenha">
		<input type="submit" value="cadastrar">
	</form>
</body>
</html>

<!--========================== PHP ==========================-->

<?PHP
// 1 - VERIFICAR SE ELA APERTOU O BOTAO CADASTRAR - ok
// 2 - GUARDAR DADOS DENTRO DE VARIAVEIS e verificar se esta vazia - ok
// 3 - ENVIAR DADOS COLHIDOS PARA A CLASSE , FUNCAO CADASTRAR
// 4 - VERIFICAR O RETORNO FALSE OU TRUE

if(isset($_POST['nome']))
{

	$nome = addslashes($_POST['nome']);
	$email = addslashes($_POST['email']);
	$senha = addslashes($_POST['senha']);
	$confSenha = addslashes($_POST['confSenha']);

	if(!empty($nome) && !empty($email) && !empty($senha) && !empty($confSenha))
	{
		if($senha == $confSenha)
		{
			require_once 'CLASSES/usuarios.php';
			$us = new Usuario("projeto_comentarios","localhost","root","");
			if($us->cadastrar($nome, $email, $senha))
			{ ?>
				<p class="mensagem">Cadastrado com sucesso!<a href="entrar.php">Acesse já!</a></p> 
<?php		}else
			{ ?>
				<p class="mensagem">Email já está cadastrado!</p>
<?php		}
		}else
		{ ?>
			<p class="mensagem">Senhas não correspondem!</p>
<?php	}	
	}else
	{ ?>
		<p class="mensagem">Preencha todos os campos!</p>
<?php }
}
?>