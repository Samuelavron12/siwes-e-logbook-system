<?php
require_once 'header.php';
require_once '../config/db.php';

$id = $_GET['id'];

$query = $conn->query("
    SELECT * FROM log_entries
    WHERE id = '$id'
");

$row = $query->fetch_assoc();
?>

<div class="comment-container">

    <h2>Supervisor Feedback</h2>

    <form action="save-comment.php"
          method="POST">

        <input type="hidden"
               name="id"
               value="<?php echo $row['id']; ?>">

        <!-- TITLE -->

        <div class="form-group">

            <label>Log Title</label>

            <input type="text"
                   value="<?php echo $row['title']; ?>"
                   disabled>

        </div>

        <!-- COMMENT -->

        <div class="form-group">

            <label>Supervisor Comment</label>

            <textarea name="comment"
                      rows="7"
                      placeholder="Write your feedback here..."
                      required></textarea>

        </div>

        <!-- BUTTON -->

        <button type="submit"
                name="save_comment"
                class="comment-submit-btn">

            Submit Feedback

        </button>

    </form>

</div>

<?php
require_once 'footer.php';
?>