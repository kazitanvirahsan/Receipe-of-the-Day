<?php
use Receipe\Fridge\Fridge;
use Receipe\Receipe;
class ReceipeTest extends \PHPUnit_Framework_TestCase {
    
    private $fridge;
    private $receipe;

    public function setUp() {
        
        $mockFridge = $this->getMockBuilder('Receipe\Fridge\Fridge')
            ->disableOriginalConstructor()
            ->setMethods(array('lookForIngredient'))
            ->getMock();
    
        $mockFridge->expects($this->any())
            ->method('lookForIngredient')
            ->will($this->returnValueMap(array(
                array('bread', true),
                array('pasta', false),
            )));


    $mockReceipe = $this->getMockBuilder('Receipe\Receipe')
            ->disableOriginalConstructor();

    $this->fridge = $mockFridge;
    $this->receipe =  $mockReceipe;

}


public function testcanWeCookThisReceipe(){
    $can_cook = true;
    $recp = array();
    $recp['ingredients'] = array('bread');
    foreach ($recp['ingredients'] as $ing) {
        $can_cook = $can_cook && $this->fridge->lookForIngredient($ing);
    }
    
    $this->assertEquals(true , $can_cook);


    $recp = array();
    $recp['ingredients'] = array('pasta');
    foreach ($recp['ingredients'] as $ing) {
        $can_cook = $can_cook && $this->fridge->lookForIngredient($ing);
    }
    
    $this->assertEquals(false , $can_cook);



}



}