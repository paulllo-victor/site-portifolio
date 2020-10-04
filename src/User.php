<?php
    class User{
        public static function acesso()
        {
            self::userInativo();
            
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `users_onlines` WHERE ip = ?");
            $st->execute(array($_SERVER['REMOTE_ADDR']));

            if($st->fetchAll()){
                $st = $con->prepare('UPDATE `users_onlines` SET ip = ?, `create_at` = ? WHERE ip = ?');
                $st->execute(array($_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SERVER["REMOTE_ADDR"]));
            }else{
                $st = $con->prepare("INSERT INTO `users_onlines` VALUES (?,?,?) ");
                $st = $st->execute(array('',$_SERVER['REMOTE_ADDR'],date('Y-m-d H:i:s'))); 
            }
            
            $st = $con->prepare("SELECT * FROM `users_onlines` WHERE ip = ?");
            $st->execute(array($_SERVER['REMOTE_ADDR']));
            return $st->fetchAll();
        }

        public static function userInativo()
        {
            $date = date('Y-m-d H:i:s');
            $st = Connection::conectar()->exec("DELETE FROM `users_onlines` WHERE `create_at` <  '$date' - INTERVAL 1 MINUTE");
        }
    }