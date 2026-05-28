<?php
require_once 'header.php';
require_once '../config/db.php';

$query = $conn->query("
    SELECT * FROM users
    WHERE role = 'student'
");
?>

<div class="table-container">

    <h2>All Students</h2>

    <br>

    <table>

        <tr>

            <th>Name</th>

            <th>Email</th>

            <th>Phone</th>

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

                <a class="delete-user-btn"  href="delete-user.php?id=<?php echo $row['user_id']; ?>">
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