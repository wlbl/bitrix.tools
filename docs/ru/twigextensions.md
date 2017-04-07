# Расширения для Twig

Если Вы используете [наше решение для интеграции шаблонизатора Twig в Битрикс](https://github.com/wlbl/twigrix), то после установки данного модуля,
Вы получите следующие дополнительные функции в твиге:
* `getSvg(code, class='', dir='')` - аналог функции `Wlbl\Tools\Assets\Svg::get()`
* `dump(var)` - функция в красивом виде выводит данные из переменной на экран (работает только если twig в режиме debug). 
Под капотом - [symfony/var-dumper](http://symfony.com/doc/current/components/var_dumper.html)