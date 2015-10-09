<?php

namespace Receipe;

/*
 * This is a Receipe Class which pass list of ingredients to Fridge Class to see
 * if all the ingredients are available for cooking.
 *
 * @author kazi Tanvir Ahsan
 * @copyright (c) 2015
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link https://github.com/kazitanvirahsan/cookoftheday
*/
class Receipe
{
    private $menu_list;
    private $fridge;
    
    public function __construct($menu_list) {
        $this->menu_list = $menu_list;
    }
    
    /**
     * Set the Fridge object
     * @param  Receipe\Fridge\Fridge $fridge
     * @return Receipe\Receipe
     */
    public function setFridge($fridge) {
        $this->fridge = $fridge;
        return $this;
    }
    
    /**
     * returns the list of receipes
     * @return Array list of receipes
     */
    public function getReceipes() {
        return $this->menu_list;
    }
    
    /**
     * check if all the ingredients from a receipe are available so that we can able to cook this receipe
     * @param  Array $recp
     * @return Boolean
     */
    function canWeCookThisReceipe($recp) {
        $can_cook = true;
        foreach ($recp['ingredients'] as $ing) {
            $can_cook = $can_cook && $this->fridge->lookForIngredient($ing);
        }
        return $can_cook;
    }
}
