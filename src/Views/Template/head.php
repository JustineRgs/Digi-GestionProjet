<!DOCTYPE html>
<html> 
    <head>
        <meta charset='UTF-8'>
        <title><?php echo $title; ?></title>

        <!-- Script ppur récuperer IonIcon -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        
        <!-- Include : vers style -->
        <?php 
        include ("src/Views/assets/css/Setup.php");
        include ("src/Views/assets/css/StyleNav.php");
        include ("src/Views/assets/css/StyleBody.php");
        include ("src/Views/assets/css/StyleTab.php");
        include ("src/Views/assets/css/StyleFooter.php");
        ?>
    </head>
    <body>