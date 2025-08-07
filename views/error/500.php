<div class="error-container">
    <div class="error-content">
        <h1>500 - Internal Server Error</h1>
        <p class="error-message">The server encountered an internal error and could not complete your request.</p>

        <div class="error-details">
            <p>We apologize for the inconvenience. This error has been logged and our team has been notified.</p>
            <p>Please try again in a few moments. If the problem persists, contact our support team.</p>
        </div>

        <?php if (isset($exception) && defined('DEBUG') && DEBUG): ?>
            <div class="debug-info">
                <details>
                    <summary>🐛 Debug Information (Development Mode)</summary>
                    <div class="debug-content">
                        <h4>Exception Message:</h4>
                        <pre><?= htmlspecialchars($exception->getMessage()) ?></pre>

                        <h4>Stack Trace:</h4>
                        <pre><?= htmlspecialchars($exception->getTraceAsString()) ?></pre>

                        <h4>File:</h4>
                        <pre><?= htmlspecialchars($exception->getFile()) ?>:<?= $exception->getLine() ?></pre>
                    </div>
                </details>
            </div>
        <?php endif; ?>

        <div class="error-actions">
            <a href="/" class="btn btn-primary">🏠 Back to Home</a>
            <a href="/contact" class="btn btn-secondary">📧 Contact Support</a>
        </div>
    </div>
</div>

<style>
    .error-container {
        max-width: 700px;
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
        text-align: center;
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .error-details p {
        margin: 0.5rem 0;
        color: #495057;
    }

    .debug-info {
        text-align: left;
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        margin-bottom: 2rem;
        padding: 1rem;
    }

    .debug-info summary {
        cursor: pointer;
        font-weight: bold;
        color: #856404;
        padding: 0.5rem;
    }

    .debug-content {
        padding: 1rem 0;
    }

    .debug-content h4 {
        color: #856404;
        margin: 1rem 0 0.5rem 0;
    }

    .debug-content pre {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        overflow-x: auto;
        font-size: 0.9rem;
        white-space: pre-wrap;
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