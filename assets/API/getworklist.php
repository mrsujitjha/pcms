<?php       
       
define('HOST','Localhost');
define('USER','u283831071_pcms');
define('PASS','Abesh@2024');
define('DB','u283831071_db_pcms');
$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');
$rlist = $_GET['rlist'];
$sql = "SELECT `rid`,`rname` FROM `tabroad`"; 
$res = mysqli_query($con,$sql);
$i=0;
while($row = mysqli_fetch_assoc($res)) //display all rows from query

{
  if(str_contains($rlist ,$row['rid'])||$rlist=''){ 
  if($i==0){$urlist=$row['rid'].':'.$row['rname'];}else{$urlist=$urlist.'::'.$row['rid'].':'.$row['rname'];}
 $i=$i+1;
  }

}
echo $urlist;

mysqli_close($con);


?>
