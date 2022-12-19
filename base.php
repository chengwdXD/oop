<?php
$Student = new DB('students'); //定義$Student 抓下面的class DB, ()內是要查詢的資料表
// var_dump($Student);

// $john = $Student->find(30);
// echo $john['birthday'];


$Student->save(['name'=>'張大同','dept'=>2,'uni_id'=>"H22211223"]);

echo "<hr>";
$Student->save(['name'=>'張大同','dept'=>2,'uni_id'=>"H22211223",'id'=>3]);
$stu=$Student->find(15);
dd($stu);

echo $Student->count(['dept'=>2]);
echo "<hr>";
echo $Student->sum('graduate_at');

// $stus = $Student->all(['dept=>3']);
// foreach ($stus as $stu) {
//     echo $stu['birthday'] . "=>" . $stu['dept']; //[]內是要查詢資料表裡的欄位
//     echo "<br>";
// }

class DB
{
    protected $table;
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=school"; //讀取的資料庫
    protected $pdo;

    public function __construct($table)
    {
        $this->pdo = new PDO($this->dsn, 'root', ''); //'root',''  使用者和密碼
        $this->table = $table;
    }


    public function all(...$arg)
    {


        $sql = "select * from $this->table ";

        if (isset($args[0])) {
            if (is_array($args[0])) {
                //是陣列 ['acc'=>'mack','pw'=>'1234'];
                //是陣列 ['product'=>'PC','price'=>'10000'];

                foreach ($args[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }

                $sql = $sql . " WHERE " . join(" && ", $tmp);
            } else {
                //是字串
                $sql = $sql . $args[0];
            }
        }

        if (isset($args[1])) {
            $sql = $sql . $args[1];
        }

        echo $sql;
        return $this->pdo
                ->query($sql)
                ->fetchAll(PDO::FETCH_ASSOC);
    }

   public function find($id)
    {
      
        $sql = "select * from $this->table ";

        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }

            $sql = $sql . " where " . join(" && ", $tmp);
        } else {

            $sql = $sql . " where `id`='$id'";
        }
        //echo $sql;
        return $this->pdo
            ->query($sql)
            ->fetch(PDO::FETCH_ASSOC);
    }

    function del($id){
        $sql="delete  from `$this->table` ";
    if(is_array($id)){
        foreach($id as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        $sql = $sql . " where " . join(" && ",$tmp);
    }else{
     
        $sql=$sql . " where `id`='$id'";
    }
    echo $sql;
    return $this->pdo->exec($sql);
    
    }

function save($array){ //有id更新  沒id新增  (合併新增和更新的function)
    if(isset($array['id'])){
        foreach($array as $key => $value){
            if($key!='id'){

                $tmp[]="`$key`='$value'";
            }
        }
        $sql="update $this->table set ";
        $sql .=join(",",$tmp);
        $sql .=" where `id` ='{$array['id']}'";

    }else{
        $cols=array_keys($array);
        $sql="insert into $this->table (`" . join("`,`",$cols) . "`)
                                values('" . join("','",$array) . "')";

        echo $sql;
        //return $this->pdo->exec($sql); //將sql語法寫入資料庫執行
    }

    
    
}
function count($arg){
    if(is_array($arg)){
        foreach($arg as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        $sql="select count(*) from $this->table where ";
        $sql.=join(" && ",$tmp);
    }else{

        $sql="select count($arg) from $this->table";
    }

    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
///////////////////////////////

function sum($col,...$arg){
    if(isset($arg[0])){
        foreach($arg[0] as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        $sql="select sum($col) from $this->table where ";
        $sql.=join(" && ",$tmp);
    }else{

        $sql="select sum($col) from $this->table";
    }

    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}


}
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";


}
