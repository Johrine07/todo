<?php
require_once "config.php";

$id = intval($_GET["id"] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: read.php");
exit;
?>
