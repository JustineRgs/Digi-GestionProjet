<?php

?>

<div class="main_container">
    <div class="ctn_wtd">


        <div class="bot_ctn_prof"> <!---Page display: none? avec un button permettant de le display: flex?--->
            <div class="h_prof_edit">
                <h2>Vos coordonnées</h2>
                <form action="" method="POST">
                    <div class="fst_prof_edit">
                        <label for="">Nom :</label>
                        <input type="text" name="nom" value="<?php echo $_SESSION['nom'] ?>">

                        <label for="">Prénom :</label>
                        <input type="text" name="prenom" value="<?php echo $_SESSION['prenom'] ?>">

                        <label for="">Adresse e-mail :</label>
                        <input type="text" name="mail" value="<?php echo $_SESSION['mail'] ?>">
                    </div>

                    <div class="dex_prof_edit">
                        <h3>Modifier le mot de passe</h3>
                        <div class="dex_prof_pwd">
                            <label for="">Mot de passe actuel:</label>
                            <input type="passwordActuel" name="pwd">

                            <label for="">Mot de passe :</label>
                            <input type="password" name="pwd">

                            <label for="">Confirmez le mot de passe :</label>
                            <input type="password" name="pwdsub">
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Modifier">
                </form>

                <div class="trs_prof_edit">
                    <h3>Ajouter / modifier l'avatar</h3>
                    <div class="dex_prof_pwd">
                        <img src="" alt="">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <input type="submit" name="avatar">
                        </form>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
