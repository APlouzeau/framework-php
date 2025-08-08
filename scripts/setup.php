<?php

/**
 * EyoPHP Framework - Post-Installation Setup
 *
 * This script runs automatically after `composer create-project`
 * and lets users choose between Complete and Minimal installation modes.
 */

class FrameworkSetup
{
    private $projectRoot;

    public function __construct()
    {
        $this->projectRoot = dirname(__DIR__);
    }

    public function run()
    {
        $this->displayWelcome();
        $mode = $this->askInstallationMode();

        if ($mode === 'minimal') {
            $this->setupMinimalMode();
        } else {
            $this->setupCompleteMode();
        }

        $this->displayCompletionMessage($mode);
    }

    private function displayWelcome()
    {
        echo "\n";
        echo "🚀 Welcome to EyoPHP Framework!\n";
        echo "=================================\n\n";
        echo "Choose your installation mode:\n\n";
    }

    private function askInstallationMode()
    {
        echo "📦 [1] Complete Mode (Recommended)\n";
        echo "   ✅ Tests, examples, documentation tools\n";
        echo "   ✅ Perfect for learning and development\n\n";

        echo "⚡ [2] Minimal Mode\n";
        echo "   ✅ Core framework only\n";
        echo "   ✅ Smaller footprint\n\n";

        while (true) {
            echo "Enter your choice [1/2]: ";
            $input = trim(fgets(STDIN));

            if ($input === '1' || strtolower($input) === 'complete') {
                return 'complete';
            } elseif ($input === '2' || strtolower($input) === 'minimal') {
                return 'minimal';
            } else {
                echo "❌ Invalid choice. Please enter 1 or 2.\n";
            }
        }
    }

    private function setupMinimalMode()
    {
        echo "\n⚡ Setting up Minimal Mode...\n";

        $filesToRemove = [
            'tests/',
            'phpunit.xml',
            '.phpunit.result.cache',
            'docs/',
            'phpdoc.xml',
            'phpdoc.xml.bak',
            'example.php',
            'TESTING.md',
            'docs-template/'
        ];

        foreach ($filesToRemove as $item) {
            $path = $this->projectRoot . '/' . $item;
            if (file_exists($path)) {
                if (is_dir($path)) {
                    $this->removeDirectory($path);
                    echo "  ✅ Removed directory: $item\n";
                } else {
                    unlink($path);
                    echo "  ✅ Removed file: $item\n";
                }
            }
        }

        // Update composer.json to remove dev dependencies
        $this->updateComposerForMinimal();
    }

    private function setupCompleteMode()
    {
        echo "\n🚀 Setting up Complete Mode...\n";
        echo "  ✅ All files preserved\n";
        echo "  ✅ Tests available via: composer test\n";
        echo "  ✅ Documentation via: composer docs\n";
        echo "  ✅ Example usage: php example.php\n";
    }

    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->removeDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }

    private function updateComposerForMinimal()
    {
        $composerPath = $this->projectRoot . '/composer.json';
        if (!file_exists($composerPath)) {
            return;
        }

        $composer = json_decode(file_get_contents($composerPath), true);

        // Remove dev dependencies in minimal mode
        if (isset($composer['require-dev'])) {
            unset($composer['require-dev']);
        }

        // Remove scripts related to testing/docs
        if (isset($composer['scripts'])) {
            unset($composer['scripts']['test']);
            unset($composer['scripts']['test-coverage']);
            unset($composer['scripts']['docs']);
        }

        file_put_contents($composerPath, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo "  ✅ Updated composer.json for minimal mode\n";
    }

    private function displayCompletionMessage($mode)
    {
        echo "\n🎉 EyoPHP Framework setup complete!\n";
        echo "=====================================\n\n";

        if ($mode === 'complete') {
            echo "📚 Complete Mode installed with:\n";
            echo "  • Full test suite\n";
            echo "  • Documentation tools\n";
            echo "  • Example files\n\n";
            echo "🚀 Next steps:\n";
            echo "  1. Configure database in config/config.php\n";
            echo "  2. Start server: php -S localhost:8000 -t public/\n";
            echo "  3. Run tests: composer test\n";
            echo "  4. Try example: php example.php\n";
        } else {
            echo "⚡ Minimal Mode installed:\n";
            echo "  • Core framework only\n";
            echo "  • Optimized for custom development\n\n";
            echo "🚀 Next steps:\n";
            echo "  1. Configure database in config/config.php\n";
            echo "  2. Start server: php -S localhost:8000 -t public/\n";
            echo "  3. Start building your application!\n";
        }

        echo "\n📖 Read the documentation: README.md\n";
        echo "🆘 Need help? Check INSTALL.md\n\n";
    }
}

// Run setup if called directly
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $setup = new FrameworkSetup();
    $setup->run();
}
