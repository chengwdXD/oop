<?php
$cat=new Animal; //導入Animal的類別
$dog=new Animal;

echo $cat->type; //物件導向 cat的值會等於type定義的常數
echo "<br>";
echo $dog->type;
echo "<br>";

$cat->run();
$cat->speed();
Class Animal{
    public $type='animal'; //public的定義 可以給外部自由讀值
    public $name='John';
    protected $hair_color="brown";//protect 被保護的外部不能存取

    public function __constructor(){
        //建構式內容
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
?>