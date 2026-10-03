<?php
require_once "config.php";

$id = intval($_GET["id"] ?? $_POST["id"] ?? 0);

if ($id <= 0) {
    header("Location: read.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM todos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$todo = $result->fetch_assoc();
$stmt->close();

if (!$todo) {
    die("Todo not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? "Pending";

    if ($title === "") {
        $error = "Task title is required.";
    } else {
        $stmt = $conn->prepare("UPDATE todos SET title = ?, description = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $status, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: read.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Todo</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $todo['id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="<?= htmlspecialchars($todo['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($todo['description']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Pending" <?= $todo['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Completed" <?= $todo['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Todo</button>
                            <a href="read.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
