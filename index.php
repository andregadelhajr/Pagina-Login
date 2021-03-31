<?php
	require_once 'CLASSES/usuarios.php';
	session_start();
	if(isset($_SESSION['id_usuario']))
	{
		$us = new Usuario("projeto_comentarios","localhost","root","");
		$informacoes = $us->buscarDadosUser($_SESSION['id_usuario']);
	}elseif(isset($_SESSION['id_master']))
	{
		$us = new Usuario("projeto_comentarios","localhost","root","");
		$informacoes = $us->buscarDadosUser($_SESSION['id_master']);
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Sistema de Comentarios</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="CSS/estilo.css"/>
</head>
<body>
	<nav>
		<ul>
			<?php
				if(isset($_SESSION['id_master']))
				{ ?>
					<li><a href="dados.php">Dados</a></li>
	<?php		}
			?>
			<li><a href="discussao.php">Discussão</a></li>
			<?php
				if(isset($informacoes))//tem uma sessao, tem uma pessoa logada
				{ ?>
					<li><a href="sair.php">Sair</a></li>
	<?php		}
				else
				{ ?>
					<li><a href="entrar.php">Entrar</a></li>
	<?php		}
			?>		
		</ul>
	</nav>
	<?php

	 if (isset($_SESSION['id_master']) || isset($_SESSION['id_usuario']))
	 { ?>
		<h2>
			<?php 
			echo "Olá! "; 
			echo $informacoes['nome'];
			echo " ,seja bem vindo(a)!";
			?>
		</h2>
<?php }
	?>
	<h3>CONTEÚDO QUALQUER</h3>
</body>
</html>