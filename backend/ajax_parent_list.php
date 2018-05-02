<?php
include "../includes/init.php";
$objUser		= 	new	geneuser();
$madreID		=	$_POST['madreID'];
if($_POST['id'])
{	
	$user_id		=	$_POST['id'];
	$user_details	=	$objUser->getuser($user_id);
	
	if($user_details['gene_relation_type'] == 1 || $user_details['gene_relation_type'] == 2)
	{
		$sql_query	=	mysql_query("SELECT * FROM tab_gene_user WHERE gene_rel_id_1 = ".$user_id." AND gene_relation_type > 2 AND gene_sex = 'f'");
	}
	else if($user_details['gene_relation_type'] > 2)
	{	
		$sql_query	=	mysql_query("SELECT * FROM tab_gene_user WHERE gene_user_id = (SELECT gene_rel_id_1 FROM tab_gene_user WHERE gene_user_id = ".$user_id.") AND gene_sex = 'f'");		
	}
	echo "<option value=\"0\">Seleziona</option>";
	while($results	=	mysql_fetch_array($sql_query))
	{
		$gene_user_id		=	$results['gene_user_id'];
		$birthYear			=	$results['gene_birthday'];
		$year       		=   explode('-', $birthYear);
		$yyyy       		=   $year[0];

		$name_cogname		=	 getCleanString($results['gene_name']." ".$results['gene_surname']);
		if($madreID == $gene_user_id) {
			echo '<option value="'.$gene_user_id.'" selected="selected">'.$name_cogname.' '.$yyyy.'</option>';
		} else {
			echo '<option value="'.$gene_user_id.'">'.$name_cogname.' '.$yyyy.'</option>';
		}
		
	}
}
else
	echo "<option value=\"0\">Seleziona</option>";

?>