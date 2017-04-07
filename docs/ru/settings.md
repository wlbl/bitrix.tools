# Конфигурация

Конфигурация производится в файле .settings.php или .settings_extra.php в блоке `wlbl.tools`

```php
<?php
    return [
        // ...
        'wlbl.tools' => [
            'value' => [
                'svgDir' => '/assets/svg/', // путь до папки с svg файлами относительно DOCUMENT_ROOT
            ],
        ],
        // ...
];
```