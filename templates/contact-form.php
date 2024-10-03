<!-- templates/contact-form.php -->
<form id="scf-contact-form" method="post" action="">

        <p>
            <label for="scf_name">Name</label>
            <input type="text" name="scf_name" required>
        </p>
        <p>
            <label for="scf_email">Email</label>
            <input type="email" name="scf_email" required>
        </p>
        <p>
            <label for="scf_message">Message</label>
            <textarea name="scf_message" required></textarea>
        </p>
        <?php
        // Check if the form was submitted successfully and display the message
        if (isset($_POST['scf_submit'])) {
            echo '<p style="color: green;">Thank you for your message!</p>';
        }
        ?>
        <p>
            <input type="submit" name="scf_submit" value="Send">
        </p>
    </form>