
  <?php
  

  $link = mysqli_connect("127.0.0.1", "root", "", "asset_management");

  if (!$link) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
  }
  
  echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
  echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
 

  if(isset($_POST['username'])){
    echo "in here";
    $uname=$_POST['username'];
    $password=$_POST['password'];

    $sql = mysqli_query($link, "SELECT * FROM am_user_cred WHERE username = '".$_POST['username']."' and password = '".md5($_POST['password'])."'");
    $row = mysqli_num_rows($sql);

    // $sql="select * from am_user_cred where username='".$uname."' and password'".$password."' limit 1";

    // $result = mysql_query($sql);

    if($row==1){
      echo "you have logged in successfully!";
      exit();
    } else {
      echo "<div class='alert alert-danger' role='alert'>Login Failed </div>";
    }
  }




  ?>


