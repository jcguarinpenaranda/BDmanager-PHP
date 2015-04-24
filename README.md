# BDmanager-PHP
Search easily in a Mysql database using PHP

# What does it do?
It takes out some of the pain of playing with mysql in PHP, letting you write less code and go faster!

# Usage

First you have to include or require the class BDManager

```php
include 'path/to/BDManager.php';
```

Now you have to set the host, username, password and database you want to use.

```php
include 'path/to/BDManager.php';

$bd = new BDManager('localhost','root','','your-database-name');
```

And you are good to go!

#Examples

Given the following table called 'users' in MySql, we are going to make a SELECT, UPDATE, DELETE.

<table>
	<thead>
		<th>id</th>
		<th>name</th>
		<th>email</th>
		<th>telephone</th>
	</thead>
	<tbody>
		<tr>
			<td>1</td>
			<td>Johny</td>
			<td>johny@company.com</td>
			<td>+011354987</td>
		</tr>
		<tr>
			<td>2</td>
			<td>Katherine</td>
			<td>katherine@company.com</td>
			<td>+011324786</td>
		</tr>
	</tbody>
</table>

1) Select * from users, and then echo all their names

```php
$users = $bd->query('select * from users');

for($i=0; $i<count($users); $i++){
  echo $users[$i]['name'];
}
```

2) If you want to connect your results as a Web Service, you could just simply do:

```php
$users = $bd->query('select * from users');

header('Content-Type: application/json');
echo json_encode($users);
```

you would get:

```json
[
{
"id":1,
"name":"Johny",
"email:"johny@company.com",
"telephone":"+011354987"
},
{
.... other results
}
]

```



3) Insert a user, and verify if it was done

```php

$bool = $bd->insert("insert into users (id,name,email,telephone) values (3,'Juan','jcguarinpenaranda@gmail.com','+57351684886')");

if($bool){
  //do something
}else{
  //throw error or whatever
}

```

.... more examples coming soon!


#License
Use BDManager as you want. You can modify it, distribute it, use it for commercial purposes .. well you name it.

By Juan Camilo Guarin Peñaranda
http://otherwise-studios.com
