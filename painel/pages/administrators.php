
<div class="item-dashboard w100">
    <h2>Criar novo banner</h2>
    <?php        
        if(isset($_POST['acao'])){
            if(isset($_GET['user']) || isset($_GET['editar'])){
                echo Admin::updateAdministrators($_POST['name'], $_POST['email'], $_POST['password'],$_FILES['photo'], $_POST['id']);
            }else{
                echo Admin::createAdministrators($_POST['name'], $_POST['email'], $_POST['password'],$_FILES['photo']);
            }
        }
        
        $data = null;
        if(isset($_GET['user'])){
            $data = Admin::selectedAdmin();
        }
        if(isset($_GET['editar'])){
            $data = Admin::selectedAdminUpdate($_GET['editar']);
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="itens-form">
            <?php
                if(isset($data['0']['id'])){
                    ?>
                        <input class="w100" type="hidden" value="<?= isset($data['0']['id']) ? $data['0']['id'] : '' ?>" name="id" placeholder="Titúlo">
                    <?php
                }
            ?>
            <input class="w100" type="text" value="<?= isset($data['0']['name']) ? $data['0']['name'] : '' ?>" name="name" placeholder="Nome">
            <input class="w100" type="text" value="<?= isset($data['0']['email']) ? $data['0']['email'] : '' ?>" name="email" placeholder="E-mail">
            <input class="w100" type="text" name="password" placeholder="senha">
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