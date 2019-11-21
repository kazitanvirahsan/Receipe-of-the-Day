# A 'Recipe Finder' solution

An implementation of 'Recipe Finder' problem using PHP.

## Description

Here is the problem statement copied from DevCodingTest-RecipeFinder.pdf file.

"Given a list of items in the fridge(presented as csv list), and a collection
of recipes (a collection of JSON formatted recipes), produce a recommendation for what to cook tonight.

Program should be written to take two inputs;’fridge csv’ list and the json recipe data.
How you choose to implement this is up to you. You can write a console application which 
takes input file names as command line args or as a web page which takes input through a form.

The only rule is that it is must run and return a valid result using the provided input data."

Please look into the file DevCodingTest-RecipeFinder.pdf for more details about the problem.


### Dependencies

The ideal environment to run this program is Ubnutu OS & PHP7 runtime.

Besides, you must have composer up and running in your system. If you don't have composer, please go to 
https://getcomposer.org/download/ and follow their instruction to install this tool in your operating system.

After installing composer in your system, check the installation by running the following composer command and press Enter.

```
composer
```

You should able to see information about composer.

### Installing

Create a folder named 'chef-of-the-day' in your home directory. 

```
cd ~
mkdir chef-of-the-day
```

Download a copy of the source code into your newly created directory by running the following git clone command.

```
sudo git clone https://github.com/kazitanvirahsan/Receipe-of-the-Day.git  chef-of-the-day
```

Go to the newly created directory and check the newly downloaded files & folders.

```
cd chef-of-the-day
ls -la .
```

Run composer install command to register the lib directory according to the content of package.json.

```
composer install
```

### Executing program

The index.php has the following content to call other classes.

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

Run the index.php file with fridge.csv as the first parameter and recipes.json as the second parameter as below.

```
php index.php 'fridge.csv' 'receipes.csv'
```

The first parameter 'fridge.csv' represents the inventory and the second parameter 'recipes.csv' represents the
required quantities to make a particular menu.

Please see the problem statement file (DevCodingTest-RecipeFinder.pdf) for more details.

Press 'Enter'. 

You should be able to see 'salad sandwich' as the expected output of the program.

## Authors

Kazi Ahsan (ktanvirahsan@gmail.com)   
