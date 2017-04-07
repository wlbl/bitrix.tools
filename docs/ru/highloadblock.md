# HighLoadBlocks

Предоставляется один хелпер
```php
Wlbl\Tools\HighloadBlock\HighloadBlock::getClass($value, $key = 'ID');
```
Данный метод возвращает строку содержащую полное имя класса HighloadBlock'а (наследника Bitrix\Main\Entity\DataManager)<br/>
* `$value` - значение по которому осуществляется поиск<br/>
* `$key` - клюс (колонка в бд) в которой ищется значение<br/>

## Пример использования:

```php
// Будет возвращено полное имя класса HL блока с ID 1
$firstClass = Wlbl\Tools\HighloadBlock\HighloadBlock::getClass(1);
// Будет возвращено полное имя класса HL блока с именем Catalog
$secondClass = Wlbl\Tools\HighloadBlock\HighloadBlock::getClass('Catalog', 'NAME');
```
Далее их можно использовать как обычные классы наследники Bitrix\Main\Entity\DataManager для работы с d7 сущностями
```php
$firstClass::getList()->fetchAll();
$secondClass::getRow();
```