<?php
include '../../config.php';
verificaAcesso();

if (!empty($_POST)) {
    $titulo  = $_POST['tituloPub'];
    $autores = $_POST['autoresPub'];
    $genero  = $_POST['generoPub'];
    $texto   = $_POST['textoPub'];
    $poema   = $_POST['poema'];
    $usuario = $_SESSION['usuario'];

    if(empty($titulo)){
        $mensagem = " campo obrigatório!";
        header('Location: ' . arquivo('modulos/publicacao/inserir.php?mensagem=' . $mensagem));
        exit();
    }
    
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO publicacoes (tituloPub, autoresPub, generoPub, textoPub, poema, id_usuario) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql); 
    $q->execute(array( $titulo, $autores, $genero, $texto, $poema,  $usuario));

    $id = $pdo->lastInsertId();
    Banco::desconectar();

    if(!empty($id)){
        header("Location: visualizar.php?IdPub=$id");
    }else{
        header('Location: inserir.php');
    }
}
