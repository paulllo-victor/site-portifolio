<?php

    class Portifolio{
        public static function createPortifolio($title,$category,$image)
        {
            $con = Connection::conectar();

            if(strlen($title) <= 6){
                return functionsSite::alert('Título deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($category) <= 6){
                return functionsSite::alert('Categória deve ter no mínimo de 6 caracteres','error');
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

            $st = $con->prepare("INSERT INTO `portifolio` VALUES (?,?,?,?,?)");
            $response = $st->execute(array('',$title,$category,$pathImg, date('Y-m-d H:i:s')));

            if($response){
                return  functionsSite::alert('Banner cadastrado com sucesso','success');
            }else{
                return  functionsSite::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
            }
        }


        public function listProtifolios()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `portifolio`");
            $st->execute();

            return $st->fetchAll();
        }

        public static function deletePortifolio($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("DELETE FROM `portifolio` WHERE id = ?");
            $st->execute(array($id));

            return header('Location: ' .PATH_PAINEL.'listPortifolio.php');
        }

        public static function selectPortifolio($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `portifolio` WHERE id = ?");
            $st->execute(array($id));

            if($st->rowCount() > 0){
                return $st->fetchAll();
            }else{
                return false;
            }
        }

        public static function updatePortifolio($id, $title, $category,$image)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `portifolio` WHERE id = ?");
            $st->execute(array($id));
            $response = $st->rowCount();

            if($response){
                $datas = $st->fetchAll();
                if(strlen($title) <= 6){
                    return functionsSite::alert('Título deve ter no mínimo de 6 caracteres','error');
                }
                if(strlen($category) <= 6){
                    return functionsSite::alert('Categória deve ter no mínimo de 6 caracteres','error');
                }

                $pathImg = self::updateFile($datas[0]['image'],$image);
    
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

                $st = $con->prepare("UPDATE `portifolio` SET title = ?, category = ?, image = ?");
                $st->execute(array($title,$category,$pathImg));

                if($st->rowCount()){
                    return functionsSite::alert('deu tudo certinho','success');
                }else{
                    return functionsSite::alert('Ops deu algo de errado','error');
                }
            }else{
                return  functionsSite::alert('Ops, não existe nenhum portifolio com esse id','error');
            }
        }

        public static function uploadFile($file)
        {
            $formatos = ['image/jpeg','image/jpg','image/png'];
            $sizeImagem = number_format($file['size']/1048576 , 2);

            if($sizeImagem < 5.0){
                if(in_array($file['type'],$formatos)){
                    $path = 'uploadFile/portifolio/'.rand(1000000, 9999999).str_replace('/','.',strstr($file['type'],'/'));
    
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