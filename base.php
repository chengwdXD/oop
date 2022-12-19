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
// $Student->save($stu);

echo $Student->count(['dept'=>2]);
echo "<hr>";
echo $Student->sum('graduate_at');
// $stus = $Student->all(['dept=>3']);
// foreach ($stus as $stu) {
//     echo $stu['birthday'] . "=>" . $stu['dept']; //[]內是要查詢資料表裡的欄位
//     echo "<br>";
// }
$Score=new DB("student_scores");
echo $Score->max('score');
echo "<hr>";
echo $Score->min('score');
echo "<hr>";
echo $Score->avg('score');
echo "<hr>";
echo $Score->sum('score');
echo "<hr>";
echo "整張資料表筆數：".$Student->count();
echo "<hr>";
echo "dept為2的資料筆數:".$Student->count(['dept'=>2]);
echo "<hr>";

 $rows=q("select * from `dept` order by id desc");
dd($rows);

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

                // foreach ($args[0] as $key => $value) {
                //     $tmp[] = "`$key`='$value'";
                // }
                $tmp=$this->arrayToSqlArray($args[0]);

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
      
        $sql="select * from `$this->table` ";

        if(is_array($id)){
            $tmp=$this->arrayToSqlArray($id);
            /* foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            } */
            $sql = $sql . " where " . join(" && ",$tmp);
    
        }else{
    
            $sql=$sql . " where `id`='$id'";
        }
        //echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function del($id){
        $sql="delete from `$this->table` ";

        if(is_array($id)){
            /* foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            } */
            $tmp=$this->arrayToSqlArray($id);
            $sql = $sql . " where " . join(" && ",$tmp);
    
        }else{
    
            $sql=$sql . " where `id`='$id'";
        }

        //echo $sql;
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

function count(...$arg){
    // if(isset($arg[0])){
    //     foreach($arg[0] as $key => $value){
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select count(*) from $this->table where ";
    //     $sql.=join(" && ",$tmp);
    // }else{

    //     $sql="select count(*) from $this->table";
    // }

    $sql=$this->mathSql('count','*',$arg);//將上述簡化後的程式
    //echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}


function sum($col,...$arg){
    // if(isset($arg[0])){
    //     foreach($arg[0] as $key => $value){
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select sum($col) from $this->table where ";
    //     $sql.=join(" && ",$tmp);
    // }else{

    //     $sql="select sum($col) from $this->table";
    // }
    $sql=$this->mathSql('max',$col,$arg);//將上述簡化後的程式
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
function max($col,...$arg){
    // if(isset($arg[0])){
    //     foreach($arg[0] as $key => $value){
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select max($col) from $this->table where ";
    //     $sql.=join(" && ",$tmp);
    // }else{

    //     $sql="select max($col) from $this->table";
    // }
    $sql=$this->mathSql('max',$col,$arg);//將上述簡化後的程式
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
function min($col,...$arg){
    // if(isset($arg[0])){
    //     foreach($arg[0] as $key => $value){
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select min($col) from $this->table where ";
    //     $sql.=join(" && ",$tmp);
    // }else{

    //     $sql="select min($col) from $this->table";
    // }
    $sql=$this->mathSql('min',$col,$arg);//將上述簡化後的程式
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
function avg($col,...$arg){
    // if(isset($arg[0])){
    //     foreach($arg[0] as $key => $value){
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select avg($col) from $this->table where ";
    //     $sql.=join(" && ",$tmp);
    // }else{

    //     $sql="select avg($col) from $this->table";
    // }

    $sql=$this->mathSql('avg',$col,$arg);//將上述簡化後的程式
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}

private function mathSql($math,$col,...$arg){ //簡化sum max min count
    if(isset($arg[0][0])){
        foreach($arg[0][0] as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        $sql="select $math($col) from $this->table where ";
        $sql.=join(" && ",$tmp);
    }else{

        $sql="select $math($col) from $this->table";
    }

    return $sql;
}

////////////////
private function arrayTosqlArray($array){//
   
        foreach($array as $key => $value){
            $tmp[]="`$key`='$value'";
            return $tmp;
        

        }


////////////////

}
}
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    
    
}
//萬用sql函式
function q($sql){
    $dsn="mysql:host=localhost;charset=utf8;dbname=school";
    $pdo=new PDO($dsn,'root','');
    //echo $sql;
    return $pdo->query($sql)->fetchAll();
}

//header函式
function to($location){
    header("location:$location");
}

?>