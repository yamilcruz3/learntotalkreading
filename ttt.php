<?php 
require_once ("./source/dbconnect.php");

$conn = db_connect();
mysqli_set_charset($conn, "utf8");
session_start();
// Session Variables
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$phone= $_SESSION['phone'];
$pais= $_SESSION['pais'];
$edad = $_SESSION['edad'];

$token = $_POST['stripeToken'];
$email = $_POST['email'];



// Post variables
$course_name = $_POST['course_name'];
$course_days = $_POST['course_days'];
$hour_val = $_GET['hour_val'];
$program = $_POST['program'];


// Post variables
//$course_days = $_POST['course_days'];
$course_days = 1; 
//$hour_val = $_POST['hour'];
$hour_val = $_GET['hour_val'];
//$program = $_POST['program'];
$program =3;
$email = 'yamil@dialekonline.com';
$course_name ='Clase de prueba';

// Query varibales
$course = mysqli_query($conn,"SELECT * FROM Lesson_packages WHERE id = '$program' ");
$course = mysqli_fetch_all($course, MYSQL_ASSOC);
$course_description = $course[0]['description'];
$course_cost = $course[0]['cost'];
$course_duration = $course[0]['lessons_quantity'];

// Manual set variables
$teacher_name = 'Zaely S.'; //this should be automated
$start_array = array('2017-09-18','2017-09-19'); // exclusively for september
$start_day = $start_array[$course_days];


$available_spaces = mysqli_query($conn,"SELECT * FROM available_spaces WHERE sold='0' ORDER BY value DESC");
$available_spaces = mysqli_fetch_all($available_spaces, MYSQL_ASSOC);

$selected_hour = mysqli_query($conn,"SELECT dateTime_UTC FROM available_spaces WHERE value='$hour_val' ");
$selected_hour = mysqli_fetch_all($selected_hour, MYSQL_ASSOC);
$selected_hour = $selected_hour[0]['dateTime_UTC'];
$occupied = "UPDATE available_spaces set sold='1' WHERE dateTime_UTC='$selected_hour'";
$result = mysqli_query($conn,$occupied);


//echo($selected_hour[0]['dateTime_UTC']);
//$hour_array = array('18:00:00','18:30:00','19:00:00','19:30:00','20:00:00','20:30:00','21:00:00','21:30:00');
//$hour = $hour_array[$hour_val];

		$j = 0;

		for($i = 1; $i <= $course_duration/2; $i++ ){

				$dateTime_UTC = gmdate("c",  strtotime($selected_hour.' GMT-0000 +'. $j .' days')  );

					$sql = "INSERT INTO course_schedule (firstname, lastname, email, cost, teacher_email,  course_name, dateTime_UTC) VALUES ('$first_name' , '$last_name','$email','$course_cost','$teacher_name', '$course_name', '$dateTime_UTC')";
				if ($conn->query($sql) === TRUE) {//echo "New record created successfully";
							} else {
								echo "Error: " . $sql2 . "<br>" . $conn->error;
							}
			echo($sql."<br/>");
			
			$j = $j + 2;

				$dateTime_UTC = gmdate("c",  strtotime($selected_hour.' GMT-0000 +'. $j .' days')  );

					$sql2 = "INSERT INTO course_schedule (firstname, lastname, email, cost, teacher_email, course_name, dateTime_UTC) VALUES ('$first_name' , '$last_name','$email','$course_cost','$teacher_name','$course_name', '$dateTime_UTC')";

				if ($conn->query($sql2) === TRUE) {//echo "New record created successfully";
							} else {
								echo "Error: " . $sql2 . "<br>" . $conn->error;
							}

			$j = $j + 5;
			
			echo($sql2."<br/>");
		}


?>


<html>
	<head>
	<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>DialekOnline Aprende Inglés </title>
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
		<meta name="viewport" content="width=device-width" />
		<meta property="og:url"           content="http://www.dialekonline.com/" />
		<meta property="og:type"          content="DialekOnline.com Vence tu miedo al Inglés" />
		<meta property="og:title"         content="DialekOnline.com Vence tu miedo al Inglés, Conversando" />
		<meta property="og:description"   content="Mejora tu Inglés desde la comodiad de tu hogar pero con todos los beneficios de tener un instructor privado cara a cara. Esta es la oportunidad para alcanzar tu exito que no puedes dejar pasar." />
		<meta property="og:image"         content="http://www.dialekonline.com/assets/images/share_picture.png" />
		
		<meta name="google-site-verification" content="QIe8dLmqUXTZehh2Sa9EX39bToRPNKHVht9aW6kVLEU" />
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<link href="assets/css/landing-page.css" rel="stylesheet"/>
		<link href="assets/css/animate.css" rel="stylesheet"/>
		<!--     Fonts and icons     --> 
		<link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		
		<link href='https://fonts.googleapis.com/css?family=Montserrat:700,400' rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans|Source+Sans+Pro" rel="stylesheet">
				
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>		
		<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
		<script src="assets/js/bootstrap.js" type="text/javascript"></script>
		
	</head>

		<script>
			
	var options_mark = '<?php  
							echo("<option disabled selected >Seleciona tu horario</option>");
							$y = 0;
							foreach($available_spaces as $val => $key){

								if( $available_spaces[$val]["teacher_email"] == "Mark"){	

									echo("<option value = ".$available_spaces[$val]["value"]." >  ");

									$mark_hours[$y] = date("g:ia",strtotime($available_spaces[$val]["dateTime_UTC"]."-4 hours"));

									$mark_hour_duration = date("g:ia",strtotime($available_spaces[$val]["dateTime_UTC"]."-4 hours 30 minutes"));

									echo($mark_hours[$y]." - ".$mark_hour_duration ." </option>");

									$y = $y + 1;
								}

							}
				?>'
	
	
	var option_zaely = '<?php 
	
							echo("<option  disabled selected >Seleciona tu horario</option>");
							$x = 0;
							foreach($available_spaces as $val => $key){

							if( $available_spaces[$val]["teacher_email"] == "Zaely S."){

								echo("<option value = ".$available_spaces[$val]["value"]." >  ");

								$zaely_hours[$x] = date("g:ia",strtotime($available_spaces[$val]["dateTime_UTC"]."-4 hours"));
								$zaely_hour_duration = date("g:ia",strtotime($available_spaces[$val]["dateTime_UTC"]."-4 hours 30 minutes"));

								echo($zaely_hours[$x]." - ".$zaely_hour_duration ." </option>");

								$x = $x + 1;
							}

					}
	
	?>'
			

		</script>	

</html>

