<?php
include "../includes/init.php";
$objUser		= 	new	geneuser();

if($_POST['gender'])
{	
	$condition	=	"";
	$gender		=	$_POST['gender'];
	//$rootid			=   $objUser->relationexist();
	
		$rootid     =   $_POST['root']; 
		
		$wifeid     =   $_POST['wifeid'];
	   
	if($gender == 'm')
		$condition	=	"AND gene_sex = 'f' AND Trash='1'";
	else if($gender == 'f')
		$condition	=	"AND gene_sex = 'm' AND Trash='1'";
    
	if($wifeid == '' || $wifeid < 1)	
		$condition.= "";
	else
		$condition.= " AND (gene_user_id !='$rootid' AND gene_user_id !='$wifeid')";

	$user_details	=	$objUser->family_offsprings($condition, $rootid, $wifeid);
	

	echo "<option value=\"0\">Seleziona</option>";
	
		for($i=0; $i<sizeof($user_details); $i++)
		{
			if($user_details[$i]['gene_user_id']!=$gene_user_id){
				$birthYear	=	$user_details[$i]['gene_birthday'];
				$year       =   explode('-', $birthYear);
				$yyyy       =   $year[0];
			?>
				<option value="<?php echo $user_details[$i]['gene_user_id']; ?>">
					<?php echo $user_details[$i]['gene_name']." ".$user_details[$i]['gene_surname']." ".$yyyy; ?>
				</option>
			<?php
			}
		}
	
}
else
	echo "<option value=\"0\">Seleziona</option>";



?>