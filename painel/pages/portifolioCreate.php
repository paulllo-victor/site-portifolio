<div class="item-dashboard w100"> 
    <?php
        if(isset($_POST['acao'])){
            if(isset($_GET['editar'])){
                echo Portifolio::updatePortifolio($_GET['editar'],$_POST['title'],$_POST['category'],$_FILES['image']);
            }else{
                echo Portifolio::createPortifolio($_POST['title'],$_POST['category'],$_FILES['image']);
            }
            
        }        
        if(isset($_GET['editar'])){
            $data = null;
            if(Portifolio::selectPortifolio($_GET['editar'])){
                $data = Portifolio::selectPortifolio($_GET['editar']);
            }else{
                echo functionsSite::alert('Error, esse artigo não foi encontrado','error');
            }
        }
    ?>
    <h2>Criar novo Projeto de Portfolio</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="itens-form">
            <input class="w100" type="text" name="title" value="<?= isset($data['0']['title']) ? $data['0']['title'] : '' ?>" placeholder="Título">
        </div>
        <div class="itens-form">
            <input class="w100" type="text" name="category"  value="<?= isset($data['0']['category']) ? $data['0']['category'] : '' ?>" placeholder="Categória">
        </div>
        <div class="itens-form">
            <input class="w100" type="file" name="image">
        </div>
        <?php 
            if (isset($data['0']['image'])) {
               ?>
                <img src="<?= isset($data['0']['image']) ? $data['0']['image'] : '' ?>" alt="" srcset="">
               <?php
            }
        ?>
        
        <div class="itens-form">
            <input class="w100" type="submit" name="acao" value="Cadastrar">
        </div>
    </form>
</div>

<style>
    img{
        width: auto;
        height: 200px;
        margin: 40px auto;
        display: block
    }
</style>