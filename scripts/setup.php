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

        // Check for command line arguments first
        global $argv;
        if (isset($argv[1])) {
            $mode = $this->handleCommandLineArg($argv[1]);
        } else {
            $mode = $this->askInstallationMode();
        }

        if ($mode === 'minimal') {
            $this->setupMinimalMode();
        } else {
            $this->setupCompleteMode();
        }

        $this->displayCompletionMessage($mode);
    }

    private function handleCommandLineArg($arg)
    {
        $arg = strtolower(trim($arg));

        if ($arg === 'minimal' || $arg === 'min' || $arg === '2') {
            echo "🎯 Command line argument detected: Minimal Mode\n\n";
            return 'minimal';
        }

        if ($arg === 'complete' || $arg === 'comp' || $arg === '1') {
            echo "🎯 Command line argument detected: Complete Mode\n\n";
            return 'complete';
        }

        echo "❌ Invalid argument '$arg'. Valid options: complete, minimal, 1, 2\n";
        echo "🔄 Falling back to interactive mode...\n\n";
        return $this->askInstallationMode();
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

        // Try readline first (more robust for interactive input)
        if (function_exists('readline')) {
            echo "💡 Pro tip: You can also use arguments later: php scripts/setup.php minimal\n\n";

            $input = readline("Enter your choice [1/2] (or press Enter for Complete): ");

            if ($input === '2' || strtolower($input) === 'minimal') {
                return 'minimal';
            }

            return 'complete';
        }

        // Check if we're run by Composer and can't interact properly
        if ($this->isRunByComposer()) {
            echo "🤖 Detected installation via Composer (no readline support).\n";
            echo "📦 Installing Complete Mode by default.\n\n";
            echo "💡 To choose a different mode after installation:\n";
            echo "   php scripts/setup.php minimal    # For Minimal Mode\n";
            echo "   php scripts/setup.php complete   # For Complete Mode\n\n";
            return 'complete';
        }

        // Final fallback with regular fgets
        echo "Enter your choice [1/2]: ";
        $input = trim(fgets(STDIN));

        if ($input === '2' || strtolower($input) === 'minimal') {
            return 'minimal';
        }

        return 'complete';
    }
    private function isRunByComposer()
    {
        // More reliable detection of Composer environment
        return getenv('COMPOSER_BINARY') !== false ||
            getenv('COMPOSER') !== false ||
            isset($_SERVER['COMPOSER_BINARY']) ||
            isset($_SERVER['COMPOSER']) ||
            // Check if parent process might be composer
            (function_exists('posix_getppid') && $this->isComposerProcess());
    }

    private function isComposerProcess()
    {
        if (!function_exists('posix_getppid')) {
            return false;
        }

        // This is a simple heuristic - not perfect but better
        $parentPid = posix_getppid();
        if ($parentPid <= 1) {
            return false;
        }

        // On Windows this won't work, but that's OK, we have other checks
        return false;
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
