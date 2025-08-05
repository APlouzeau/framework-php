<?php

require_once "head.php";
require_once "header.php"; ?>

<div class="form">
    <?php if (isset($error) && !empty($error)): ?>
        <div class="error-message" style="color: red; margin-bottom: 15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL . 'register'; ?>">
        <input type="text" placeholder="Nickname" name="nickname" required />
        <input type="email" placeholder="Email (optional)" name="email" />
        <input type="password" placeholder="Password" name="password" required minlength="6" />
        <button type="submit">Sign Up</button>
    </form>
    <a href="<?= BASE_URL . "connexion" ?>"><button>Already have an account? Log in here!</button></a>
</div>

<?php require_once "footer.php"; ?>