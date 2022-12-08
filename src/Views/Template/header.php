<?php

use Formation\MonApp\Model\Users;

?>

<!-- Page : fond transparent (Interrieur de Body) -->
<div class="page">
    <header>
        <nav>
            <!-- Fonction : Affichage de la nav une fois connecté -->
            <?php
            if (isset($connected) && $connected === true) : ?>
                <div class="nav_container">
                    <!-- Avatar -->
                    <a href='index.php'>
                        <img class="avatar" src="
                                <?php
                        $avatar = Users::getSession('users', $_SESSION['id']);
                        foreach ($avatar[0] as $key => $value) {
                            if ($key === 'avatar') {
                                $avatar = $value;
                            }
                        }
                        echo 'upload/'.$_SESSION['id'].'/album/'.$avatar; ?>" alt="">
                    </a>
                    <!-- Bonjour $prénom + Mini nav vers profil et déconexion -->
                    <div class="nav_perso">
                        <h1>Bienvenue <?php echo $_SESSION['prenom']; ?> !</h1>
                        <div class="edi_dec_prof">
                            <a href='index.php?page=profile'>Editer mon profil</a>
                            <a href='index.php?page=index&session=0'>Déconnexion</a>
                        </div>
                    </div>
                </div>
            <?php
            endif; ?>
        </nav>
    </header>
    <main>
