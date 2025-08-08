<div class="about-container">
    <h1>About EyoPHP Framework</h1>

    <section class="framework-info">
        <h2>What is EyoPHP Framework?</h2>
        <p><?= $framework ?? 'EyoPHP Framework v0.1.0' ?> is an educational, minimalist and modern PHP framework designed for learning web development.</p>

        <h3>Key Features:</h3>
        <ul>
            <li>🎯 <strong>PSR-4 Autoloading</strong> - Modern PHP standards compliance</li>
            <li>🛡️ <strong>Middleware System</strong> - Flexible request/response handling</li>
            <li>🔀 <strong>Smart Router</strong> - Dynamic routing with parameters support</li>
            <li>🗄️ <strong>Database Abstraction</strong> - Clean PDO singleton pattern</li>
            <li>📝 <strong>MVC Architecture</strong> - Clear separation of concerns</li>
            <li>🔐 <strong>Security Features</strong> - Built-in authentication and validation</li>
        </ul>
    </section>

    <section class="technical-specs">
        <h2>Technical Specifications</h2>
        <div class="specs-grid">
            <div class="spec-item">
                <h4>Framework Version</h4>
                <p><?= $framework ?? 'v0.1.0' ?></p>
            </div>
            <div class="spec-item">
                <h4>PHP Requirements</h4>
                <p>PHP 8.0+ with PDO support</p>
            </div>
            <div class="spec-item">
                <h4>Database Support</h4>
                <p>MySQL, MariaDB via PDO</p>
            </div>
            <div class="spec-item">
                <h4>License</h4>
                <p>Open Source Educational Project</p>
            </div>
        </div>
    </section>

    <section class="getting-started">
        <h2>Getting Started</h2>
        <p>EyoPHP Framework is designed to be simple yet powerful. Check out our documentation to learn how to:</p>
        <ul>
            <li>Create your first controller</li>
            <li>Set up database connections</li>
            <li>Build custom middlewares</li>
            <li>Manage user authentication</li>
        </ul>
    </section>
</div>

<style>
    .about-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 1rem;
        line-height: 1.6;
    }

    .about-container h1 {
        color: #333;
        border-bottom: 3px solid #007acc;
        padding-bottom: 0.5rem;
    }

    .about-container h2 {
        color: #555;
        margin-top: 2rem;
    }

    .about-container ul {
        list-style-type: none;
        padding-left: 0;
    }

    .about-container li {
        margin: 0.5rem 0;
        padding: 0.5rem;
        background: #f8f9fa;
        border-left: 4px solid #007acc;
    }

    .specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
    }

    .spec-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .spec-item h4 {
        margin: 0 0 0.5rem 0;
        color: #007acc;
    }

    .spec-item p {
        margin: 0;
        font-weight: bold;
    }
</style>