<?php

    class About{
        public static function createAbout($title,$body,$photo)
        {
            if(strlen($title) <= 6){
                return functionsSite::alert('Título deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($body) <= 6){
                return functionsSite::alert('Descrição deve ter no mínimo de 6 caracteres','error');
            }
            
            $pathImg = self::uploadFile($photo);

            if($pathImg == 'formato' || $pathImg == 'error' || $pathImg == 'size' || !$pathImg){
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
                    default:
                        $messagem = 'Aconteceu um erro inesperado, tente novamente';
                        break;
                }
                return functionsSite::alert($messagem,'error');
            }

            $con = Connection::conectar();
            $st = $con->prepare("INSERT INTO about VALUES (?,?,?,?)");
            $response = $st->execute(array('',$title,$pathImg,$body));

            if($response){
                return  functionsSite::alert('About criado com sucesso','success');
            }else{
                return  functionsSite::alert('About alterado com sucesso','error');
            }
        }

        public static function updateAbout($title,$body,$photo,$id)
        {

            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `about` WHERE id = ?");
            $st->execute(array($id));
            $response = $st->rowCount();

            if($response){
                $datas = $st->fetchAll();
                if(strlen($title) <= 6){
                    return functionsSite::alert('Título deve ter no mínimo de 6 caracteres','error');
                }
                if(strlen($body) <= 6){
                    return functionsSite::alert('Descrição deve ter no mínimo de 6 caracteres','error');
                }
                
                $pathImg = $photo['name'] != '' ? self::updateFile($datas[0]['photo'],$photo) : $datas[0]['photo'];
    
                if($pathImg == 'formato' || $pathImg == 'error' || $pathImg == 'size' || !$pathImg){
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
                        default:
                            $messagem = 'Aconteceu um erro inesperado, tente novamente';
                            break;
                    }
                    return functionsSite::alert($messagem,'error');
                }
    
                $con = Connection::conectar();
                $st = $con->prepare("UPDATE about SET title = ?, photo = ?, body = ? WHERE id = ?");
                $st->execute(array($title,$pathImg,$body,$id));
    
                if($st->rowCount()){
                    return  functionsSite::alert('About editado com sucesso','success');
                }else{
                    return  functionsSite::alert('Não foi possível fazer fazer a alteração','error');
                }
            }else{
                return  functionsSite::alert('Ops, não foi possível editar esse About','error');
            }
        }

        public static function uploadFile($file){
            $formatos = ['image/jpeg','image/jpg','image/png'];
            $sizeImagem = number_format($file['size']/1048576 , 2);

            if($sizeImagem < 5.0){
                if(in_array($file['type'],$formatos)){
                    $path = 'uploadFile/about/'.rand(1000000, 9999999) . str_replace('/','.',strstr($file['type'],'/'));
    
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

        public static function selectedAbout()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `about` LIMIT 1");
            $st->execute();

            return $st->fetchAll();
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