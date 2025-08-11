<div class="form">
    <?php if (isset($error) && !empty($error)): ?>
        <div class="error-message" style="color: red; margin-bottom: 15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL . 'register'; ?>">
        <input type="text" placeholder="Nickname" name="nickName" required />
        <input type="email" placeholder="Email" name="email" />
        <input type="password" placeholder="Password" name="password" required minlength="6" />
        <input type="password" placeholder="Confirm Password" name="confirmPassword" required minlength="6" />
        <button type="submit">Sign Up</button>
    </form>
    <a href="<?= BASE_URL . "connexion" ?>"><button>Already have an account? Log in here!</button></a>
</div>