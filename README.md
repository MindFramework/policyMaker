## What is policyMaker ?

This package serves to create custom access policies for server software. **Apache**, **Microsoft ISS** and **LiteSpeed** software are supported.


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
Server access files are created by server software type. Blocking access to directories is always a priority. Therefore, if a conflicting directory is detected in the directory definitions, access is denied. Access to directories that are not specifically allowed is always blocked.
```

---

### Dependencies
1. [getSoftware 1.0.0](https://github.com/aliyilmaz/getSoftware)
2. [write 1.0.0](https://github.com/aliyilmaz/write)

---

### License
Instructions and files in this directory are shared under the [GPL3](https://github.com/aliyilmaz/policyMaker/blob/main/LICENSE) license.