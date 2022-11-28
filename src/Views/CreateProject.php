<?php
echo '<h2>'.$title.'</h2>';
if (isset($message)) {
    echo '<div>'.$message.'</div>';
}
?>

<form method='POST' action=''>
    <input type='text' name='ProjectName' placeholder='Nom du projet' required>
    <input type='submit' name='SubmitTask' value="Ajouter une tache">
    <input type='submit' name='submitPro' value="Créer">
</form>
