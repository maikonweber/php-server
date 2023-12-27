<?php


$tarefas = [];


function obterTarefas() {
    global $tarefas;
    return json_encode($tarefas);
}


function adicionarTarefa($titulo) {
    global $tarefas;
    $novaTarefa = ['id' => uniqid(), 'titulo' => $titulo];
    $tarefas[] = $novaTarefa;
    return json_encode($novaTarefa);
}


function atualizarTarefa($id, $titulo) {
    global $tarefas;
    foreach ($tarefas as &$tarefa) {
        if ($tarefa['id'] === $id) {
            $tarefa['titulo'] = $titulo;
            return json_encode($tarefa);
        }
    }
    return json_encode(['erro' => 'Tarefa não encontrada']);
}


function excluirTarefa($id) {
    global $tarefas;
    foreach ($tarefas as $indice => $tarefa) {
        if ($tarefa['id'] === $id) {
            unset($tarefas[$indice]);
            return json_encode(['mensagem' => 'Tarefa excluída com sucesso']);
        }
    }
    return json_encode(['erro' => 'Tarefa não encontrada']);
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo obterTarefas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents("php://input"), true);
    echo adicionarTarefa($dados['titulo']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $dados = json_decode(file_get_contents("php://input"), true);
    echo atualizarTarefa($dados['id'], $dados['titulo']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $dados = json_decode(file_get_contents("php://input"), true);
    echo excluirTarefa($dados['id']);
}
