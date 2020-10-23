
<div class="item-dashboard w100">
    <h2>Criar novo banner</h2>
    <?php
        if(isset($_POST['acao'])){
            echo Resume::createResume($_POST['title'],$_POST['body'],$_POST['location'],$_POST['category']);
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="itens-form">
            <input class="w100" type="text" name="title" id="" placeholder="Titúlo">
            <input class="w100" type="text" name="body" id="" placeholder="Description">
        </div>
        <div class="itens-form">
            <input class="w100" type="text" name="location" id="" placeholder="Localização">
        </div>
        <div class="itens-form">
            <select class="w100" name="category" id="">
                <option>Categória</option>
                <option value="Educação">Educação</option>
                <option value="Experiência">Experiência </option>
            </select>
        </div>
        <div class="itens-form">
            <input class="w100" type="submit" name="acao" id="" value="Cadastrar">
        </div>
    </form>
</div>