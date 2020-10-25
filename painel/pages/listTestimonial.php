<?php
    $listTestimonial = Testimonial::listTestimonial();
    //TODO FAZER A OPÇÃO PARA DELETAR
    if(isset($_GET['deletar'])){
        Testimonial::deleteTestimonial($_GET['deletar']);
    }
?>
<div class="item-dashboard w100">
    <h2>Lista de todos os Resumos</h2>
    <br>
    <hr class="w100">
            <div class="left w33 item-list">Título</div>
            <div class="left w33 item-list">Categória</div>
            <div class="left w33 item-list"></div>
    <?php
        foreach ($listTestimonial as $key => $value) {
            echo '
            <hr class="w100">
            <div class="left w33 item-list">'.$value['name'].'</div>
            <div class="left w33 item-list">'. $value['testimonial'].'</div>
            <div class="left w33 item-list">
                <a class="btn update" href="'.PATH_PAINEL.'testimonial.php?editar='.$value['id'].'"><i class="fas fa-edit"></i> Editar</a>
                <a class="btn delete" href="?deletar='.$value['id'].'"><i class="far fa-trash-alt"></i> Excluir</a>
            </div>';
        }
    ?>
    <div class="clear"></div>
</div>

<script>
    $(document).ready(function(){
        $('.delete').click(function(){
            var response = confirm('tem certeza que deseja apagar esse banner?');
            if(response){
                return true;
            }else{
                return false;
            }
        });
    });
</script>