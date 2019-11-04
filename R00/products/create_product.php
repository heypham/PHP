<?php
include ('../utils.php');
session_start();

// Get new product variables
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$img_url = $_POST['img'];
$categories = [];

// Get categories of product
if (!file_exists('../private'))
	mkdir('../private');
if (!file_exists('../private/categories'))
	file_put_contents('../private/categories', null);
if (!file_exists('../private/users'))
	file_put_contents('../private/users', null);

$category_file = unserialize(file_get_contents('../private/categories'));
if ($category_file){
	while ($cat = array_search('on', $_POST)) {
		$categories[] = $cat;
		$_POST[$cat] = 'off';
	}
}

$userfile = unserialize(file_get_contents('../private/users'));
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>New Product</title>
		<style>
			*{
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			}
			body{
				background-color: #f2f2f2;
			}
			.product{
				margin: auto;
				width: 50%;
				background-color: #ffe6e6;
				padding: 5%;
				border-radius: 2%;
			}
			form{
				margin: auto;
			}
			a {
				text-decoration: none;
				text-align: center;
				color: black;
				margin-left: 35%;
				width: 100%;
				font-size: 20px;
			}
			input[type="text"]{
				width: 70%;
				height: 2%;
			}
		</style>
	</head>
	<body>
		<div class='product'>
		<?if ($name && $categories && $description && $price && $img_url && $_POST['submit'] == 'OK')
		{
			if (!file_exists('../private'))
				mkdir('../private');
			if (!file_exists('../private/products'))
				file_put_contents('../private/products', null);
			$file = unserialize(file_get_contents('../private/products'));
			$already_exist = 0;
			if ($file) {
				foreach ($file as $k => $v) {
					if ($v['name'] === $name) {
						$already_exist = 1;?>
						<h1 style="text-align: center;">Product <i><? echo $name ?></i> already exists</h1><br />
						<? if (is_admin($_SESSION['loggued_on_user'], $userfile) == 1){?>
							<a href="../admin.php"><i>Go back to admin page</i></a><br />
						<?}
						exit();
					}
				}
			}
			if (!$already_exist) {
				$tmp['name'] = $name;
				$tmp['categories'] = $categories;
				$tmp['description'] = $description;
				$tmp['price'] = $price;
				$tmp['image'] = $img_url;
				$file[] = $tmp;
				file_put_contents('../private/products', serialize($file)."\n");?>
				<h1 style="text-align: center;">Product <i><? echo $name ?></i> successfully added</h1><br />
				<?if (is_admin($_SESSION['loggued_on_user'], $userfile) == 1){?>
					<a href="../admin.php"><i>Go back to admin page</i></a><br />
				<?}
				exit();
			}
		}
		else {?>
			<h1 style="text-align: center;">Product name can not be empty !</h1><br />
			<? if (is_admin($_SESSION['loggued_on_user'], $userfile) == 1){?>
				<a href="../admin.php"><i>Go back to admin page</i></a><br />
			<?} else {?>
				<a href="./index.php"><i>Homepage</i></a><br />
			<?}
		}?>
		</div>
	</body>
</html>
