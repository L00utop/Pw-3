<?php
    header('Content-type: application/json');

    $dadosEnviados = file_get_contents('php://input');
    $dadosEnviados = json_decode($dadosEnviados, true);

    $cxPdo = new PDO('mysql:host=localhost;port=3306;dbname=campeonato_futbol','root','');
    
  
    $busca = $dadosEnviados['busca'];
    $cmdSql = "SELECT jogo.id, jogo.data_hota, jogo.estadio, c1.nome as time, cj1.num_gols as gol_time, c2.nome as adversario, cj2.num_gols as gol_adversario FROM clube as c1, clube_em_jogo as cj1, jogo, clube_em_jogo as cj2, clube as c2 WHERE c1.nome = cj1.fk_clube AND cj1.fk_jogo = jogo.id AND jogo.id = cj2.fk_jogo AND cj2.fk_clube = c2.nome AND c1.nome <> c2.nome AND c1.nome = '$busca';";
       
    $cxPrepare = $cxPdo->prepare($cmdSql);
    $dados = [
        'result'=>false,
        'valores' => []
    ];

    if($cxPrepare->execute()){
        if($cxPrepare->rowCount() > 0){
            $dados['result'] = true;
            $dados['valores'] = $cxPrepare->fetchAll();
        }
    }

    echo json_encode($dados);