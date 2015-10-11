<?php
namespace Receipe\Cook;
use Receipe\Fridge\Fridge;
use Receipe\Common\DateFunc;
/*
 * This class is a wireup for Fridge and Receipe Class.
 * It basically finds the final receipe
 *
 * @author kazi Tanvir Ahsan
 * @copyright (c) 2015
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link https://github.com/kazitanvirahsan/cookoftheday
*/
class Cook
{
    private $fridge;
    private $receipe;
    private $tonight_recps = array();
    
    public function __constuct() {
    }
    
    /**
     * set Fridge Object
     * @param  Array $fridge
     * @return Receipe\Cook\Cook
     */
    public function setFridge($fridge) {
        $this->fridge = $fridge;
        return $this;
    }
    
    /**
     * set Receipe Object
     * @param  Receipe\Receipe
     * @return Receipe\Cook\Cook
     */
    public function setReceipe($receipe) {
        $this->receipe = $receipe;
        return $this;
    }
    
    /**
     * list of receipes whose ingredients are available in the Fridge
     * It will populate $this->tonight_recps as Array
     * @return Receipe\Cook\Cook
     */
    public function lookup() {
        
        // Attach the Fridge to Receipe Object so that receipe object can look inside the Fridge
        $this->receipe->setFridge($this->fridge);
        $receipes = $this->receipe->getReceipes();
        
        // For each receipe if we can cook it tonight then save it into an array
        foreach ($receipes as $recp) {
            if ($this->receipe->canWeCookThisReceipe($recp)) {
                array_push($this->tonight_recps, $recp);
            }
        }
        return $this;
    }
    
    /**
     *  More than one receipes so we need to choose one
     *  We pick one whose's one of the ingredient has the smallest use by date.
     *  Smallest use by means it will be the first to expire.
     * @return Array $closest_recpt
     */
    public function getReceipeWithClosestUseBy() {
        $closest_useby_ts = strtotime(date("Y-n-j", PHP_INT_MAX));
        $closest_recpt = null;
        $fridge = $this->fridge;
        // More than one receipes so we need to choose one
        // We pick one whose's one of the ingredient has the smallest use by date.
        // Smallest use by means it will be the first to expire.
        foreach ($this->tonight_recps as $rs) {
            $ingredients = $rs['ingredients'];
            foreach ($ingredients as $ing) {
                $dt_str = $fridge->obtainUsebyDate($ing['item']);
                $dt_obj = DateFunc::StringToDateObj($dt_str);
                if ($dt_obj->getTimestamp() <= $closest_useby_ts) {
                    $closest_useby_ts = $dt_obj->getTimestamp();
                    $closest_recpt = $rs;
                }
            }
        }
        return $closest_recpt;
    }
    
    /**
     * Returns the item name otherwise Order Takeout in case there is no receipe to cook
     * @return String
     */
    public function whatToCook() {
        
        $this->lookup();
       
        // if no receipe is found then return Order Takeoue
        if(empty($this->tonight_recps)) return 'Order Takeout';

        // if more than one menu to cook we choose only one based one closest use by date
        if (count($this->tonight_recps) > 1) {
            $recp_arr = $this->getReceipeWithClosestUseBy();
            return $recp_arr['name'];
        } 

        // Or just print what is in the $this->tonight_recps 
        $recp_today = array_pop($this->tonight_recps);
        return $recp_today['name'];
    
    }
}
