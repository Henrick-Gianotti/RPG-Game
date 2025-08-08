<?php
require_once 'config/database.php';

// Verifica se o usuário está logado e se um ID de personagem foi passado pela URL
if (!isset($_SESSION['id_usuario']) || !isset($_POST['id_personagem']))
{
    header("Location: " . BASE_URL . "/login");
    exit();
}

$id_personagem = (int)$_POST['id_personagem'];
$id_usuario = $_SESSION['id_usuario'];

// Verifica se o personagem tem o id do usuario
$sql = "SELECT id FROM personagem WHERE id = :id_personagem AND id_usuario = :id_usuario LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_personagem' => $id_personagem, ':id_usuario' => $id_usuario]);
$personagem_valido = $stmt->fetch();

if ($personagem_valido)
{
    // Armazena o ID do personagem ativo na sessão
    $_SESSION['personagem_id'] = $personagem_valido['id'];
    
    // Redireciona para a página principal do personagem
    header("Location: ". BASE_URL ."/personagem");
    exit();
} else
{
    // volta para a seleção de personagem caso dê errado
    header("Location: ". BASE_URL ."/selecao_personagem");
    exit();
}