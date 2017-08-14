<?php
class RecurProcess
{
    private $path;
    private $dbh;
    private $keyFileArr = [];
    private $randTimeStart;
    private $randTimeEnd;
    private $randTimePastTotal;
    private $currentTime;

    function __construct($path)
    {
        //使用PDO连接数据库
        try
		{
			$this->dbh=new PDO('sqlite:'.$path);
		}
		catch(PDOException $e)
		{
			try
			{
				$this->dbh=new PDO('sqlite2:'.$path);
			}
			catch(PDOException $e)
			{
				exit('error!');
			}
		}

        //读取随机关键词文件
        if ( isset($_POST["isKeyword"]) && $_POST["isKeyword"] && isset($_POST["keywordFile"]) && is_array($_POST["keywordFile"])) {
            foreach ($_POST["keywordFile"] as $value) {
                $this->keyFileArr[] = file($value);
            }
        }

        //获取随机时间开始与结束
        if ( isset($_POST["isRandTime"]) && $_POST["isRandTime"] && !empty($_POST['total1']) && !empty($_POST['passtime']) && !empty($_POST['futuretime']) ) {
            $this->randTimeStart = 3600*24*$_POST['passtime'];
            $this->randTimeEnd = 3600*24*$_POST['futuretime'];
            $this->randTimePastTotal = $_POST['total1'];
            $this->currentTime = time();
        }
    }
    public function change($currentId){
        //事务开启
        $this->dbh->beginTransaction();
        for ($i=0; $i <2000 ; $i++) {
            $sql ="UPDATE Content set ";
            if ($_POST["isRandTime"]) {
                $sql .= "pub_time = ".$this->getRandNum($currentId);

            }
            if ($_POST["isKeyword"] && $_POST["isRandTime"]) {
                $sql .= ", title2 = '".$this->getKeywordFile()."'";
            }elseif($_POST["isKeyword"]){
                $sql .= " title2 = '".$this->getKeywordFile()."'";
            }
            $sql .=" where ID= $currentId";
            $this->dbh->exec($sql);
            //$this->exec($sql);
            //echo $sql."<br>\n";
            if ($currentId==$_POST["totalCount"]) {
                break;
            }
            $currentId++;
        }
        //事务提交
        $this->dbh->commit();
    }
    private function getKeywordFile(){
        $subTitle = "";
        foreach ($this->keyFileArr as $value) {
            $keyCount = count($value);
            $subTitle .= $value[rand(0,$keyCount-1)]." " ;
        }
        return trim($subTitle);
    }
    private function getRandNum($currentID)
    {
        if ($currentID <= $this->randTimePastTotal) {
            return floor($this->currentTime - mt_rand(0,$this->randTimeStart));
        }else{
            return floor($this->currentTime + mt_rand(0,$this->randTimeEnd));
        }
    }
    public function orderByPub()
    {
        $sql ="
		ALTER TABLE 'Content' RENAME TO '_old_Content';
		CREATE TABLE 'Content' (
			'ID'  INTEGER PRIMARY KEY AUTOINCREMENT,
			'title'  TEXT,
			'content' TEXT,
			'title2' TEXT,
			'pub_time' INTEGER DEFAULT 0,
			'is_ping' DEFAULT 0
		);
		INSERT INTO 'Content' (`title`,`content`,`title2`,`pub_time`) SELECT `title`,`content`,`title2`,`pub_time` FROM '_old_Content' ORDER BY pub_time;
		DROP TABLE _old_Content;
		VACUUM;
		";
        $this->dbh->exec($sql);
    }
    public function divDB()
    {
        $sql = "SELECT `title`,`content`,`title2`,`pub_time` from `Content` ORDER BY pub_time LIMIT ".$_POST["everydb"]." OFFSET ".$_POST["currentDB"]*$_POST["everydb"];
        $res = $this->dbh->query($sql);
        if (empty($res)) {
            exit(json_encode(["err"=>"没有需要处理的数据了"]));
        }
        //创建新数据库
        $newDB = new PDO('sqlite:'."./".$_POST["dbDir"]."/".($_POST["currentDB"]+1).".db");
        $sql="
		CREATE TABLE 'Content' (
			'ID'  INTEGER PRIMARY KEY AUTOINCREMENT,
			'title'  TEXT,
			'content' TEXT,
			'title2' TEXT,
			'pub_time' INTEGER DEFAULT 0,
			'is_ping' DEFAULT 0
		);
		";
        $newDB->exec($sql);
        $newDB->beginTransaction();
        foreach ($res as $value) {
            $sql = "INSERT INTO 'Content' (`title`,`content`,`title2`,`pub_time`) VALUES ( '".$value['title']."' , '".$value['content']."' , '".$value['title2']."' , '".$value['pub_time']."' )";
            $newDB->exec($sql);
        }
        $newDB->commit();

    }
    function __destruct()
	{
		$this->connection=null;
	}
}

if (isset($_POST["order"]) && $_POST["order"]){
    $rp=new RecurProcess("SpiderResult.db3");
    $rp->orderByPub();
    if ($_POST["currentDB"]+1 == $_POST["dbcount"]) {
        unlink("SpiderResult.db3");
    }
    echo json_encode(["err"=>NULL]);
}elseif (isset($_POST["dbDir"]) && $_POST["dbDir"]!="") {
    if (!is_dir($_POST["dbDir"])) {
        mkdir($_POST["dbDir"]);
    }
    $rp=new RecurProcess("SpiderResult.db3");
    $rp->divDB();
    echo json_encode(["err"=>NULL]);
}
elseif (isset($_POST["totalCount"]) && $_POST["totalCount"]>0) {
    $rp=new RecurProcess("SpiderResult.db3");
    $rp->change($_POST["currentNum"] * 2000);
    echo json_encode(["err"=>NULL]);
}