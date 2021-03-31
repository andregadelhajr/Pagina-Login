<?php
date_default_timezone_set('America/Sao_Paulo');
Class Comentario{

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

	public function buscarComentarios()
	{
		$dados = array();
		$cmd = $this->pdo->prepare("SELECT *,
		(SELECT nome from usuarios WHERE id = fk_id_usuario) as nome_pessoa FROM comentarios ORDER BY dia,horario DESC");
		$cmd->execute();
		$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $dados;
		// id,comentario,dia,horario, nome_pessoa
	}

	public function excluirComentario($id_comentario, $id_user)
	{
		if($id_user == 1)//adm
		{
			$cmd = $this->pdo->prepare("DELETE FROM comentarios WHERE id = :id_c");
			$cmd->bindValue(":id_c",$id_comentario);
			$cmd->execute();
		}else
		{
			$cmd = $this->pdo->prepare("DELETE FROM comentarios WHERE id = :id_c AND fk_id_usuario = :id_user");
			$cmd->bindValue(":id_c",$id_comentario);
			$cmd->bindValue(":id_user",$id_user);
			$cmd->execute();
		}
	}

	public function inserirComentario($id_pessoa, $comentario)
	{
		$cmd = $this->pdo->prepare("INSERT INTO comentarios (comentario, dia, horario, fk_id_usuario) 
			VALUES (:c, :d, :h, :fk)");
		$cmd->bindValue(":c",$comentario);
		$cmd->bindValue(":d",date('Y-m-d'));
		$cmd->bindValue(":h",date('H:i'));
		$cmd->bindValue(":fk",$id_pessoa);
		$cmd->execute();
	}
}
?>