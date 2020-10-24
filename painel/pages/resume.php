
<div class="item-dashboard w100">
    <h2>Criar novo banner</h2>
    <?php
        if(isset($_POST['acao'])){

            if(isset($_GET['editar'])){
                echo Resume::updateResume($_POST['title'],$_POST['body'],$_POST['location'],$_POST['category'],$_GET['editar']);
            }else{
                echo Resume::createResume($_POST['title'],$_POST['body'],$_POST['location'],$_POST['category']);
            }
            
        }

        if(isset($_GET['editar'])){
            $data = null;

            if(Resume::selectResume($_GET['editar'])){
                $data = Resume::selectResume($_GET['editar']);
            }else{
                echo functionsSite::alert('Error, esse resume não foi encontrado','error');
            }
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="itens-form">
            <input class="w100" type="text" name="title" value="<?= isset($data[0]['title']) ? $data[0]['title'] : '' ?>" placeholder="Titúlo">
            <input class="w100" type="text" name="body" value="<?= isset($data[0]['body']) ? $data[0]['body'] : '' ?>" placeholder="Description">
        </div>
        <div class="itens-form">
            <input class="w100" type="text" name="location" value="<?= isset($data[0]['location']) ? $data[0]['location'] : '' ?>" placeholder="Localização">
        </div>
        <div class="itens-form">
            <select class="w100" name="category">
                <option>Categória</option>
                <option value="Educação" <?= isset($data[0]['category']) && $data[0]['category'] == 'Educação' ? 'selected' : '' ?>>Educação</option>
                <option value="Experiência" <?= isset($data[0]['category']) && $data[0]['category'] == 'Experiência' ? 'selected' : '' ?>>Experiência </option>
            </select>
        </div>
        <div class="itens-form">
            <input class="w100" type="submit" name="acao" value="Cadastrar">
        </div>
    </form>
</div>