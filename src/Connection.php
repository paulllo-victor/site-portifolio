<?php 
    class Connection{

        private static $pdo;

        public static function conectar(){
            if(self::$pdo == null){
                try {
                    //DEVE SER APENAS DOIS PARAMETROS
                    self::$pdo = new \PDO("mysql:host=".HOST.";dbname=".DBNAME,USER,PASSWORD, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                    
                    //METODO PARA HABILITAR A VISUALIZAÇÃO DOS ERRORS NO BANCO, POR DEFAULT ELE VEM EM SILENT
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    
                } catch (\Throwable $th) {
                    echo 'ops, ocorreu um erro tente mais tarte'.$th;
                }
    
            }            
            return self::$pdo;
        }
    }