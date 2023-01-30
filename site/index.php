<?php
require_once("db_connect.php");

$req=$db->prepare("SELECT * FROM sneakers");
$req->execute();
$info=$req->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
echo ($info);

?>

<?php
$content = ob_get_clean();
?>