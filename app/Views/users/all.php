<h1> Все участники</h1>


<?php foreach($all_users as $user){ ?> 
    <div>
        id:<?php echo $user['id']; ?> 
        <a href="/u/<?php echo $user['nickname']; ?>"><?php echo $user['nickname']; ?></a>
         (<?php echo $user['name']; ?>)
    </div>
<?php } ?>
 