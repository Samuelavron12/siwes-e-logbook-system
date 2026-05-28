<?php
require_once 'header.php';
require_once '../config/db.php';

$query = $conn->query("
    SELECT * FROM users
    WHERE role = 'supervisor'
");
?>

<div class="table-container">

    <h2>All Supervisors</h2>

    <br>

    <table>

        <tr>

            <th>Name</th>

            <th>Email</th>

            <th>Phone</th>

            <th>Status</th>

            <th>Action</th>

        </tr>

        <?php while($row = $query->fetch_assoc()): ?>

        <tr>

            <td>
                <?php echo $row['full_name']; ?>
            </td>

            <td>
                <?php echo $row['email']; ?>
            </td>

            <td>
                <?php echo $row['phone_number']; ?>
            </td>

            <td>

                <span class="status-active">
                    Active
                </span>

            </td>

            <td>

                <a class="delete-user-btn"
                   href="delete-user.php?id=<?php echo $row['user_id']; ?>"
                   onclick="return confirm('Delete this supervisor?')">

                    Delete

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php
require_once 'footer.php';
?>