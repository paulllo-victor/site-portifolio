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

        public static function selectedAdmin()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `administrators` WHERE email = ?");
            $st->execute(array($_SESSION['email']));
            return $st->fetchAll();
        }

        public static function selectedAdministrators()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `administrators` WHERE email != ?");
            $st->execute(array($_SESSION['email']));
            return $st->fetchAll();
        }
        public static function selectedAdminUpdate($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `administrators` WHERE id = ?");
            $st->execute(array($id));
            return $st->fetchAll();
        }
        public function deleteAdministrators()
        {
            # code...
        }

        public static function createAdministrators($name,$email,$password,$image)
        {
            $con = Connection::conectar();

            if(strlen($name) <= 6){
                return functionsSite::alert('Name do cliente deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($email) <= 6 && filter_var($email,FILTER_VALIDATE_EMAIL)){
                return functionsSite::alert('Email invalido','error');
            }
            if(strlen($password) <= 6){
                return functionsSite::alert('Testemunho deve ter no mínimo de 6 caracteres','error');
            }

            $pathImg = self::uploadFile($image);

            if($pathImg == 'formato' || $pathImg == 'error' || $pathImg == 'size'){
                $messagem = null;
                switch ($pathImg) {
                    case 'formato':
                        $messagem = 'Formato do arquivo invalido, o arquivo deve ser no formato png,jpeg ou jpeg';
                        break;
                    case 'size':
                        $messagem = 'O tamanho máximo deve ser no máximo de 5MB';
                        break;
                    case 'error':
                        $messagem = 'Aconteceu um erro inesperado, tente novamente';
                        break;
                }
                return functionsSite::alert($messagem,'error');
            }

            $st = $con->prepare("INSERT INTO `administrators` VALUES (?,?,?,?,?)");
            $response = $st->execute(array('',$name,$email,$password,$pathImg));

            if($response){
                return  functionsSite::alert('Testemunho cadastrado com sucesso','success');
            }else{
                return  functionsSite::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
            }

        }

        public static function updateAdministrators($name,$email,$password,$image,$id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `administrators` WHERE id = ?");
            $st->execute(array($id));
            $response = $st->rowCount();

            if($response){
                $datas = $st->fetchAll();
                if(strlen($name) <= 6){
                    return functionsSite::alert('Name do cliente deve ter no mínimo de 6 caracteres','error');
                }
                if(strlen($email) <= 6 && filter_var($email,FILTER_VALIDATE_EMAIL)){
                    return functionsSite::alert('Email invalido','error');
                }
                if(strlen($password) <= 6){
                    return functionsSite::alert('Testemunho deve ter no mínimo de 6 caracteres','error');
                }
    
                $pathImg = $image['name'] != '' ? self::updateFile($datas[0]['photo'],$image) : $datas[0]['photo'];
    
                if($pathImg == 'formato' || $pathImg == 'error' || $pathImg == 'size'){
                    $messagem = null;
                    switch ($pathImg) {
                        case 'formato':
                            $messagem = 'Formato do arquivo invalido, o arquivo deve ser no formato png,jpeg ou jpeg';
                            break;
                        case 'size':
                            $messagem = 'O tamanho máximo deve ser no máximo de 5MB';
                            break;
                        case 'error':
                            $messagem = 'Aconteceu um erro inesperado, tente novamente';
                            break;
                    }
                    return functionsSite::alert($messagem,'error');
                }
    
                $st = $con->prepare("UPDATE `administrators` SET name = ?,email = ?, password = ?, photo = ? WHERE id = ?");
                $response = $st->execute(array($name,$email,$password,$pathImg,$id));
    
                if($response){
                    return  functionsSite::alert('Usuário cadastrado com sucesso','success');
                }else{
                    return  functionsSite::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
                }
            }else{
                return  functionsSite::alert('Ops, não foi possível editar esse usuário','error');
            }

        }

        public static function uploadFile($file)
        {
            $formatos = ['image/jpeg','image/jpg','image/png'];
            $sizeImagem = number_format($file['size']/1048576 , 2);

            if($sizeImagem < 5.0){
                if(in_array($file['type'],$formatos)){
                    $path = 'uploadFile/users/'.rand(1000000, 9999999) . str_replace('/','.',strstr($file['type'],'/'));
    
                    if(move_uploaded_file($file["tmp_name"],$path )){
                        return $path;
                    }else{
                        return 'error';
                    }
                }else{
                    return 'formato';
                }
            }else{
                return 'size';
            }
        }

        public function updateFile($oldFile, $newFile)
        {
            if(is_file($oldFile)){
                if(unlink($oldFile)){
                    return self::uploadFile($newFile);
                }else{
                    return false;
                }
            }else{
                return self::uploadFile($newFile);
            }
        }
    }