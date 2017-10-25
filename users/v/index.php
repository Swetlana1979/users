

    <h1>Список пользователей</h1>
    <ul>
	<? foreach ($users as $user): ?>
	     <div class="num" >
		 <?echo $user['id_user']?>
	      </div>
	      <div class="blok">
	           <a href="./index.php?act=user&id=<?echo $user['id_user']?>"><?echo $user['name']?></a>
	      </div>
	      <div class="blok">
		   Пол - <?$gender=($user['gender']=='j')?'ж':'м'; echo $gender;?>
	      </div>
	      <div class="blok">
		   Дата рождения: <?$mass=explode('-',$user['date']);
		   $mass=array_reverse($mass);
		   $date=implode('-',$mass);
		   echo $date;?>
		</div>
		<div class="blok">Номер телефона:<?echo $user['phone']?></div>
		<a href="./index.php?act=edit&id=<?echo $user['id_user']?>" class="edit" alt="редактировать"></a>
		<a href="" class='del delete' alt="удалить" id="<?echo "a".$user['id_user']?>"></a>
	  <? endforeach ?>		
    </ul>
    <br>
    <br>
    <a href="index.php?act=new" id="reg" class="button">Добавить запись</a>

			
			
			
			
			
	        
			
