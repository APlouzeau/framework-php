# 🧪 EyoPHP Testing Guide

This guide demonstrates testing best practices in the EyoPHP framework using PHPUnit.

## 📁 Test Structure

```
tests/
├── bootstrap.php                    # Test initialization & autoloader
├── Unit/                           # Unit tests (isolated logic)
│   ├── BasicValidationTest.php     # Tests existing validator methods
│   ├── ClassValidatorTest.php      # Tests modern validation API
│   └── EntitieUserTest.php         # Tests user entity behavior
├── Integration/                    # Integration tests (database + logic)
│   └── UserIntegrationTest.php     # Complete user registration/login flow
└── results/                       # Generated test outputs
    ├── coverage/                  # HTML coverage reports
    └── junit.xml                  # CI/CD compatible results
```

## 🎯 Testing Philosophy

EyoPHP testing demonstrates:

### 1. **Unit Testing** - Test individual components in isolation

-   Validator logic
-   Entity behavior
-   Utility functions

### 2. **Integration Testing** - Test complete workflows

-   Database operations
-   Authentication flows
-   Business logic combinations

### 3. **Best Practices**

-   Clear test names (`it_validates_email_correctly`)
-   Arrange-Act-Assert pattern
-   Test both success and failure cases
-   Use descriptive assertions

## 🚀 Quick Start

### Run All Tests

```bash
# Windows
.\run-tests.ps1

# Linux/Mac
./run-tests.sh

# Manual
vendor/bin/phpunit
```

### Run with Coverage

```bash
.\run-tests.ps1 -Coverage
```

This generates an HTML coverage report in `tests/results/coverage/index.html`.

### Run Specific Tests

```bash
# Only unit tests
.\run-tests.ps1 -Suite Unit

# Only integration tests
.\run-tests.ps1 -Suite Integration

# Filter by name
.\run-tests.ps1 -Filter ValidationTest
```

## 📝 Writing Tests

### Basic Unit Test Example

```php
<?php
use PHPUnit\Framework\TestCase;

class MyFeatureTest extends TestCase
{
    /**
     * @test
     * Test description in plain English
     */
    public function it_does_something_specific()
    {
        // Arrange - Set up test data
        $input = 'test@example.com';

        // Act - Execute the code under test
        $result = ClassValidator::verifyEmail($input);

        // Assert - Verify the expected outcome
        $this->assertEquals(1, $result['code']);
        $this->assertStringContainsString('valide', $result['message']);
    }
}
```

### Integration Test with Database

```php
<?php
use PHPUnit\Framework\TestCase;

class MyIntegrationTest extends TestCase
{
    private PDO $testDb;

    protected function setUp(): void
    {
        // Create in-memory SQLite for fast testing
        $this->testDb = new PDO('sqlite::memory:');
        $this->createTestSchema();
    }

    /**
     * @test
     */
    public function it_creates_user_in_database()
    {
        $userModel = new ModelUser($this->testDb);

        $result = $userModel->createUser('test', 'test@test.com', 'hash', 2);

        $this->assertTrue($result);
    }
}
```

## ⚙️ Test Configuration

### Environment Separation

Tests use a separate environment file (`.env.test`):

```bash
# Test database (automatically created)
DB_NAME=framework_php_test
APP_ENV=testing
DEBUG=true
```

This ensures:

-   Tests don't affect your development database
-   Consistent test environment
-   Safe for CI/CD pipelines

### PHPUnit Configuration

The `phpunit.xml` file configures:

-   Test discovery in `tests/Unit/` and `tests/Integration/`
-   Code coverage for `class/`, `controller/`, `model/` directories
-   Output formats (JUnit XML, HTML coverage)

## 🏃‍♂️ Test Examples Walkthrough

### 1. `BasicValidationTest.php`

Tests the **existing** validator methods:

-   Email validation
-   Nickname validation
-   Password format checking
-   Field matching

**Key Learning:** How to test existing code without modification.

### 2. `ClassValidatorTest.php`

Tests the **modern** validation API:

-   Laravel-style rule syntax (`required|min:3|max:20`)
-   Multiple rules per field
-   Centralized validation

**Key Learning:** Modern testing patterns and API design.

### 3. `EntitieUserTest.php`

Tests entity behavior:

-   Object construction
-   Property access
-   Utility methods (`hasRole()`, `isAdmin()`)
-   Backward compatibility

**Key Learning:** Testing data objects and business logic.

### 4. `UserIntegrationTest.php`

Tests complete workflows:

-   User registration process
-   Login authentication
-   Duplicate prevention
-   Role assignment

**Key Learning:** End-to-end testing with database.

## 🎓 Educational Value

These tests teach:

### 1. **Testing Mindset**

-   What to test (behavior, not implementation)
-   When to use unit vs integration tests
-   How to structure test code

### 2. **PHP Testing Tools**

-   PHPUnit framework usage
-   Assertions and expectations
-   Test lifecycle (setUp, tearDown)

### 3. **Database Testing**

-   In-memory SQLite for speed
-   Test data management
-   Transaction isolation

### 4. **Code Quality**

-   Coverage analysis
-   Refactoring confidence
-   Documentation through tests

## 🔧 Troubleshooting

### Common Issues

1. **"Class not found" errors**

    - Check that `tests/bootstrap.php` is loading correctly
    - Verify autoloader paths

2. **Database connection errors**

    - Ensure `.env.test` exists
    - Check test database credentials

3. **Permission errors**
    - Make test runners executable: `chmod +x run-tests.sh`
    - Check directory permissions for `tests/results/`

### Debugging Tests

```bash
# Run specific failing test
vendor/bin/phpunit --filter it_validates_email_correctly

# Debug with verbose output
vendor/bin/phpunit --debug

# Stop on first failure
vendor/bin/phpunit --stop-on-failure
```

## 📈 Next Steps

1. **Add more tests** for your custom features
2. **Set up CI/CD** using the JUnit XML output
3. **Monitor coverage** to ensure comprehensive testing
4. **Practice TDD** (Test-Driven Development) for new features

## 🎯 Testing Checklist

When adding new features:

-   [ ] Write unit tests for individual methods
-   [ ] Write integration tests for complete workflows
-   [ ] Test both success and error cases
-   [ ] Verify input validation
-   [ ] Check edge cases (empty values, extremes)
-   [ ] Maintain good test coverage (>80%)
-   [ ] Use descriptive test names
-   [ ] Keep tests fast and independent

---

> **Remember:** Good tests are your safety net. They give you confidence to refactor, add features, and maintain your code over time.
