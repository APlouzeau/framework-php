<div class="container">
    <h1>Profil utilisateur</h1>

    <?php if (isset($userChecked) && $userChecked): ?>
        <div class="profile-info">
            <h2>Informations personnelles</h2>
            <p><strong>Pseudo :</strong> <?= htmlspecialchars($userChecked->getNickname()) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($userChecked->getMail()) ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($userChecked->getId_role()) ?></p>
            <p><strong>Inscrit le :</strong> <?= htmlspecialchars($userChecked->getCreated_at()) ?></p>
        </div>
    <?php else: ?>
        <p>Erreur lors du chargement du profil.</p>
    <?php endif; ?>
</div>
