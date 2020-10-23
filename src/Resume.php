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

    }