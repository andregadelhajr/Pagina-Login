<?php

Class Usuario{

	private $pdo;

	//Construtor
	public function __construct($dbname, $host, $usuario, $senha)
	{
		try
		{
			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $usuario, $senha);
		} catch(PDOException $e) 
		{
			echo "Erro com BD: ".$e->getMessage();
		} catch(Exception $e)
		{
			echo "Erro: ".$e->getMessage();
		}
	}
	//cadastrar
	public function cadastrar($nome, $email, $senha)
	{
		//Antes de cadastrar verificar se ja esta cadastrado
		$cmd = $this->pdo->prepare("SELECT id from usuarios WHERE email = :e");
		$cmd->bindValue(":e",$email);
		$cmd->execute();
		if($cmd->rowCount() > 0)//veio id
		{
			return false;
		}else//nao veio id
		{
			//cadastrar
			$cmd = $this->pdo->prepare("INSERT INTO usuarios (nome, email, senha) values (:n, :e, :s)");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":e",$email);
			$cmd->bindValue(":s",md5($senha));
			$cmd->execute();
			return true;
		}
		
	}

	//logar
	public function entrar($email, $senha)
	{
		$cmd = $this->pdo->prepare("SELECT * from usuarios WHERE email = :e AND senha = :s");
		$cmd->bindValue(":e",$email);
		$cmd->bindValue(":s",md5($senha));
		$cmd->execute();
		if($cmd->rowCount() > 0)//se foi encontrado essa pessoa
		{
			$dados = $cmd->fetch();
			session_start();
			if($dados['id'] == 1)
			{
				//usuario administrador
				$_SESSION['id_master']  = 1;
			}else
			{
				//usuario normal
				$_SESSION['id_usuario'] = $dados['id'];
			}
			return true;//encontrada
		}else
		{
			return false;//não encontrada
		}
	}

	public function buscarDadosUser($id)
	{
		$cmd = $this->pdo->prepare("SELECT * from usuarios WHERE id = :id");
		$cmd->bindValue(":id",$id);
		$cmd->execute();
		$dados = $cmd->fetch();
		return $dados;
	}

	public function buscarTodosUsuarios()
	{
		$cmd = $this->pdo->prepare("SELECT usuarios.id, usuarios.nome, usuarios.email, COUNT(comentarios.id) as 'quantidade' from usuarios left join comentarios ON usuarios.id = comentarios.fk_id_usuario group by usuarios.id");
		$cmd->execute();
		$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $dados;
	}
}
?>