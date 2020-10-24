<?php

    Class Resume{

        public static function createResume($title,$body,$location,$category)
        {
            $con = Connection::conectar();

            if(strlen($title) < 6){
                return functionsSite::alert('Título deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($body) < 6){
                return functionsSite::alert('Descrição deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($body) < 6){
                return functionsSite::alert('Selecione uma categoria','error');
            }

            $st = $con->prepare("INSERT INTO resume VALUES (?,?,?,?,?,?)");
            $response = $st->execute(array('',$title,$body,$location,$category, date("Y-m-d")));

            if($response){
                return functionsSite::alert('Resume cadastrado com sucesso','success');
            }else{
                return functionsSite::alert('Ops, ocorreu um erro no cadastrado, verifique os dados informados e tente novamente','error');
            }
        }

        public static function updateResume($title,$body,$location,$category,$id)
        {
            $con = Connection::conectar();

            if(strlen($title) < 6){
                return functionsSite::alert('Título deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($body) < 6){
                return functionsSite::alert('Descrição deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($body) < 6){
                return functionsSite::alert('Selecione uma categoria','error');
            }

            $st = $con->prepare("UPDATE resume SET title = ?, body = ?, location = ?, category = ? WHERE id = ?");
            $response = $st->execute(array($title,$body,$location,$category,$id));

            if($response){
                return functionsSite::alert('Resume cadastrado com sucesso','success');
            }else{
                return functionsSite::alert('Ops, ocorreu um erro no cadastrado, verifique os dados informados e tente novamente','error');
            }
        }

        public static function deleteResume($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("DELETE FROM resume WHERE id = ?");
            $st->execute(array($id));

            return header("Location: ".PATH_PAINEL.'listResume.php');
        }

        public static function selectResume($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM resume WHERE id = ?");
            $st->execute(array($id));

            if($st->rowCount() > 0){
                return $st->fetchAll();
            }else{
                return false;
            }
        }
    }