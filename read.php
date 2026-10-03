<?php
require_once "config.php";

$result = $conn->query("SELECT * FROM todos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Todo List Management</span>
    </div>
</nav>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>My Todo List</h2>
            <p class="text-muted mb-0">Manage your tasks using PHP and MySQL.</p>
        </div>
        <a href="create.php" class="btn btn-primary">+ Add Todo</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Completed'): ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td class="text-end">
                                    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Delete this todo?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h5>No todos yet</h5>
                    <p class="text-muted">Create your first task.</p>
                    <a href="create.php" class="btn btn-primary">Create Todo</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
<?php $conn->close(); ?>
