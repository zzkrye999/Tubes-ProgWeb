
<?php 
	include 'conn.php';
	$sql="SELECT * FROM manga ORDER BY counter DESC LIMIT 6";
	
	$result=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_row($result)){	
		echo "<div class = \"manga_list\">";
			$path=$row[2];
			$xpath=$row[2]."/xml/chapters.xml";	
			//Proses ambil data info
			$arr_info = array();
			$file = fopen("$path/info.txt", 'r');
				while(!feof($file)){
					$temp = explode("-", fgets($file));
					array_push($arr_info, $temp);
				}
			fclose($file);
			echo "<div class = \"manga_cover\">";
				$coverPath = $path."/cover/cover.jpg";
				echo "<a href=\"mangaProfile.php?title={$row[1]}\"><img class = \"cover\"src = \"$coverPath\"></a>";
					echo "<div class = \"manga_drop\">";
						echo "<div class = 'title_drop'>";
							echo "$row[1] <br><hr>";
						echo "</div>";
						
						echo "<img class = 'cover' src = '$coverPath' style = 'float:left'>";	
						echo "<div class = 'manga_drop_info'>";
							echo "Author: {$arr_info[0][1]}<br>";
							echo "Genre: {$arr_info[1][1]}<br>";
							echo "Synopsis: <br>";
							
							//batesin panjang sinopsis
							$panjang_sinopsis=strlen($arr_info[2][1]);
							if($panjang_sinopsis>250){
								$sinopsis=substr($arr_info[2][1],0,250);
								$sinopsis.="..";
							}else{
								$sinopsis=$arr_info[2][1];
							}	
							echo $sinopsis;
						echo "</div>";
					echo "</div>";
			echo "</div>";

			echo "<div class = \"title\">";
				$panjang_kata=strlen($row[1]);
				if($panjang_kata>20){
					$judul=substr($row[1],0,20);
					$judul.="..";
				}else{
					$judul=$row[1];
				}
				echo "<b> <a href = 'mangaProfile.php?title={$row[1]}'>" . $judul . "</a></b><br>";
			echo "</div>";
			echo "<div class = \"chapter\">";
				$arr=scandir($row[2]);
					foreach ($arr as $item) {
						if($item!='.' && $item!='..' && $item!='comment.txt' && $item!='info.txt' && $item!='cover' && $item!='xml'){
							$chapterInfo=intoStr((string)$item);
							echo "<a href=\"cobaRead.php?this_path={$xpath}&chapter={$chapterInfo}&title={$row[1]}\">Chapter $item </a> <br> ";	
						}
					}
			echo "</div>";
			
		echo "</div>";
	}

 ?>


