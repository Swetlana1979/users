<?php/*
Шаблон добавление записи
=======================
*/?>
   <a href="index.php">Главная</a> 
   <h1>Новый пользователь</h1>
   <?php 
        if($error) { 
            echo "<b style='color: red;'>Заполните все поля!</b>";
	} 
    ?>
    <form action="index.php?act=new" method="post">
    <div class="n">
         <label for="name">ФИО:</label>
     </div>
     <div class="enter">
	 <input type="text" id="name" name="name" value="<?echo $_POST['name']?>">
      </div>
      <br/>
      <br>
		<?php
		    if($_POST['gender']=="m"){
		        $m="selected";
		        $j="";
		    }else{
		        $j="selected";
		        $m="";
			}
		?>
		<div class="n">
		    <label for="gender">Пол:</label>
		</div>
		<div class="enter">
		    <select name="gender">
		        <option <?echo $m?> value="m">м</option>
		        <option <?echo $j?> value="j">ж</option>
		    </select>
		</div>
		<br/>
		<br>
		<div class="n">
		    <label for="datepicker">Дата рождения(ДД.ММ.ГГГГ):</label>
		</div>
		<div class="enter">
		    <input type="text" id="datepicker" name="datepicker" value="<?echo $_POST['datepicker']?>"/>
		</div><!--</label><input type="text" id="date" name="date" value="<?//echo $_POST['date']?>">-->
		<br/>
		<br>
		<div class="n">
		    <label for="phone">Номер телефона(8(хххх)хх-хх-хх):</label>
		</div>
		<div class="enter">
		    <input type="text" id="phone" name="phone" value="<?echo $_POST['phone']?>">
		</div>
		<br/>
		
		<input type="submit" id="sub" value="Добавить" class="button">
	</form>
	
	
