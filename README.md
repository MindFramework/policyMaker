## What is policyMaker ?

This package serves to create custom access policies for server software. **Apache**, **Microsoft ISS**, **LiteSpeed** and **Nginx** software are supported.

**Out-of-class use:**

code:
```php
require_once('Mind.php');
$m = new Mind([
    'policy'=>array(
        'allow'=>'public' // or array
    )
]);
$m::aliyilmaz('policyMaker')->policyMaker();
```

**When using it in the class:**

code:
```php
self::$conf = [
    'policy'=>array(
        'allow'=>'public' // or array
    )
];
self::aliyilmaz('policyMaker')->policyMaker();
```

**Out-of-class use:**

code:
```php
require_once('Mind.php');
$m = new Mind();
$m::aliyilmaz('policyMaker')->policyMaker();
// $m::aliyilmaz('policyMaker')->setAllow('public')->policyMaker();
// $m::aliyilmaz('policyMaker')->setDeny('developer')->policyMaker();
// $m::aliyilmaz('policyMaker')->setDeny('developer')->setAllow('public')->policyMaker();
// $m::aliyilmaz('policyMaker')->setDeny(['developer', 'app'])->setAllow(['public', 'files'])->policyMaker();
```

**When using it in the class:**

code:
```php
self::aliyilmaz('policyMaker')->policyMaker();
// self::aliyilmaz('policyMaker')->setAllow('public')->policyMaker();
// self::aliyilmaz('policyMaker')->setDeny('developer')->policyMaker();
// self::aliyilmaz('policyMaker')->setDeny('developer')->setAllow('public')->policyMaker();
// self::aliyilmaz('policyMaker')->setDeny(['developer', 'app'])->setAllow(['public', 'files'])->policyMaker();
```

output:
```php
Server access files are created by server software type. 
Blocking access to directories is always a priority. 
Therefore, if a conflicting directory is detected in the directory definitions, access is denied. 
Access to directories that are not specifically allowed is always blocked.
```

**For Nginx:**
The following steps should be applied only for Nginx, there is no need for intervention in other server software. Add the following rules to the `server {}` container in the .conf file that affects the project and restart the server. You need to enter the directories whose access you will restrict in the parenthesis in the `location ~ /(app)/` section with **|** separator such as `(app|special)`.

```nginx
error_page 404 /index.php;
location / {
    try_files $uri $uri/ /index.php$is_args$args;
    autoindex on;
}
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass php_upstream;		
}
location ~ /(app)/ {
    deny all;
    return 403;
}
```



---

### Dependencies
1. [getSoftware 1.0.1](https://github.com/aliyilmaz/getSoftware)
2. [write 1.0.1](https://github.com/aliyilmaz/write)

---

### License
Instructions and files in this directory are shared under the [GPL3](https://github.com/aliyilmaz/policyMaker/blob/main/LICENSE) license.