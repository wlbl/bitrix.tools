# Assets

Предоставляется один хелпер
```php
Wlbl\Tools\Assets\Svg::get($code, $class = '', $dir = '');
```
Данный метод вставляет в страницу код svg файла.

* `$code` - код svg файла (путь + название файла без расширения svg от базовой директории указанной в настройках модуля или в аргументе dir) 
* `$class` - дополнительный список классов для применения к svg (в виде строки)
* `$dir` - директория где располагаются svg файлы, относительно DOCUMENT_ROOT

## Конфигурация

* `svgDir` - путь до папки с svg файлами относительно DOCUMENT_ROOT

Настройки задаются в файле .settings.php или .settings_extra.php в блоке `wlbl.tools`
```php
<?php
    return [
        // ...
        'wlbl.tools' => [
            'value' => [
                'svgDir' => '/assets/svg/',
            ],
        ],
        // ...
];
```

## Консольные команды

Доступно только в dev-master version

Если у Вас в проекте используется [notamedia/console-jedi](https://github.com/notamedia/console-jedi), то установить путь до папки с svg файлами можно так
```
./vendor/bin/jedi wlbl.tools:svg:set-dir /path/to/svg/dir/from/document/root/
```