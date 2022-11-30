<div class="page">
<header>
<?php

use Formation\MonApp\Model\Users;

 include ("src/Views/assets/css/StyleHead.php");
 include ("src/Views/assets/css/Setup.php");
// include ("src/Views/assets/css/StyleForm.php")
// include ('src/Views/assets/Css/Style.php')
?>
    <nav>
        <?php
            if (isset($connected) && $connected === true) :
        ?>

        <div class="profil_content">
            <div class="profil_img">
                <a href='index.php'>
                <img class="img_pro" src="
                <?php
                $avatar = Users::getSession('users' ,$_SESSION['id']);
                foreach($avatar[0] as $key => $value){
                    if($key === 'avatar'){
                        $avatar = $value;
                    }
                }
                echo 'upload/'.$_SESSION['id'].'/album/'.$avatar;
                ?>
                " alt="">
                </a>
            </div>
            <div class="nav_perso">
                <h1>Bienvenue <?php echo $_SESSION['prenom']; ?> !</h1>
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
<main>
