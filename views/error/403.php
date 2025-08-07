<div class="error-container">
    <div class="error-content">
        <h1>403 - Access Forbidden</h1>
        <p class="error-message">You don't have permission to access this resource.</p>

        <div class="error-details">
            <p>This might happen because:</p>
            <ul>
                <li>You need to be logged in to access this page</li>
                <li>Your account doesn't have sufficient privileges</li>
                <li>The resource is restricted to administrators only</li>
                <li>Your session has expired</li>
            </ul>
        </div>

        <div class="error-actions">
            <a href="/" class="btn btn-primary">🏠 Back to Home</a>
            <a href="/connexion" class="btn btn-secondary">🔐 Login</a>
        </div>
    </div>
</div>

<style>
    .error-container {
        max-width: 600px;
        margin: 3rem auto;
        padding: 2rem;
        text-align: center;
    }

    .error-content h1 {
        color: #fd7e14;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .error-message {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .error-details {
        text-align: left;
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .error-details ul {
        margin: 1rem 0 0 0;
        padding-left: 1.5rem;
    }

    .error-details li {
        margin: 0.5rem 0;
        color: #495057;
    }

    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #007acc;
        color: white;
    }

    .btn-primary:hover {
        background: #005a9e;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
        color: white;
    }
</style>