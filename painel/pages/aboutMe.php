
<div class="item-dashboard w100">
    <h2>Criar novo banner</h2>
    <?php        
        $data = About::selectedAbout();

        if(isset($_POST['acao'])){
           if(isset($data['0']['id'])){
            echo About::updateAbout($_POST['title'], $_POST['body'],$_FILES['photo'],$data['0']['id']); 
            $data = About::selectedAbout();
           }else{
            echo About::createAbout($_POST['title'], $_POST['body'],$_FILES['photo']);
           }
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="itens-form">
            <?php
                if(isset($data['0']['id'])){
                    ?>
                        <input class="w100" type="hidden" value="<?= isset($data['0']['id']) ? $data['0']['id'] : '' ?>" name="title" placeholder="Titúlo">
                    <?php
                }
            ?>
            <input class="w100" type="text" value="<?= isset($data['0']['title']) ? $data['0']['title'] : '' ?>" name="title" placeholder="Titúlo">
            <input class="w100" type="text" value="<?= isset($data['0']['body']) ? $data['0']['body'] : '' ?>" name="body" placeholder="Descrição">
        </div>
        <div class="itens-form">
            <div class="input-file">
                <?php 
                    if(isset($data['0']['photo'])){
                        ?>
                            <img width="300" src="<?= $data['0']['photo'] ?>" alt="" srcset="">
                        <?php
                    }else{
                        ?>
                            <img width="300" src="../asset/images/avatar/profile-img.png" alt="" srcset="">
                        <?php
                    }
                ?>
                
                <input class="w100" type="file" name="photo">
            </div>
        </div>
        <div class="itens-form">
            <input class="w100" type="submit" name="acao" value="Cadastrar">
        </div>
    </form>
</div>