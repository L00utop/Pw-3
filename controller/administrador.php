<?php
    header('Content-type: application/json');
    $dadosRecebidos = file_get_contents('php://input');

    $dadosRecebidos = json_decode($dadosRecebidos, true);

    require_once '../model/Administrador.php';
    if($dadosRecebidos['acao'] == 'cadastrar'){
        $adm = new Administrador();
        $adm->matricula = $dadosRecebidos['matricula'];
        $adm->email = $dadosRecebidos['email'];
        $adm->senha = $dadosRecebidos['senha'];
        $adm->nome = $dadosRecebidos['nome'];        

        $result = [
            'result' => $adm->cadastrar(),
            'dados' => $adm       
        ];
        echo json_encode($result);
    }