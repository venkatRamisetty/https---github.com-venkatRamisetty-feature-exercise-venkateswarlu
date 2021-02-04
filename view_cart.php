<?php
session_start();
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View shopping cart</title>
<link href="style/style.css" rel="stylesheet" type="text/css"></head>
<body>
<h1 align="center">View Cart</h1>
<div class="cart-view-table-back">
<form method="post" action="cart_update.php">
<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
  <tbody>
 	<?php
	if(isset($_SESSION["cart_products"])) //check session var
    {
		$total = 0; //set initial total value
		$b = 0; //var for zebra stripe table 
		foreach ($_SESSION["cart_products"] as $cart_itm)
        {
			//set variables to use in content below
			$product_name = $cart_itm["product_name"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["product_price"];
			$product_code = $cart_itm["product_code"];
			$product_color = $cart_itm["product_color"];

// special discount price
$rebatesA = array( 1 => 50, 3 => 130);  
$rebatesB = array( 1 => 30, 2 => 45);  
$rebatesC = array( 1 => 20, 2 => 38, 3 => 50);  
$rebatesD = array( 1 => 15, 5 => 130);  
$rebatesE = array( 1 => 5); 


$count = $product_qty;
$item=$product_code;
//$Aitemcount=$_REQUEST["aitem"];
$Aprice=$Bprice=$Cprice=$Dprice=$Eprice=0;

if ($item == 'A'){	

		$discount=$rebatesA[3]/3;
	    if($count <= 2){ $Aprice=  $count * $rebatesA[1]; }
	    if($count >=3){ $Aprice= round($discount * $count);}  
     $subtotal= $Aprice ;
	 $Aitemcount=$count;
}

if ($item == 'B'){
		$discount=$rebatesB[2]/2;
	    if($count==1){ $Bprice= $rebatesB[1]; }
	    if($count >=2){ $Bprice= round($discount * $count);} 
      $subtotal= $Bprice;
	   }

if ($item == 'C'){	
	$discount=$rebatesC[3]/3;
	if($count==1){ $Cprice= $rebatesC[1]; }
	if($count==2){ $Cprice= $rebatesC[2];}
	if($count >=3){ $Cprice= round($discount * $count);}  
  $subtotal=$Cprice;
}

if ($item == 'D'){	
$Aitemcount=isset($Aitemcount)? $Aitemcount:'';
    if($Aitemcount > $count){$Dcount=$Aitemcount-$count;$Dprice= $count*5;}
  else{ $Dcount=$count-$Aitemcount; $Dprice= $Aitemcount*5 + $Dcount*15; }	
 $subtotal=$Dprice;
}
if ($item == 'E'){			
	$subtotal= $count*$rebatesE[1];   
  //  echo $Eprice;
}

			
		   	$bg_color = ($b++%2==1) ? 'odd' : 'even'; 
		    echo '<tr class="'.$bg_color.'">';
			echo '<td><input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
			echo '<td>'.$product_name.'</td>';
			echo '<td>'.$currency.$product_price.'</td>';
			echo '<td>'.$currency.$subtotal.'</td>';
			echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
            echo '</tr>';
			$total = ($total + $subtotal); //add subtotal to total var
        }
		
		$grand_total = $total ; //grand total including shipping cost
		
		
		
	}
    ?>
    <tr><td colspan="5"><span style="float:right;text-align: right;">Amount Payable : <?php echo sprintf("%01.2f", $grand_total);?></span></td></tr>
    <tr><td colspan="5"><a href="index.php" class="button">Add More Items</a><button type="submit">Update</button></td></tr>
  </tbody>
</table>
<input type="hidden" name="return_url" value="<?php 
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" />
</form>
</div>

</body>
</html>
