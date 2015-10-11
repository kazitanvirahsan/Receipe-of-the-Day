# The Receipe of the Day:
Please see the pdf for the problem statement.

#Usage:
```php
<?php
$fridge_csv = $argv[1];

// receipes.json
$receipes_json = $argv[2];

require ('vendor\autoload.php');
use Receipe\Reader\JsonFileReader;
use Receipe\Reader\CsvFileReader;
use Receipe\Fridge\Fridge;
use Receipe\Receipe;
use Receipe\Cook\Cook;
use Receipe\Common\DateFunc;

try {
    $reader_obj = new JsonFileReader();
    $receipes = $reader_obj->load($receipes_json);
}
catch(Exception $e) {
    echo $e->getMessage();
    exit(0);
}

try {
    $reader_obj = new CsvFileReader();
    $fridge = $reader_obj->load($fridge_csv);
}
catch(Exception $e) {
    echo $e->getMessage();
    exit(0);
}


$cook_obj = new Cook();
$cook_obj->setFridge(new Fridge($fridge))->setReceipe(new Receipe($receipes));

echo $cook_obj->whatToCook();


```
