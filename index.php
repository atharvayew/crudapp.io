<?php 
require "pdo.php";
session_start();

// Start output buffering
ob_start();
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messageDiv = document.getElementById('message');
        const contentDiv = document.getElementById('content');

        <?php if (isset($_SESSION['success'])): ?>
            messageDiv.innerHTML = "<p style='color: green'><?= htmlspecialchars($_SESSION['success']) ?></p>";
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['name'])): ?>
            messageDiv.innerHTML += "<a href='logout.php'>Logout</a><br />";
        <?php else: ?>
            messageDiv.innerHTML += "<a href='login.php'>Please log in</a>";
        <?php endif; ?>

        // Fetch profiles
        <?php
            $statement = $pdo->query("SELECT * FROM profile");
            if ($statement->rowCount() > 0): ?>
                let table = "<table class='table table-bordered'><thead><tr><th>Name</th><th>Email</th>";
                <?php if (isset($_SESSION['name'])): ?>
                    table += "<th>Action</th>";
                <?php endif; ?>
                table += "</tr></thead><tbody>";
                <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
                    table += "<tr><td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>";
                    table += "<td><?= htmlspecialchars($row['email']) ?></td>";
                    <?php if (isset($_SESSION['name'])): ?>
                        table += "<td><a href='edit.php?profile_id=<?= $row['profile_id'] ?>'>Edit</a> <a href='delete.php?profile_id=<?= $row['profile_id'] ?>'>Delete</a></td>";
                    <?php endif; ?>
                    table += "</tr>";
                <?php endwhile; ?>
                table += "</tbody></table>";
                contentDiv.innerHTML = table;
        <?php endif; ?>

        <?php if (isset($_SESSION['name'])): ?>
            contentDiv.innerHTML += "<a href='add.php'>Add New Entry</a>";
        <?php endif; ?>
    });
</script>

<?php
// Send output
ob_end_flush();
?>
