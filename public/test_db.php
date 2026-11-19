<?php
require '../app/init.php';

$a = Database::getInstance();
$b = Database::getInstance();

var_dump($a === $b); // bool(true)

$pdo = $a->getConnection();

$result = $pdo->query('SELECT * FROM produit');

$p = $result->fetch();

?>

<pre>
    <?php var_dump($p); ?>
    <?php echo $p['designation']; ?>
</pre>