<?php

/**
 * TraitsPageRenderer - Trait pour le rendu uniforme des pages
 * 
 * Ce trait fournit des méthodes pour générer des pages complètes avec un layout
 * cohérent (header, footer, navigation). Il peut être utilisé par n'importe quel
 * contrôleur qui a besoin de rendre des pages HTML.
 * 
 * @package EyoPHP\Framework\Traits
 * @author  Alexandre PLOUZEAU
 * @version 1.0.0
 * @since   1.0.0
 * 
 * @example
 * ```php
 * class MonController {
 *     use TraitsPageRenderer;
 *     
 *     public function maPage() {
 *         $this->generatePage('/views/ma-page.php', 'Mon Titre');
 *     }
 * }
 * ```
 */
trait TraitsPageRenderer
{
    // View paths constants
    private const VIEW_HEAD = "/views/head.php";
    private const VIEW_HEADER = "/views/header.php";
    private const VIEW_FOOTER = "/views/footer.php";

    /**
     * Génère une page complète avec header et footer
     * 
     * Cette méthode assemble une page complète en incluant dans l'ordre :
     * 1. head.php (balises HTML, CSS, meta)
     * 2. header.php (navigation, logo)
     * 3. Le contenu spécifique de la page
     * 4. footer.php (pied de page, scripts JS)
     * 
     * Les données passées dans $data sont extraites en variables PHP
     * disponibles dans toutes les vues incluses.
     * 
     * @param string $contentView Chemin vers la vue principale (ex: "/views/home.php")
     * @param string $pageTitle   Titre de la page (sera affiché dans <title>)
     * @param array  $data        Données à passer aux vues (optionnel)
     * @param string $siteName    Nom du site à afficher (optionnel, défaut: "My site")
     * 
     * @return void
     * 
     * @throws Exception Si une vue n'est pas trouvée
     * 
     * @example
     * ```php
     * // Page simple sans données
     * $this->generatePage('/views/about.php', 'À propos');
     * 
     * // Page avec données utilisateur
     * $this->generatePage('/views/profile.php', 'Mon Profil', [
     *     'user' => $currentUser,
     *     'lastLogin' => $loginDate
     * ]);
     * 
     * // Page avec nom de site personnalisé
     * $this->generatePage('/views/home.php', 'Accueil', [], 'Mon Super Site');
     * ```
     * 
     * @since 1.0.0
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
