<?php
namespace Receipe\Fridge;
use Receipe\Common\DateFunc;

/*
 * This Fridge class basically helps to find the ingredient for receipe
 * If compares the ingredient.name , ingredient.amount and the useby date with what is indie the fridge
 *
 * @author kazi Tanvir Ahsan
 * @copyright (c) 2015
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link https://github.com/kazitanvirahsan/cookoftheday
*/
class Fridge
{
    private $content;
    
    public function __construct($content = null) {
        if ($content == null) {
            throw new \RuntimeException("Fridge Can not be empty");
        }
        $this->content = $content;
        return $this;
    }
    
    /**
     * returns list of all ingredients from fridge
     * @return Array
     */
    public function getContent() {
        return $this->content;
    }
    
    /**
     * Check if individual ingredient is available inside a Fridge
     * @param  Array $ingredient
     * @return Boolean
     */
    public function lookForIngredient($ingredient) {
        for ($i = 0; $i < count($this->content); $i++) {
            $fridge_item = $this->content[$i];
            $usebydate_obj = DateFunc::StringToDateObj($fridge_item['use-by']);
            
            // Returns false if expired.We don't cook expired one!
            if (!$this->checkExpiryDate($usebydate_obj)) return false;
            
            // Check the availability of the ingredient in the fridge
            // we compare the item, compare the unit and if amount is less or equal to available amount
            if ($ingredient['item'] == $fridge_item['item'] && (int)$ingredient['amount'] <= (int)$fridge_item['amount'] && $ingredient['unit'] == $fridge_item['unit']) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if the date is already passed away
     * @param  \DateTime $expiry_date
     * @return Boolean
     */
    function checkExpiryDate($expiry_date) {
        
        // check expiry date
        $today_date = new \DateTime('now');
        if ($expiry_date < $today_date) return false;
        return true;
    }
    
    /**
     * just returns use-by date as a string format associated with item
     * @param  Array $ingredient
     * @return String
     */
    public function obtainUsebyDate($ingredient) {
        $content = $this->content;
        $count = count($this->content);
        for ($i = 0; $i < $count; $i++) {
            if ($content[$i]['item'] == $ingredient) {
                return $content[$i]['use-by'];
            }
        }
        return null;
    }
}
