<div class="contact-container">
    <h1>Contact Us</h1>

    <section class="contact-info">
        <h2>Get in Touch</h2>
        <p>Have questions about EyoPHP Framework? Need technical support or want to contribute? We'd love to hear from you!</p>
    </section>

    <div class="contact-grid">
        <section class="contact-form">
            <h3>Send us a Message</h3>
            <form method="POST" action="/contact" class="form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required placeholder="Your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject" required>
                        <option value="">Choose a subject...</option>
                        <option value="technical-support">Technical Support</option>
                        <option value="bug-report">Bug Report</option>
                        <option value="feature-request">Feature Request</option>
                        <option value="documentation">Documentation</option>
                        <option value="collaboration">Collaboration</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required placeholder="Tell us about your question or feedback..."></textarea>
                </div>

                <button type="submit" class="btn-primary">Send Message</button>
            </form>
        </section>

        <section class="contact-details">
            <h3>Other Ways to Reach Us</h3>

            <div class="contact-method">
                <h4>📧 Email Support</h4>
                <p>For technical questions and support</p>
                <a href="mailto:support@eyophp.dev">support@eyophp.dev</a>
            </div>

            <div class="contact-method">
                <h4>🐛 Bug Reports</h4>
                <p>Found a bug? Help us improve</p>
                <a href="https://github.com/APlouzeau/framework-php/issues" target="_blank">GitHub Issues</a>
            </div>

            <div class="contact-method">
                <h4>💡 Feature Requests</h4>
                <p>Suggest new features or improvements</p>
                <a href="https://github.com/APlouzeau/framework-php/discussions" target="_blank">GitHub Discussions</a>
            </div>

            <div class="contact-method">
                <h4>📚 Documentation</h4>
                <p>Learn more about the framework</p>
                <a href="/docs" target="_blank">Framework Documentation</a>
            </div>
        </section>
    </div>
</div>

<style>
    .contact-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 1rem;
        line-height: 1.6;
    }

    .contact-container h1 {
        color: #333;
        border-bottom: 3px solid #007acc;
        padding-bottom: 0.5rem;
        text-align: center;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-top: 2rem;
    }

    .contact-form .form-group {
        margin-bottom: 1rem;
    }

    .contact-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }

    .contact-form input,
    .contact-form select,
    .contact-form textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        font-family: inherit;
    }

    .contact-form input:focus,
    .contact-form select:focus,
    .contact-form textarea:focus {
        outline: none;
        border-color: #007acc;
        box-shadow: 0 0 0 2px rgba(0, 122, 204, 0.1);
    }

    .btn-primary {
        background: #007acc;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background: #005a9e;
    }

    .contact-method {
        margin-bottom: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 5px;
        border-left: 4px solid #007acc;
    }

    .contact-method h4 {
        margin: 0 0 0.5rem 0;
        color: #333;
    }

    .contact-method p {
        margin: 0.5rem 0;
        color: #666;
        font-size: 0.9rem;
    }

    .contact-method a {
        color: #007acc;
        text-decoration: none;
        font-weight: bold;
    }

    .contact-method a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
</style>