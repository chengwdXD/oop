<?php
// $cat=new Animal; //導入Animal的類別
// $dog=new Animal;

// echo $cat->type; //物件導向 cat的值會等於type定義的常數
// echo "<br>";
// echo $dog->type;
// echo "<br>";

// $cat->run();
// $cat->speed();

// $cat=new Animal('小花','黑白相間','臭狗');
// echo $cat->getType();
// echo $cat->getName();
// echo $cat->getColor();
// echo"<br>";

// $pig=new Animal('豬頭','有夠粉','胖子');
// echo $pig->getType();
// echo $pig->getName();
// echo $pig->getColor();

$dog=new Dog('柯基','棕色');
echo $dog->getType();
echo $dog->getName();
echo $dog->getColor();

// $cat=new Dog('豬頭','有夠粉','胖子');
// echo $cat->getType();
// echo $cat->getName();
// echo $cat->getColor();
Class Animal{
    protected $type='animal'; //public的定義 可以給外部自由讀值
    protected $name='John';
    protected $hair_color="brown";//protect 被保護的外部不能存取

    public function __construct($name,$color,$type){
        //建構式內容
        // $this->run();
        $this->name=$name;
        $this->hair_color=$color;
        $this->type=$type;
    }
public function getName(){

    return $this->name;
}

public function getColor(){

    return $this->hair_color;
}
public function getType(){

    return $this->type;
}
    public function run(){
        //公開行為內容
        echo "我會跑喔喔喔";
        $this->speed(); //在class裡面的function互相echo 不受private和protect影響
        echo $this->type; //echo public的function 如果內部有echo其他private和protect的一樣可以出來
    }

    private function speed(){
        //私有行為內容
        echo"我會叫喔喔喔喔喔";
    }

}
class Cat extends Animal{
public function __construct($name,$color){
    $this->name=$name;
    $this->hair_color=$color;
    $this->type='貓';

}
}
class Dog extends Animal{
    public function __construct($name,$color){//construct 前面是兩個底線
        $this->name=$name;
        $this->hair_color=$color;
        $this->type='狗';
    
    }
    }
?>