<?php

/**
 * Trait for generating complete pages with common layout
 * Can be used by any controller that needs to render pages
 */
trait TraitsPageRenderer
{
    // View paths constants
    private const VIEW_HEAD = "/views/head.php";
    private const VIEW_HEADER = "/views/header.php";
    private const VIEW_FOOTER = "/views/footer.php";

    /**
     * Generate a complete page with header and footer
     * @param string $contentView The main content view file (relative to views/)
     * @param string $pageTitle The page title
     * @param array $data Optional data to pass to the views
     * @param string $siteName Optional site name override
     */
    protected function generatePage(string $contentView, string $pageTitle, array $data = [], string $siteName = "My site"): void
    {
        $titlePage = "{$siteName} : {$pageTitle}";

        // Extract data array to variables available in views
        extract($data);

        // Add titlePage to available variables
        $data['titlePage'] = $titlePage;
        extract($data);

        // SonarQube: View templates require include, not namespace - this is correct for templates
        require_once APP_PATH . self::VIEW_HEAD;
        require_once APP_PATH . self::VIEW_HEADER;
        require_once APP_PATH . $contentView;
        require_once APP_PATH . self::VIEW_FOOTER;
    }

    /**
     * Generate a simple page without header/footer (for AJAX responses, modals, etc.)
     * @param string $contentView The main content view file
     * @param array $data Optional data to pass to the view
     */
    protected function generatePartialPage(string $contentView, array $data = []): void
    {
        extract($data);
        require_once APP_PATH . $contentView;
    }
}
