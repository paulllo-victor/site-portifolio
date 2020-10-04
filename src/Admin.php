<?php
    require "../vendor/autoload.php";

    class Admin{
        public static function logar($login, $password)
        {
            $con =  Connection::conectar();
            $st = $con->prepare("SELECT * FROM administrators WHERE email = ? AND password = ?");
            $st->execute(array($login, $password));

            if($st->fetch() != 0){
                if(self::administratorOnline($login)){                    
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public static function administratorOnline($login)
        {
            $con =  Connection::conectar();
            $user = $con->prepare("SELECT * FROM `administrators_online` WHERE email = ?");
            $user->execute(array($login));

            if($user->fetch() == 0){
                $st = $con->prepare("INSERT INTO administrators_online values (?,?,?,?,?)");
            
                $st->execute(array(null,$login, password_hash(rand(100000,9999999),PASSWORD_DEFAULT),$_SERVER['REMOTE_ADDR'],date("Y-m-d h:i:s")));

                if($st->rowCount() != 0){
                    $user = $con->prepare("SELECT * FROM `administrators_online` WHERE email = ?");
                    $user->execute(array($login));

                    $user = $user->fetch();
                    $_SESSION["token_session"] = $user['token_session'];
                    $_SESSION["email"] = $user['email'];
                    $_SESSION["login"] = true;

                    return true;
                }else{
                    self::deslogar($login);
                    return false;
                }
            }  
            
            if(self::deslogar($login)){
                self::administratorOnline($login);
            }
        }

        public static function verificarToken($email,$token)
        {
            $con =  Connection::conectar();
            $user = $con->prepare("SELECT * FROM `administrators_online` WHERE email = ? and token_session = ?");
            $user->execute(array($email, $token));
            if($user->fetch() > 0){
                return true;
            }else{
                return false;
            }
        }

        public static function deslogar($email)
        {
            $con = Connection::conectar();
            $st = $con->prepare("DELETE FROM  `administrators_online` WHERE email = ?");
            $st->execute(array($email));
            session_destroy();
            return true;
        }
        
        public static function countAdministratoresOnlines()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `administrators_online`");
            $st->execute();
            return $st->fetchAll();
        }
        
    }