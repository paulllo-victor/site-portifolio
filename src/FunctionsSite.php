<?php 

    class functionsSite{
        

        public function alert($mensagem, $option = null)
        {
            $div = null;

            if($option == 'success'){
                $div = ' <div class="div-alert success">'.$mensagem.'</div>';
            }else if($option == 'error'){
                $div = ' <div class="div-alert error">'.$mensagem.'</div>';
            }else {
                $div = ' <div class="div-alert default">'.$mensagem.'</div>';
            }
            return $div;
        }

        public static function createBanner($nome,$title,$subtitle,$active,$img_banner)
        {   
            
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `banners` WHERE active = 1");
            $st->execute();

            if($st->rowCount() > 0 && $active == 1){
                return self::alert('erro, já existe um banner ativo!','error');
            }else{
                $pathImg = self::uploadFile($img_banner);

                if($nome == '' || strlen($nome) < 6){
                    return self::alert('Nome curto demais, o nome deve ter no minimo 6 caracteres','error');
                }else if($title == '' || strlen($title) < 6){
                    return self::alert('Titúlo curto demais, o titúlo deve ter no minimo 6 caracteres','error');
                }else if($active == '' || ($active != '1' && $active != '0')){
                    return self::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
                }else if($pathImg == 'formato' || $pathImg == 'error' || $pathImg == 'size'){
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
                    return self::alert($messagem,'error');
                }else{
                    $st = $con->prepare("INSERT INTO `banners` VALUES (?,?,?,?,?,?,?)");

                    $response = $st->execute(array('',$nome,$title,$subtitle,$active,$pathImg,date('Y-m-d H:i:s')));

                    if($response){
                        return  self::alert('Banner cadastrado com sucesso','success');
                    }else{
                        return  self::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
                    }
                }
            }
            
        }

        public static function selectSlider($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `banners` WHERE id = ?");
            $st->execute(array($id));

            if($st->rowCount() > 0){
                return $st->fetchAll();
            }else{
                return false;
            }
        }

        public static function updateSlider($id,$nome,$title,$subtitle,$active,$img_banner)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `banners` WHERE id = ?");
            $st->execute(array($id));            
            $response = $st->fetchAll();

            if($response){
                $imgUpdateName = self::updateFile($response['0']['image'], $img_banner);
                if($imgUpdateName != false && $imgUpdateName != 'error' && $imgUpdateName != 'formato' && $imgUpdateName != 'size'){                    
                    $st = $con->prepare("UPDATE  `banners` SET name = ?, title = ?, subtitle = ?, active = ?, image = ? , create_at = ? WHERE id = ?");
                    $st->execute(array($nome,$title,$subtitle,$active,$imgUpdateName, date('Y-m-d H:i:s'),$id));
                    if($st->rowCount()){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public static function uploadFile($file)
        {
            $formatos = ['image/jpeg','image/jpg','image/png'];
            $sizeImagem = number_format($file['size']/1048576 , 2);
            
            if($sizeImagem < 5.0){
                if(in_array($file['type'],$formatos)){
                    $path = 'uploadFile/'.rand(1000000, 9999999).str_replace('/','.',strstr($file['type'],'/'));
    
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

        public function updateFile($pathImg, $img)
        {
            if(is_file($pathImg)){
                if(unlink($pathImg)){
                    return self::uploadFile($img);
                }else{
                    return false;
                }
            }else{
                return self::uploadFile($img);
            }
        }

        public static function deleteSlider($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("DELETE FROM `banners` WHERE id = ?");
            $st->execute(array($id));

            return header('Location: ' .PATH_PAINEL.'listBanners.php');
        }

        public static function listBanners()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `banners`");
            $st->execute();

            return $st->fetchAll();
        }
    }