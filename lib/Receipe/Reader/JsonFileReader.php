<?php 
namespace Receipe\Reader;
class JsonFileReader implements OutputInterface
{
    public function load()
    {
         $receipes_json = 'receipes.json';

         if(!file_exists($receipes_json)) {
             throw new \RuntimeException("No json file can not be found from second argument");
         }
         return  json_decode(file_get_contents($receipes_json), true);
    }
}