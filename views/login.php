<?php require_once "head.php"; ?>
<?php require_once "header.php"; ?>

<div class="form">
    <?php if (isset($error) && !empty($error)): ?>
        <div class="error-message" style="color: red; margin-bottom: 15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['registered']) && $_GET['registered'] == '1'): ?>
        <div class="success-message" style="color: green; margin-bottom: 15px;">
            Registration successful! You can now log in.
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>login">
        <input type="text" placeholder="Nickname" name="nickname" required />
        <input type="password" placeholder="Password" name="password" required />
        <button type="submit" name="login">Login</button>
    </form>
    <a href="<?= BASE_URL . "inscription" ?>"><button>Don't have an account? Sign up here</button></a>
</div>

<?php require_once "footer.php"; ?>