# Calculator

This calculator was created based on strategy pattern.

### Installing

* download TimGa/hw5-1 folder from GIT
* run `composer install` to get dependencies, including phpunit
 
### Syntax

<pre>
php index.php <i>action</i> <i>value</i> <i>value</i> 
</pre>
* action - chooses operation to perform: add, subtract
* value - values to calculate with specified action

*Note: for current version it is supported only two actions: addition and subtraction.*

### Example

```
> php index.php add 3 5
> 8
> php index.php subtract 8 5
> 3
```
### Tests

For tests run: `./vendor/bin/phpunit` 