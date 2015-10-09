<?php 
namespace Receipe\Reader;
class CsvFileReader implements OutputInterface
{
    public function load()
    {

       $fridge_csv = 'fridge.csv';
       $data = array();

  if(!file_exists($fridge_csv)) {
    throw new \RuntimeException("No CSV file can not be found from first argument");
  }

  $file = fopen($fridge_csv, 'r');


  while (($line = fgetcsv($file)) !== FALSE) {
    //$line is an array of the csv elements
    // Remove any invalid or hidden characters
    $field0 = preg_replace("/'(.*)'/", '$1', $line[0]);
    $field1 = preg_replace("/'(.*)'/", '$1', $line[1]); 
    $field2 = preg_replace("/'(.*)'/", '$1', $line[2]);
    $field3 = preg_replace("/'(.*)'/", '$1', $line[3]);
  
    array_push($data, array( 'item' => trim($field0) , 
                             'amount' => trim($field1) , 
                            'unit' => trim($field2),
                            'use-by' => trim($field3)
                            ));
  }
  fclose($file);
  return $data;
    }
}