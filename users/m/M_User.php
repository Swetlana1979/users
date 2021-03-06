<?php
class M_User
{
	private static $instance; 	// ссылка на экземпляр класса
	private $msql; 				// драйвер БД
	
	//
	// Получение единственного экземпляра (синглтон)
	//
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new M_User();
		
		return self::$instance;
	}
	//
	// Конструктор
	//
	public function __construct()
	{
		$this->msql = M_MSQL::Instance();
	}
 	// Количество записей
	function getCount()
	{
		$query = "SELECT * FROM table";
		$result=mysql_query($query);
        $result = mysql_num_rows($result);
		return	$result;
		
	}
	//
  // Список всех пользователей
  //
  public function user_all()
  {
	    // Запрос.
	    $query = "SELECT * FROM `table` WHERE 1"; 
	    return $this->msql->Select($query);
	}
	 //
   // Конкретный пользователь
   //
    public function user_get($id_user)
    {
	    $id_user=trim($id_user);
	    $t="SELECT * FROM `table` WHERE id_user=$id_user";
	    $query = sprintf($t, $id_user);
		  $result = $this->msql->Select($query);
		  return $result[0];
	}
	
	  //
    // Подробное описание
    //
     public function data($id_user,$table)
    {
	    $id_user=trim($id_user);
	    $t="SELECT * FROM `$table` WHERE id_user=$id_user";
	    $query = sprintf($t, $id_user);
		  $result = $this->msql->Select($query);
		  return $result[0];
	}
//Обработка данных пришедших из формы
	
	public function pars($array){
	    $obj = array();
	    foreach($array as $key=>$value){
		  	$value=trim($value);
				$obj[$key]=$value;
		  }
		return $obj;
	}
    //
    // Добавить пользователя
    //
    public function user_new($array)
   {
	    
		$array=$this->pars($array);
		$this->msql->Insert('table', $array);
		return true;
    }

    //
    // Редактировать запись
    //
    public function user_edit($id_user,$array)
   {
	    
		$array=$this->pars($array);
	    $t = "id_user=$id_user";		
	    $where = sprintf($t, $id_user);		
	    $this->msql->Update('table', $array, $where);
	    return true;
    }

//
// Удалить запись
//
   public function delete($id)
    {
	    $t = "id_user=$id";	
		$where = sprintf($t, $id);		
		$this->msql->Delete('table', $where);
		return true;
    }
//
// Обработка данных
//
    
    //Переварачивание даты
	public function reverse_date($date)
	{
        $s=substr($date,2,1);
        if($s=="."){
	        $mass=explode('.',$date);
			$mass=array_reverse($mass);
			$date=implode('-',$mass);
			
			}
		else{
		  $mass=explode('-',$date);
			$mass=array_reverse($mass);
		  $date=implode('.',$mass);
		}
		return $date;
	}
	
	
	//Проверка даты на соотвествие формату 
	public function preg_format_date($date){
	  $preg="/([0-9]{2}\.){2}[0-9]{4}/";
    $p=preg_match($preg,$date);
		$lenght=strlen($date);
		$p1=($lenght==10)?true:false;
    if($p&&$p1){
		    return true;
		}else{
		    return false;
		}
		
	}
	
	//Проверка даты на корректность 
	public function k_date($date)
	{
	    
	    $mass=explode('.',$date);
	    $m1=$mass[0][0]+$mass[0][1];
	    $m2=$mass[1][0]+$mass[1][1];
	    $m3=$mass[2][0];
		if((($mass[0]=="30")&&($mass[1]=="02"))||
		(($mass[0]=="31")&&(($mass[1]=="02")||
		($mass[1]=="04")||($mass[1]=="06")||
		($mass[1]=="09")||($mass[1]=="11")))){
		    $error=true;
		}else{
		    $error=false;
		}
	    $year=date(Y);
		$y=$year-5;
	    if((!$error)&&(($m1>0)&&($mass[0]<=31))&&(($m2>0)&&($mass[1]<=12))&&(($m3>0)&&($mass[2]<$y))){
		    return true;
		}else{
		    return false;
		}
		
	}
	
	//Проверка телефона на соотвествие формату 
	public function preg_format_phone($phone){
	    $preg='/8\([0-9]{4}\)([0-9]{2}-){2}[0-9]{2}/';
	    $p=preg_match($preg,$phone);
		$lenght=strlen($phone);
		$p1=($lenght==15)?true:false;
		if($p&&$p1){
		    return true;
		}else{
		    return false;
		}
		
	}
	
	//Проверка поля имя на содержание только русских букв
	public function k_name($name){
	    $array=array();
	    $m=str_split($name);
	    for($i=0;$i<count($m);$i++){
	        $preg='/[-А-Яа-яЁРСТУФХЧЦЩШЫЪЬЭЮёрстуфхчцщшъыьэю\s]/';
	        $str=$m[$i];
	        $p=preg_match($preg,$str);
	        if(!$p){
	            array_push($array,"1");   
	        }
	    }
		$lenght=count($array);
		$error=($lenght==0)?true:false;
	    return $error;
	}
	
	
	
} 

 
