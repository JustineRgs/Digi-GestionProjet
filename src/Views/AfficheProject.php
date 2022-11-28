<?php

echo '<h2>'.$title.'</h2>';

?>
<table>
    <tr>
        <th>Titre</th>
        <td>Titre</td>
    </tr>
    <tr>
        <th>Elements</th>
        <td>Elements</td>
    </tr>
</table>

<?php

// echo $_SESSION['pwd'].'<br>';
// echo $_SESSION['id'].'<br>';
// echo $_SESSION['prenom'].'<br>';
// echo $_SESSION['nom'].'<br>';
// echo $_SESSION['mail'].'<br>';

?>
<form method='POST' action=''>
    <input type='submit' name='submit' value="Créer un nouveau projet">
</form>
<!-- quand on clique sur 'creer un nouveau projet' -->
<form method='POST' action=''>
    <input type='text' name='ProjectName' placeholder='Nom du projet' required>
    <input type='submit' name='SubmitTask' value="Ajouter une tache">
    <input type='submit' name='submit' value="Créer">
</form>