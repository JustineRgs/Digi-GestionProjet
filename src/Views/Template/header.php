<header>
<?php

use Formation\MonApp\Model\Users;

 include ("src/Views/assets/css/StyleHeader.php")?>
<?php include ("src/Views/assets/css/StyleForm.php")?>
    <nav>
        <a href='index.php'>Accueil</a>
        <?php
            if (isset($connected) && $connected === true) :
        ?>

        <div class="top_ctn_prof">
            <div class="profile_photo_ctn">
                <img src="
                <?php 
                $avatar = Users::getByAttribute('id_users', $_SESSION['id']);
                foreach ($avatar[0] as $key => $value){
                    if ($key === 'avatar'){
                        $avatar = $value;
                    }
                }
                echo 'upload/'.$_SESSION['id'].'/album/'.$avatar;
                ?>
                " alt="" width="50px" height="50px">
            </div>
            <div class="info_user_prof">
                <p>Bienvenue <?php echo $_SESSION['prenom']; ?></p>
                <div class="edi_dec_prof">
                    <a href='index.php?page=profile'>Editer mon profil</a>
                    <a href='index.php?page=index&session=0'>Déconnexion</a>
                </div>
            </div> 
        </div>


        <?php
            endif;
        ?>
    </nav>
</header>
