<?php

/**
 * Post-installation setup script for EyoPHP Framework
 * 
 * This script runs after composer create-project and asks the user
 * about optional components like tests, documentation, etc.
 */

class FrameworkSetup
{
    private static function ask(string $question, string $default = 'n'): string
    {
        echo $question . " [$default]: ";
        $handle = fopen("php://stdin", "r");
        $response = trim(fgets($handle));
        fclose($handle);

        return empty($response) ? $default : strtolower($response);
    }

    private static function removeDirectory(string $dir): bool
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        return rmdir($dir);
    }

    private static function removeFile(string $file): bool
    {
        if (file_exists($file)) {
            return unlink($file);
        }
        return false;
    }

    public static function run(): void
    {
        echo "\n";
        echo "🚀 Welcome to EyoPHP Framework!\n";
        echo "================================\n\n";

        echo "Choose your installation type:\n\n";
        echo "� [1] COMPLETE MODE (Recommended)\n";
        echo "   - Full framework with test suite\n";
        echo "   - Example tests showing best practices\n";
        echo "   - Documentation generation tools\n";
        echo "   - Perfect for professional development\n";
        echo "   - Learn from tested, production-ready code\n\n";

        echo "⚡ [2] MINIMAL MODE\n";
        echo "   - Framework core only\n";
        echo "   - No example tests or documentation tools\n";
        echo "   - Smaller footprint\n";
        echo "   - For experienced developers who will add their own tests\n";
        echo "   - Quick start for prototyping\n\n";

        $choice = self::ask("Which mode do you prefer? (1=Complete, 2=Minimal)", '1');

        if ($choice === '2' || strtolower($choice) === 'minimal' || strtolower($choice) === 'm') {
            echo "\n⚡ Setting up MINIMAL MODE...\n";
            self::setupMinimalMode();
        } else {
            echo "\n� Setting up COMPLETE MODE...\n";
            self::setupCompleteMode();
        }

        echo "\n🎉 Setup complete! Your EyoPHP Framework is ready to use.\n";
        echo "\nNext steps:\n";
        echo "- Edit config/config.php for database settings\n";
        echo "- Start development server: php -S localhost:8000 -t public/\n";
        echo "- Visit http://localhost:8000 to see your application\n";
        echo "\nHappy coding! 🚀\n";
    }

    private static function setupCompleteMode(): void
    {
        echo "✅ Keeping test suite with professional examples\n";
        echo "✅ Keeping documentation tools\n";
        echo "✅ Keeping example.php file\n";
        echo "\nAvailable commands:\n";
        echo "- composer test          # Run all tests\n";
        echo "- composer test-coverage # Generate coverage report\n";
        echo "- composer docs          # Generate documentation\n";
        echo "- php example.php        # See framework examples\n";

        // Keep everything, just remove setup files
        $removeSetup = self::ask("\nRemove setup files?", 'y');
        if ($removeSetup === 'y' || $removeSetup === 'yes') {
            self::removeDirectory(__DIR__);
            self::removeFile(__DIR__ . '/../INSTALL.md');
        }
    }

    private static function setupMinimalMode(): void
    {
        echo "Removing example tests and documentation tools...\n";
        echo "⚠️ Note: You'll need to add your own test suite for production code\n";

        // Remove test directory and files
        self::removeDirectory(__DIR__ . '/../tests');
        self::removeFile(__DIR__ . '/../phpunit.xml');
        self::removeFile(__DIR__ . '/../.phpunit.result.cache');

        // Remove documentation tools
        self::removeDirectory(__DIR__ . '/../docs-template');
        self::removeFile(__DIR__ . '/../phpdoc.xml');
        self::removeFile(__DIR__ . '/../phpdoc.xml.bak');

        // Remove example file
        self::removeFile(__DIR__ . '/../example.php');

        // Remove setup files
        self::removeDirectory(__DIR__);
        self::removeFile(__DIR__ . '/../INSTALL.md');

        echo "✅ Minimal installation ready\n";
        echo "💡 Reminder: Add PHPUnit to your composer.json for testing\n";
    }
}

// Run setup if called directly
if (php_sapi_name() === 'cli') {
    FrameworkSetup::run();
}
