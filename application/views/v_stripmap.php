<!DOCTYPE html>  
<html> 
<header class="page-header">
  <div class="container-fluid">
    <h1 class="text-center">STRIP PLAN</h1>	
  </div>
</header> 
<body onload="myFunction()">

<div class="container-fluid">
    <?php if ($this->session->flashdata('message')!=null) {
    echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
        .$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button> </div>";
    } ?>
    <br>	   
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                <div class="d-flex h-100" > 
                    <div > 
                        <?php                        
                            $sc=explode("-",$this->session->userdata('seclength'));
                            if (count($sc) >1 ){  ?>
                            <h4 >Total Road Length :<?=$this->session->userdata('roadlength'). " Km. Last Chainage :".get_chainageformat($this->session->userdata('seclastch'))?> </h4>
                            <div class="form-group row">
                            <div class="col-sm-5 "><h4 >Section Length: <?= $sc[$this->session->userdata('selsection')]. " Km"?></h4></div>                                
                                <div class="col-sm-3">
                                    <select type="text" name="scn"  id="scn" required class="form-control"; onchange="javascript:getsectionlength()";>
                                    <?php for ($i=0;$i<count($sc);$i++){ if($this->session->userdata('selsection')==$i){?>  
                                        
                                        <option value=<?= $i?> selected ><?= $i+1?></option> <?php } else{ ?>
                                        <option value=<?= $i?>><?= $i+1?></option>     
                                     
                                        <?php }} ?>
                                    </select> 
                                </div>
                            </div>
                            <?php }else{ ?>
                                <h4 >Total Road Length :<?=$this->session->userdata('roadlength'). " Km. Last Chainage :".get_chainageformat($this->session->userdata('seclastch'))?> </h4>
                            <?php } ?>
                        <h4 >Road Name :<?=$this->session->userdata('roadname');?> </h4>
                    </div>     
                    <div class="align-self-end ml-auto"> 
                        <li> <i class="fa fa-print"></i><a href="javascript:print_stripmap(0);">Print Page</a></li> 
                        <li> <i class="fa fa-print"></i><a href="javascript:print_stripmap(1);">Print Plan</a></li> 
                    </div> 
                </div>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title"  id="chtext">Section Chainage:</h5>
                       <canvas id="stripplan" width="950" height="360" > </canvas>
                </div>
                <div class="card-footer">
                    <ul class="pagination justify-content-end">                  
                        <li class="page-item"><a class="page-link" href="javascript:Draw_stripplan(-1);">Previous</a></li>
                        &nbsp;
                        <li class="page-item"><a class="page-link" href="javascript:Draw_stripplan(1);">Next</a></li>
                        <div class="col-sm-2">
							<input type="text" id="txtsearch" name="txtsearch" placeholder="Enter page" class="form-control">
						</div>                        
                        <div class="col-sm-2">
                             <a href="#progress" onclick="searchmypage()" class="btn btn-primary" >Search</a>
						</div>                       

                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
   
</div>  

<script type="text/javascript"> 
    function myFunction() {    
    localStorage.clear();
    Draw_stripplan(1);
    }
    function searchmypage() {   

    localStorage.clear();
    var a=document.getElementById("txtsearch").value;
    Draw_stripplan(a);
    }
  function Draw_stripplan(np){

    var page = localStorage.getItem("strippage");
    var maxlength ='<?=$this->session->userdata('seclastch');?>';
   
   //alert(maxlength);
    var mpage=maxlength/2;
    page=(page)*1+np; 
    if(page<1){page=1;}
    if(page>mpage){page=mpage;}
    const canvas = document.getElementById("stripplan");
    const ctx = canvas.getContext("2d");  
    ctx.clearRect(0, 0, canvas.width, canvas.height);    
    chtext.innerText = "Section Chainage: From "+changein_chainage((page-1)*2000)+" To "+changein_chainage(page*2000);
 
   drawstripplan(page);
   localStorage.setItem("strippage", page);
}
    function changein_chainage(a){
        var b=Math.floor(a/1000); 
        var c=a%1000; 
        c=("00" + c).slice(-3)
        var d="Ch "+b+ "+"+ c;
    return d;
    }

    function drawstripplan(page){
     
   const canvas = document.getElementById("stripplan");
   const ctx = canvas.getContext("2d");
   
   const sg =<?php echo json_encode($sugrade); ?>;
   const gsb =<?php echo json_encode($subbase); ?>;
   const wmm =<?php echo json_encode($base); ?>;  
   const bm =<?php echo json_encode($dbm); ?>; 
   const bc =<?php echo json_encode($bc); ?>; 
   const dlc =<?php echo json_encode($dlc); ?>; 
   const pqc =<?php echo json_encode($pqc); ?>; 
   
   const sgr =<?php echo json_encode($sugrader); ?>;
   const gsbr =<?php echo json_encode($subbaser); ?>;
   const wmmr =<?php echo json_encode($baser); ?>;  
   const bmr =<?php echo json_encode($dbmr); ?>; 
   const bcr =<?php echo json_encode($bcr); ?>; 
   const dlcr =<?php echo json_encode($dlcr); ?>; 
   const pqcr =<?php echo json_encode($pqcr); ?>; 

   ctx.beginPath();
   var x1=10;
   var y1=10;
   var x2=930;
   var y2=10;
   var i=0;
  
   for ( i = 0; i < 18; i++) {
      if (i < 8 || i > 9)
      {
       ctx.moveTo(x1, y1+i*20);
       ctx.lineTo(x2, y2+i*20);
       ctx.setLineDash([1, 1]);
       ctx.stroke();
        }

      }  
       ctx.rect(10,10,100, 340);
       ctx.stroke();
      ctx.font = "bold 8pt Arial";
      ctx.fillStyle = "Red";
      ctx.fillText("PQC",15,20);
      ctx.fillStyle = "Blue";
      ctx.fillText("DLC",15,40);
      ctx.fillStyle = "Brown";
      ctx.fillText("BC",15,60);
      ctx.fillStyle = "Chartreuse";
      ctx.fillText("DBM",15,80);
      ctx.fillStyle = "Aqua";
      ctx.fillText("WMM-Top",15,100);
      ctx.fillStyle = "green";
      ctx.fillText("GSB-Top",15,120);
      ctx.fillStyle = "grey";
      ctx.fillText("Sub Grade",15,140);
      ctx.fillStyle = "black";
      ctx.fillText("Chainage",15,180);
      ctx.fillStyle = "grey";      
      ctx.fillText("Sub Grade",15,220);
      ctx.fillStyle = "green";
      ctx.fillText("GSB-Top",15,240);        
      ctx.fillStyle = "Aqua";  
      ctx.fillText("WMM-Top",15,260);
      ctx.fillStyle = "Chartreuse";
      ctx.fillText("DBM",15,280);
      ctx.fillStyle = "Brown";
      ctx.fillText("BC",15,300);
      ctx.fillStyle = "Blue";
      ctx.fillText("DLC",15,320);
      ctx.fillStyle = "red";
      ctx.fillText("PQC",15,340);

     for ( i = 0; i < 41; i++) {
       ctx.moveTo(x1+120+i*20, 10);
       ctx.lineTo(x1+120+i*20, 350);
       ctx.setLineDash([1, 1]);
       ctx.stroke();
        }
       ctx.save();
       ctx.translate( 125 , 205 );
       ctx.rotate( Math.PI*1.5 );
       //ctx.font = "16px serif";  
       ctx.font = "bold 8pt Arial";
       ctx.fillStyle = "black";
       for ( i = 0; i < 41; i++) {
           ctx.fillText(changein_chainage(i*50+(page-1)*2000), 0,i*20);
        }           
       ctx.restore();
      
       for ( i = 0; i <41; i++) {
         j=i+(page-1)*40;
         ctx.fillStyle = "Red";
         if (pqc[j].status==1){ ctx.fillRect(x1+100+i*20,11,19,19);}
         ctx.fillStyle = "Blue";
         if (dlc[j].status==1){ ctx.fillRect(x1+100+i*20,31,19,19);} 
        ctx.fillStyle = "Brown";
        if (bc[j].status==1){ ctx.fillRect(x1+100+i*20,51,19,19);}
        ctx.fillStyle = "Chartreuse";
        if (bm[j].status==1){ctx.fillRect(x1+100+i*20,71,19,19);}        
        ctx.fillStyle = "Aqua";
        if (wmm[j].status==1){ ctx.fillRect(x1+100+i*20,91,19,19);}
        ctx.fillStyle = "green";
        if (gsb[j].status==1){  ctx.fillRect(x1+100+i*20,111,19,19);}
        ctx.fillStyle = "grey";
        if (sg[j].status==1){ ctx.fillRect(x1+100+i*20,131,19,19);}
//right side
        ctx.fillStyle = "Red";
         if (pqcr[j].status==1){ ctx.fillRect(x1+100+i*20,331,19,19);}
         ctx.fillStyle = "Blue";
         if (dlcr[j].status==1){ ctx.fillRect(x1+100+i*20,311,19,19);} 
        ctx.fillStyle = "Brown";
        if (bcr[j].status==1){ ctx.fillRect(x1+100+i*20,291,19,19);}
        ctx.fillStyle = "Chartreuse";
        if (bmr[j].status==1){ctx.fillRect(x1+100+i*20,271,19,19);}        
        ctx.fillStyle = "Aqua";
        if (wmmr[j].status==1){ ctx.fillRect(x1+100+i*20,251,19,19);}
        ctx.fillStyle = "green";
        if (gsbr[j].status==1){  ctx.fillRect(x1+100+i*20,231,19,19);}
        ctx.fillStyle = "grey";
        if (sgr[j].status==1){ ctx.fillRect(x1+100+i*20,211,19,19);}

        
       }
       ctx.save();

}
function getsectionlength() {	
	var b=document.getElementById("scn").value;
    $.ajax({
        type:"post",
        url:"<?=base_url()?>index.php/Report/saveroadselsection/"+b,
        dataType:"Text",
        success:function(data){                    	
            location.reload();
           // alert(data);
           }
    });
		
	}
function print_stripmap(i){
   if (i==0){ window.print();}else{  
    printJS({printable: document.querySelector("#stripplan").toDataURL(), type: 'image', imageStyle: 'width:100%'});
}
}    
</script>
<?php 
 function get_chainageformat($ch){  
    $a = (int)$ch;
    $b = $ch-$a;
    $string = $a."+". round($b*1000,2);
    return $string;
}
?>


</body>  
</html> 