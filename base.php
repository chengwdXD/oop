<?php
$Student = new DB('students'); //定義$Student 抓下面的class DB, ()內是要查詢的資料表
// var_dump($Student);

$john = $Student->find(30);
echo $john['birthday'];






$stus = $Student->all(['dept=>3']);
foreach ($stus as $stu) {
    echo $stu['birthday'] . "=>" . $stu['dept']; //[]內是要查詢資料表裡的欄位
    echo "<br>";
}

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
}