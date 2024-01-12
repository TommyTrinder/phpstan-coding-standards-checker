# PHPStan coding rules for TommyTrinder project

These are PHPStan custom rules for the TommyTrinder project.

## Rules

### No empty if/elseif/else clauses

❌ Incorrect:
```php
if ($foo) {
}
```
❌ Incorrect:
```php
if ($foo) {
  bar();
} else {
}
```

❌ Incorrect:
```php
if ($foo) {
  bar();
} elseif($baz) {
}
```

### No access to dynamic properties on classes extending `Model`

❌ Incorrect:
```php
/**
 * @property string $foo
 */
class Foo extends Model
{
}

$foo = new Foo();
$foo->bar = 'baz'; // NOT ALLOWED
``` 

### No missing argument type declarations

❌ Incorrect:
```php
function foo($bar): void { // ERROR: missing type declaration for $bar
}
```

### No missing return type declarations

❌ Incorrect:
```php
function foo(int $bar) {  // ERROR: missing return type declaration
}
```



## Installation

Add the following to your `composer.json` file:

```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/TommyTrinder/phpstan-coding-standards-checker"
      }
    ]
}
```

```bash
composer require --dev tommy-trinder/phpstan-rules
```

Then add the following to your `phpstan.neon` config:

```neon
includes:
    - vendor/tommy-trinder/phpstan-rules/extension.neon
```