<html>
	<head>
		<title>Processing...</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>

		</style>
	</head>
	<body>
		<?php
			$u_lrn= $_POST['lrn'];
			function validateData($lrn){
				echo "<p>" . "Current Attendance of " . date("l jS \of F Y") . "<br>" . "</p>";
				echo "<p>" . $lrn . "</p>";
				if (! empty($lrn)){
					$master_list = fopen("./src/master-list.csv", "r");
					if ($master_list !== FALSE){
						while(! feof($master_list)){
							$data = fgetcsv($master_list,0,",");
							if (! empty($data)){								
								if ($lrn === $data[0]){
									echo "<p id=". $lrn .">"."Present ". "" . $data[1] . " " . $data[2] . " " . $data[3] . ", " . $data[4] . ", " . $data[5] .".\r\n\n" . "</p>";
									$GLOBALS['csvDetails']=$data[0]. ",".$data[1]. ", ".$data[2]. ", ".$data[3]. ", ".$data[4]. ", ".$data[5] . ", ". date("FjY-h:i-A") . "\n";
									return 0;
									break;
								}
							}
						}
					}
				}else{
					echo "<p>"."403 Forbidden, Action requires admin privileges" . "</p>";
				}
				fclose($master_list);
			}
			function appendAttendance($DataToWrite,$Path){
				$file = $Path . date("FjY") . ".csv";
				if (file_exists($file)){
					$CSVfile = fopen($file, 'a') or die($file . " Can't Access File");
					fwrite($CSVfile, $DataToWrite);
					echo "<p>". "Attendance Added" . "</p>";
					fclose($CSVfile);
				}else{
					$CSVfile = fopen($file, 'w') or die($file . " Can't Access File");
					fwrite($CSVfile, $DataToWrite);
					echo "<p>". "Attendance Written" . "</p>";
					fclose($CSVfile);
				}
			}
			function main($lrn, $master_list, $WritePath){
				switch(validateData($lrn)){
					case 0: 
						appendAttendance($GLOBALS['csvDetails'],$WritePath);
						header("Location: ../index.html");
						break;
					default:
						echo "<p>"."404 Not Found, Contact your adviser or any computer literate in your department." . "</p>";
						break;
				}
			}
			main($u_lrn, "./src/master-list.csv", "./out/");
			?>
		<a href="../index.html">Scan Again?</a>
	</body>
</html>


