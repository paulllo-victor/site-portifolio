
<div class="item-dashboard w100">
    <h2>Criar novo banner</h2>
    <?php
        if(isset($_POST['acao'])){

            if(isset($_GET['editar'])){
                if(FunctionsSite::updateSlider($_GET['editar'], $_POST['name'], $_POST['title'],$_POST['subtitle'],$_POST['active'],$_FILES['img_banner'])){
                    echo functionsSite::alert('Slider alterado com sucesso','success');
                }else{
                    echo functionsSite::alert('Error, aconteceu algum erro inesperado tente novamente','error');
                }
            }else{                
                echo FunctionsSite::createBanner($_POST['name'], $_POST['title'],$_POST['subtitle'],$_POST['active'],
                $_FILES['img_banner']);
            }   
            // print_r(FunctionsSite::uploadFile($_FILES['img_banner']));
            // echo functionsSite::alert('deu tudo certo');
        }
        if(isset($_GET['editar'])){
            $data = null;
            if(FunctionsSite::selectSlider($_GET['editar'])){
                $data = FunctionsSite::selectSlider($_GET['editar']);
            }else{
                echo functionsSite::alert('Error, esse artigo não foi encontrado','error');
            }
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="" id="" value="<?= isset($data['0']['id']) ? $data['0']['id'] : '' ?>">
        <div class="itens-form">
            <input class="w100" type="text" name="name" id="" value="<?= isset($data['0']['name']) ? $data['0']['name'] : '' ?>" placeholder="Nome do banner">
        </div>
        <div class="itens-form">
            <input class="w100" type="text" name="title" id="" value="<?= isset($data['0']['title']) ? $data['0']['title'] : '' ?>" placeholder="Chamada de titúlo">
            <input class="w100" type="text" name="subtitle" id="" value="<?= isset($data['0']['subtitle']) ? $data['0']['subtitle'] : '' ?>" placeholder="Subtitulo">
        </div>
        <div class="itens-form">
            <select class="w100" name="active" id="">
                <option value="0">Deseja deixar esse banner como o ativo?</option>
                <option value="1" <?= $data['0']['active'] == 1 ? 'selected' : '' ?>>Sim</option>
                <option value="0"  <?= $data['0']['active'] == 0 ? 'selected' : '' ?>>não </option>
            </select>
        </div>
        <div class="itens-form">
            <input class="w100" type="file" name="img_banner" id="">
        </div>
        <div class="itens-form">
            <input class="w100" type="submit" name="acao" id="" value="Cadastrar">
        </div>
    </form>
</div>