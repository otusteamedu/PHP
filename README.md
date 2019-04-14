# Check emails for validity 

Checker uses preg_match() and getmxrr()

### Installation


```sh
$ git clone https://github.com/Punches/email-checker
```

or 

```sh
$ composer require punches/email-checker
```

### Test PHP CLI

```sh
$ cd test
$ less test-list.txt | php check_stdin.php
```

### Usage

```php
<?
    use Otus\EmailChecker;

    $example = new EmailChecker;
    $line = "mail@mail.com";
    
    echo sprintf('%s is %s%s', $line, ($example->checkEmail($line) ? " valid" : " not valid"), PHP_EOL);
```