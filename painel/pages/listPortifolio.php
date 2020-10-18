<?php
    $listPortifolio = Portifolio::listProtifolios();
    //TODO FAZER A OPÇÃO PARA DELETAR
    if(isset($_GET['deletar'])){
        Portifolio::deletePortifolio($_GET['deletar']);
    }
?>
<div class="item-dashboard w100">
    <h2>Lista de todos os Porifolios</h2>
    <br>
    <hr class="w100">
            <div class="left w33 item-list">Título</div>
            <div class="left w33 item-list">Situação</div>
            <div class="left w33 item-list"></div>
    <?php
        foreach ($listPortifolio as $key => $value) {
            echo '
            <hr class="w100">
            <div class="left w33 item-list">'.$value['title'].'</div>
            <div class="left w33 item-list">'. $value['category'].'</div>
            <div class="left w33 item-list">
                <a class="btn update" href="'.PATH_PAINEL.'portifolioCreate.php?editar='.$value['id'].'"><i class="fas fa-edit"></i> Editar</a>
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