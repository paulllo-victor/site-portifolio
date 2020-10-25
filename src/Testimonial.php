<?php

    class Testimonial{
        public static function createTestimonial($name,$testimonial,$image)
        {
            $con = Connection::conectar();

            if(strlen($name) <= 6){
                return functionsSite::alert('Name do cliente deve ter no mínimo de 6 caracteres','error');
            }
            if(strlen($testimonial) <= 6){
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

            $st = $con->prepare("INSERT INTO `testimonial` VALUES (?,?,?,?)");
            $response = $st->execute(array('',$name,$testimonial,$pathImg));

            if($response){
                return  functionsSite::alert('Testemunho cadastrado com sucesso','success');
            }else{
                return  functionsSite::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
            }

        }
        
        public static function updateTestimonial($name,$testimonial,$photo,$id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM `testimonial` WHERE id = ?");
            $st->execute(array($id));
            $response = $st->rowCount();

            if($response){
                $datas = $st->fetchAll();
                if(strlen($name) <= 6){
                    return functionsSite::alert('Name do cliente deve ter no mínimo de 6 caracteres','error');
                }
                if(strlen($testimonial) <= 6){
                    return functionsSite::alert('Testemunho deve ter no mínimo de 6 caracteres','error');
                }
                $pathImg = $photo['name'] != '' ? self::updateFile($datas[0]['photo'],$photo) : $datas[0]['photo'];
    
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
    
                $st = $con->prepare("UPDATE testimonial SET name = ?, testimonial = ? , photo =  ? WHERE id = ?");
                $st->execute(array($name,$testimonial,$pathImg,$id));
    
                if($st->rowCount()){
                    return  functionsSite::alert('Testemunho cadastrado com sucesso','success');
                }else{
                    return  functionsSite::alert('Marque o campo de ativação do banner SIM ou NÃO','error');
                }
            }else{
                return  functionsSite::alert('Ops, não foi possível editar esse testemunho','error');
            }

        }

        public static function uploadFile($file)
        {
            $formatos = ['image/jpeg','image/jpg','image/png'];
            $sizeImagem = number_format($file['size']/1048576 , 2);

            if($sizeImagem < 5.0){
                if(in_array($file['type'],$formatos)){
                    $path = 'uploadFile/testimonial/'.rand(1000000, 9999999) . str_replace('/','.',strstr($file['type'],'/'));
    
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

        public static function selectTestimonial($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM testimonial WHERE id = ?");
            $st->execute(array($id));

            return $st->fetchAll();
        }

        public static function listTestimonial()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM testimonial");
            $st->execute();

            return $st->fetchAll();
        }

        public static function deleteTestimonial($id)
        {
            $con = Connection::conectar();
            $st = $con->prepare("DELETE FROM testimonial WHERE id = ?");
            $st->execute(array($id));

            return header('Location: '.PATH_PAINEL.'listTestimonial.php');
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