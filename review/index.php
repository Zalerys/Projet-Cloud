<?php
$output = shell_exec('sudo whoami 2> error;cat error;pwd;ls -l');
echo "<pre>$output</pre>";

$username = 'user15';
$domain = 'blabla';

$mysqli = new mysqli('localhost', $username, $username, $domain);

if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Success... ' . $mysqli->host_info . "\n";

$mysqli->close();

$AccountSize = shell_exec("du -sh /home/$username | awk '{print $1}'");
echo "<pre>Espace consommé: $AccountSize</pre>";
$DBSize = shell_exec("du -sh /var/lib/mysql/$domain | awk '{print $1}'");
# awk '{print $1}' : pk $1 ? entrée commande 1 | sortie commande 2
echo "<pre>Base de données: $DBSize</pre>";
