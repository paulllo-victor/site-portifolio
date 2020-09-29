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
            
                $st->execute(array(null,$login,crypt(rand(100000,9999999)),$_SERVER['REMOTE_ADDR'],date("Y-m-d h:i:s")));

                if($st->rowCount() != 0){
                    $user = $con->prepare("SELECT * FROM `administrators_online` WHERE email = ?");
                    $user->execute(array($login));

                    $user = $user->fetch();
                    $_SESSION["token_session"] = $user['token_session'];
                    $_SESSION["email"] = $user['email'];
                    $_SESSION["login"] = true;

                    return true;
                }else{
                    return false;
                }
            }      
            //DELETAR O TOKEN CADASTRADOS NO BANCO E CHAMAR A FUNCÇÃO NOVAMENTE      
            // return true;
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

        
    }