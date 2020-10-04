<?php
    $countAdmins = Admin::countAdministratoresOnlines();
    $countUser = User::acesso();
?>
<div class="item-dashboard left w50 text-center">
    <h4>Usuários onlines</h4>
    <h2><?= count($countUser) ?></h2>
</div>
<div class="item-dashboard right w50 text-center">
    <h4>Administratores Online</h4>
    <h2><?= count($countAdmins)?></h2>
</div>
<div class="clear"></div>
<br>
<br>
<div class="item-dashboard left w50">
    <h4>Usuários onlines</h4>
    <hr>
    <br>
    <?php
        foreach ($countUser as $key => $value) {
            echo '<table>
                    <tr>
                        <td>'.$value['id'].'</td>
                        <td>'.$value['ip'].'</td>
                        <td>'.$value['create_at'].'</td>
                    </tr>
                  </table>';
        } 
    ?>
</div>
<div class="item-dashboard right w50">
    <h4>Administratores Online</h4>
    <hr>
    <br>
    <?php
        foreach ($countAdmins as $key => $value) {
            echo '<table>
                    <tr>
                        <td>'.$value['id'].'</td>
                        <td>'.$value['ip'].'</td>
                        <td>'.$value['created_at'].'</td>
                    </tr>
                  </table>';
        } 
    ?>
</div>