<?php
//
// Конттроллер страницы чтения.
//
class C_User extends C_Base
{
	//
	// Конструктор.
	//
	function __construct()
	{		
		parent::__construct();
	}
	//Список пользователей
	public function action_index() {
		$this->title .= '::Список пользователей';
		$mUser = M_User::Instance();
		$table="table";
		$users = $mUser->data_all($table);
		//буферизация данных, отправка в шаблон
		$this->content = $this->Template('./v/index.php', array('users' => $users,'table'=>$table));	
	}
	//Информация о пользователе	
	public function action_user(){
		$this->title .= '::Информация о пользователе';
		
		if(($this->isGet())&& isset($_GET['id'])&&(is_numeric($_GET['id'])))
		{
		    $id_user = $_GET['id'];
		}
		else{
		    $id_user = " ";
		}
		$table="table";
		$mUser = M_User::Instance();
		$user = $mUser->data($id_user,$table);
		$this->content = $this->Template('./v/user.php', array('id_user' => $id_user,'user' => $user));
                }
	public function action_new(){
		$this->title .= '::Добавление нового пользователя';
		//Проверка на отсутствие пустых полей
		if(($this->isPost())&&(!empty($_POST)))
		{	
                        $error = true;
                        //Удаление тегов из полей
                        $name=strip_tags($_POST['name']);
			$gender=strip_tags($_POST['gender']);			
		        $date=strip_tags($_POST['datepicker']);
			$phone=strip_tags($_POST['phone']);
			$mUser = M_User::Instance();
			//Проверка введенных данных на соотвествие формату и корректность
			//Формат введения даты
			$err=$mUser->preg_format_date($date);
			//Корректность даты(исключение несуществующих дат 31 февраля и т.д)
                        $err1=$mUser->k_date($date);
			//Проверка номера телефона на соотвествие формату
			$err2=$mUser->preg_format_phone($phone);
			//Проверка поля имя на содержание только руских букв
                        $err3=$mUser->k_name($name);
			if(($err)&&($err1)&&($err2)&&($err3)){
		  	    $date=$mUser->reverse_date($date);
		            $array=array('name'=>$name,'gender'=>$gender,'date'=>$date,'phone'=>$phone);
			    $new=$mUser->user_new($array);
		            if ($new)
	                    {
		                header('Location: index.php');
		                die();
	                    }
		        }else{			    
			    $s1=((!$err)||(!$err1))?"<br>"."Введены некорректные данные в поле дата рождения":" ";
		            $s2=(!$err2)?"<br>"."Введены некорректные данные в поле телефон":" ";
			    $s3=(!$err3)?"<br>"."Введены некорректные данные в поле имя":" ";
			    echo "<h4>".$s3.$s1.$s2."</h4>";
			   }
			
                 }else{
	               $array=array('name'=>'','gender'=>'','date'=>'','phone'=>'');
		       $error = false;
                }
		$this->content = $this->Template('./v/new.php', array('array'=>$array, 'error' => $error ));
          }
  public function action_edit(){
         $this->title .= '::Редактирование информации о пользователе';
	 $id_user = $_GET['id'];
	//Проверка является ли введенное значение числом
	if(is_numeric($id_user)){
	     $mUser = M_User::Instance();
	     //Получение данных для автозаполнения формы
	     $table="table";
	     $arr=$mUser->data($id_user,$table);
	     $a_name=$arr['name'];
	     $a_gender=$arr['gender'];
             $a_date=$arr['date'];
	     $a_date=$mUser->reverse_date($a_date);	
             $a_phone=$arr['phone'];
	     if (($this->isPost())&&(!empty($_POST)))
	     {   
                 //Данные для автозаполнения в случае некорректного ввода
	         $a_name=$_POST['name'];
	         $a_gender=$_POST['gender'];
                 $a_date=$_POST['datepicker'];
                 $a_phone=$_POST['phone'];
		 //Удаление тегов из полей 
					$name=strip_tags($_POST['name']);
					$gender=strip_tags($_POST['gender']);
                    $date=strip_tags($_POST['datepicker']);
                    $phone=strip_tags($_POST['phone']);
					
					
					//Проверка введенных данных на соотвествие формату и корректность
				    $err=$mUser->preg_format_date($date);
                    $err1=$mUser->k_date($date);
				    $err2=$mUser->preg_format_phone($phone);
					$err3=$mUser->k_name($name);
					
			        if(($err)&&($err1)&&($err2)&&($err3)){
	                    $date = $mUser->reverse_date($date);
				        $error = true;
						$array=array('name'=>$name,'gender'=>$gender,'date'=>$date,'phone'=>$phone);
				        $edit=$mUser->user_edit($id_user,$array);
	                    if ($edit)
	                    {
		                    header('Location: index.php');
		                    die();
	                    }
				    }else{
				        $s1=((!$err)||(!$err1))?"<br>"."Введены некорректные данные в поле дата рождения":" ";
					    $s2=(!$err2)?"<br>"."Введены некорректные данные в поле телефон":" ";
						$s3=(!$err3)?"<br>"."Введены некорректные данные в поле имя":" ";
				        echo "<h4>".$s3.$s1.$s2."</h4>";
				    }
		        }else{
	                $array=array('name'=>'','gender'=>'','date'=>'','phone'=>'');
	                $error = false;
                }
        
		    $this->content = $this->Template('./v/edit.php', array('array'=>$array,'id_user' => $id_user, 'a_name' => $a_name, 'a_gender' => $a_gender,'a_date' => $a_date, 'a_phone' => $a_phone, 'name' => $name, 'gender' => $gender,'date' => $date, 'phone' => $phone, 'error' => $error));		
        }else{
	        echo "Введен неверный адрес";
	    }
	}
    
	public function action_del(){
		$this->title .= '::удаление записи';
		
		if(($this->isGet())&&(isset($_GET['id']))&&(is_numeric($_GET['id'])))
		{
			$id = $_GET['id'];
			$mUser = M_User::Instance();
			$table="table";
			$user=$mUser->data($id,$table);
			$mUser->delete($id);
			$this->content = $this->Template('./v/del.php', array('id' => $id, 'art' => $user));
        }else{
		    $error="Запись не найдена";
         	$this->content = $this->Template('./v/del.php',array('error' => $error));
		}
	}
}
	
	
