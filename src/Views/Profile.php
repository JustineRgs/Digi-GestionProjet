<?php

?>

<div class="main_container">
    <div class="ctn_wtd">
        <div class="bot_ctn_prof"> <!---Page display: none? avec un button permettant de le display: flex?--->
            <div class="h_prof_edit">
                <h2>Vos coordonnées</h2>
                <div class="fst_prof_edit">
                    <form action="" method="POST">
                        <label for="">Nom :</label>
                        <input type="text" name="nom" value="<?php echo $_SESSION['nom'] ?>">
                        
                        <label for="">Prénom :</label>
                        <input type="text" name="prenom" value="<?php echo $_SESSION['prenom'] ?>">
                    
                        <label for="">Adresse e-mail :</label>
                        <input type="text" name="mail" value="<?php echo $_SESSION['mail'] ?>">

                        <input type="submit" name="submit" class = 'submit' value="Modifier">
                    </form>
                </div>
                <div class="trs_prof_edit">
                    <h2>Ajouter / modifier l'avatar</h2>
                    <div class="dex_prof_pwd">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <input type="submit" name="avatar">
                            <img src="" alt="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
