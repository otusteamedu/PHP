**Usage**

1) create validator object `$validator = new EmailValidator();`
2) You can validate single or multiple emails 
    1. to validate **single** email:
` $validator->validate('Email you want validate'); `
returns bool. 

   2. to validate **multiple** emails: 
   `$validator->validateMultiple($emails);` 
   takes array `$emails` as param and return associative array where key is an email and value is a boolean that represents if email is valid 
   
 
 There is an example of usage in `index.php`
    