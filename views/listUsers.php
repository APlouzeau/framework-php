<div class="container">
    <h1>Liste des utilisateurs</h1>

    <?php if (isset($users) && !empty($users)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->getId_user()) ?></td>
                        <td><?= htmlspecialchars($user->getNickname()) ?></td>
                        <td><?= htmlspecialchars($user->getMail()) ?></td>
                        <td><?= htmlspecialchars($user->getId_role()) ?></td>
                        <td><?= htmlspecialchars($user->getCreated_at()) ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteUser(<?= $user->getId_user() ?>)">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</div>

<script>
    function deleteUser(userId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
            fetch('<?= BASE_URL ?>deleteUser', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_user=' + userId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errno === 0) {
                        location.reload();
                    } else {
                        alert('Erreur : ' + data.errmsg);
                    }
                });
        }
    }
</script>
