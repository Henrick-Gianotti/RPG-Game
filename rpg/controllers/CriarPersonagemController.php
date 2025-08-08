<?php

class CriarPersonagemController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar(int $id_usuario, string $nome_personagem, int $classe_id) 
    {
        if (empty($nome_personagem))
        {
            return "Por favor, insira o nome do seu personagem";
        }
        if ($classe_id <= 0)
        {
            return "Por favor, selecione uma classe";
        }
        if (strlen($nome_personagem) > 50)
        {
            return "O nome do personagem é muito longo (máximo 50 caracteres).";
        }
        
        try
        {
            $sql_count = "SELECT COUNT(id) FROM personagem WHERE id_usuario = :id_usuario";
            $stmt_count = $this->pdo->prepare($sql_count);
            $stmt_count->execute([':id_usuario' => $id_usuario]);
            
            if ($stmt_count->fetchColumn() >= 3)
            {
                return "Você já atingiu o limite de 3 personagens por conta.";
            }

            $sql_classe = "SELECT nome, hp, mp FROM classe WHERE id = :id_classe LIMIT 1";
            $stmt_classe = $this->pdo->prepare($sql_classe);
            $stmt_classe->execute([':id_classe' => $classe_id]);
            $stats_classe = $stmt_classe->fetch();

            if (!$stats_classe) {
                return "A classe selecionada é inválida.";
            }
            
            $sql_insert = "INSERT INTO personagem (nome, classe, gold, hp_maximo, hp_atual, mp_maximo, mp_atual, id_usuario) VALUES (:nome, :classe, 0, :hp_maximo, :hp_atual, :mp_maximo, :mp_atual, :id_usuario)";
            
            $stmt_insert = $this->pdo->prepare($sql_insert);
            
            $stmt_insert->execute([
                ':nome' => $nome_personagem,
                ':classe' => $stats_classe['nome'],
                ':hp_maximo' => $stats_classe['hp'],
                ':hp_atual' => $stats_classe['hp'],
                ':mp_maximo' => $stats_classe['mp'],
                ':mp_atual' => $stats_classe['mp'],
                ':id_usuario' => $id_usuario
            ]);

            return true;

        } catch (PDOException $e)
        {
            if ($e->getCode() == '23000')
            { // 1062 é o código de erro para entrada duplicada
                return "Este nome de personagem já está em uso.";
            }
            
            error_log("Erro ao criar personagem: " . $e->getMessage());
            return "Ocorreu um erro inesperado no banco de dados.";
        }
    }
}