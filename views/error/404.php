<div class="error-container">
    <div class="error-content">
        <h1>404 - Page Not Found</h1>
        <p class="error-message">The page you are looking for could not be found on this server.</p>

        <div class="error-details">
            <p>This might happen because:</p>
            <ul>
                <li>The page has been moved or deleted</li>
                <li>You followed a broken link</li>
                <li>You typed the URL incorrectly</li>
                <li>The page is temporarily unavailable</li>
            </ul>
        </div>

        <div class="error-actions">
            <a href="/" class="btn btn-primary">🏠 Back to Home</a>
            <a href="/contact" class="btn btn-secondary">📧 Contact Support</a>
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
        color: #dc3545;
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