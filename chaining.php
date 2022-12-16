<?php
$car=new Car("yellow");
echo $car->addColor('red')->addColor('blue')->addColor('sky')->addColor('棕色')->getColor();
echo"<br>";



class Car{

protected $color;

    public function __construct($color)
    {
      $this->color=$color;  
    }
    function getColor()
    {

 return $this->color; 
  }
  function addColor($color){
       $this->color=$this->color."+".$color;
      return $this;
  }
}

?>