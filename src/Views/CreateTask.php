<?php
echo '<h2>'.$title.'</h2>';

?>

<form method='POST' action=''>
    <label>Nom de la tache</label> 
    <input type='text' name='TaskName' placeholder='Nom de la tache' required>
    <label for='priority'>Priorité</label> 
    <input type="radio" name="priority" value="tres_important" /> Trés important
    <input type="radio" name="priority" value="important" /> Important
    <input type="radio" name="priority" value="moins_important" /> Moins important
    <input type='text' name='TaskDescription' placeholder='Decrivez la tache en quelques lignes' required>
    <label>Affilier un utilisateur à cette tache</label> 
    <input type='email' name='UserMail' required>
</form>

<?php
