<?php

function authenticate ($db,$ucid,$pass ) {	
	$s="select * from USERS where ucid='$ucid' and pass='$pass' ";
	echo "<br>SQL select statement: $s<br>";
	($t = mysqli_query ($db, $s )) or die (mysqli_error ($db));
	$num = mysqli_num_rows($t);
	if($num==0){	return false ;}
	else	  {	return true  ;}
}

function list_transactions_wrapper($db,$ucid)
{
		$s="select * from TRANSACTIONS where ucid='$ucid' ";
		echo "<br>SQL select: $s<br>";
		($t = mysqli_query($db, $s)) or die (mysqli_error($db));
		
		$num = mysqli_num_rows($t);
		if ($num==0) {echo "No transactions<br>";	;}
		echo "$num transactions will follow.<br>";
		
		echo "<table border=2 width = 30%>";
		echo "<tr> <th> ucid</th><th> amount</th><th> timestamp</th></tr>";
		
		while ( $r = mysqli_fetch_array($t, MYSQLI_ASSOC))
		{
			echo"<tr>";
			$ucid=$r["ucid"]; $amount=$r["amount"]; $timestamp=$r["timestamp"];
			echo " <td>$ucid</td>"; echo"<td>$amount</td>"; echo "<td>$timestamp</td>";
			echo"</tr>";
		};
		
		echo"</table>";
		
;}

function clearaccount($db, $ucid, $account)
{
		$s="truncate * from TRANSACTIONS where ucid='$ucid' and account='$account' ";
		($t = mysqli_query($db, $s)) or die (mysqli_error($db));
;}

function list_accounts($db, $ucid)
{
		$s="select * from ACCOUNTS where ucid='$ucid' ";
		echo "<br>SQL select: $s<br>";
		($t = mysqli_query($db, $s)) or die (mysqli_error($db));
		
		$num = mysqli_num_rows($t);
		
		echo "<table border=2 width = 30%>";
		echo "<tr> <th> ucid</th><th> balance</th><th> account</th> <th> mostRecentTrans</th></tr>";
		
		while ( $r = mysqli_fetch_array($t, MYSQLI_ASSOC))
		{
			echo"<tr>";
			$ucid=$r["ucid"]; $balance=$r["balance"]; $account=$r["account"]; $mostRecentTrans=$r["mostRecentTrans"];
			echo " <td>$ucid</td>"; echo"<td>$balance</td>"; echo "<td>$account</td>"; echo "<td>$mostRecentTrans</td>";
			echo"</tr>";
		};
		
		echo"</table>";
}

function list_Number_transactions ($db, $ucid, $account, $N)
{
	$s="select * from TRANSACTIONS where ucid='$ucid' and account ='$account' ORDER BY timestamp LIMIT $N";
		echo "<br>SQL select: $s<br>";
		($t = mysqli_query($db, $s)) or die (mysqli_error($db));
		
		$num = mysqli_num_rows($t);
		if ($num==0) {echo "No transactions<br>";	;}
		echo "$num transactions will follow.<br>";
		
		echo "<table border=2 width = 30%>";
		echo "<tr> <th> ucid</th><th> amount</th><th> timestamp</th></tr>";
		
		while ( $r = mysqli_fetch_array($t, MYSQLI_ASSOC))
		{
			echo"<tr>";
			$ucid=$r["ucid"]; $amount=$r["amount"]; $timestamp=$r["timestamp"];
			echo " <td>$ucid</td>"; echo"<td>$amount</td>"; echo "<td>$timestamp</td>";
			echo"</tr>";
		};
		
		echo"</table>";
}

function perform($db, $ucid, $account, $amount)
{
	$s="select * from ACCOUNTS where
	ucid	='$ucid' and
	account ='$account' and
	balance +'$amount' >= 0.00 ";

($t=mysqli_query($db, $s)) or die(mysqli_error($db));
$num = mysqli_num_rows($t);
if ($num == 0){	exit("<br><br>Something is off ");};

$s="insert into TRANSACTIONS values( '$ucid', '$amount', '$account', NOW())";
echo "sql insert...: $s<br>";
($t = mysqli_query($db, $s)) or die(mysqli_error($db));

$s ="update ACCOUNTS
	set
		balance = balance + '$amount',
		mostRecentTrans = NOW()
	where
		ucid = '$ucid' and
		account ='$account'";
echo "sql update to accounts table ...: $s<br>";
($t=mysqli_query($db, $s)) or die(mysqli_error($db));
}
?>
