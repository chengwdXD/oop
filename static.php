<?php
  
echo Car::$type;
echo Car::speed();
//   $car=new Car;
// echo $car->type;

  $car=new Car;
  echo $car->speed();
//   echo Car::$type;
  $carA=Car::$type;
  echo $carA;
  $carB=Car::$type;
  echo $carB;

class Car{
    public static $type='裕隆';
    public static function speed(){
        return 60;
    }
}
?>