
<div class="item-dashboard w100">
    <h2>Criar novo banner</h2>
    <?php        
        if(isset($_POST['acao'])){

            if(isset($_GET['editar'])){
                echo Testimonial::updateTestimonial($_POST['name'],$_POST['name'],$_FILES['photo'],$_GET['editar']);
            }else{
                echo Testimonial::createTestimonial($_POST['name'],$_POST['name'],$_FILES['photo']);
            }
           
        }
        if(isset($_GET['editar'])){
           $data = Testimonial::selectTestimonial($_GET['editar']);
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="itens-form">
            <input class="w100" type="text" name="name" value="<?= isset($data['0']['name']) ? $data['0']['name'] : '' ?>" placeholder="Titúlo">
            <input class="w100" type="text" name="testimonial" value="<?= isset($data['0']['testimonial']) ? $data['0']['testimonial'] : '' ?>" placeholder="Testemunho">
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