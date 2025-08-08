<?php
session_start();
// URL base
define('BASE_URL', '/rpg');

// pega URL do htaccess ou manda string vazia 
$request_path = $_GET['path'] ?? '';

// Limpar as /
$path = '/' . trim($request_path, '/');


$routes =
[
    //main routes
    '/' => 'pages/home.php',
    '/home' => 'pages/home.php',
    '/login' => 'pages/login.php',
    '/cadastro' => 'pages/cadastro.php',
    '/criar_personagem' => 'pages/criar_personagem.php',
    '/selecao_personagem' => 'pages/selecao_personagem.php',
    '/personagem' => 'pages/personagem.php',
    '/personagem/{nome}' => 'pages/personagem.php', 
    '/floresta' => 'pages/floresta.php',
    '/mineracao' => 'pages/mineracao.php',
    '/combate' => 'pages/combate.php',

    //actions routes
    '/cadastrar_personagem' => 'actions/cadastrar_personagem.php',
    '/selecionar_personagem' => 'actions/selecionar_personagem.php',
    '/deletar_personagem' => 'actions/deletar_personagem.php',
    '/logout' => 'actions/logout.php',
    '/deletar_usuario' => 'actions/deletar_usuario.php'
];

$route_found = false;
foreach ($routes as $route_pattern => $file_path)
{
    // Regex para manipulação do texto
    $route_regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_ -%]+)', $route_pattern);
    
    // Verifica se a URL digitada é padrão, igual da rota
    if (preg_match('#^' . $route_regex . '$#', $path, $matches))
    {
        // Se for igual, ele irá incluir a page e montar a URL baseada no nome do personagem digitado
        require $file_path;
        $route_found = true;
        break;
    }
}

if (!$route_found)
{
    http_response_code(404);
    require 'pages/404.php';
}
?>