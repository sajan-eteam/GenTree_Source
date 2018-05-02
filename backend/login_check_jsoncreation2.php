<?php
include "../includes/init.php";

$login			= 	"login";
//$username		= 	"sys";
//$password		= 	"admin";
$time       	= 	"0000-00-00 00:00:00";
$gentree		= 	array();
$album      	= 	array();
$objappuser		= 	new user();
$objimages  	= 	new images();
$info			= 	array();
$objtagging		=	new tagging();
$objuser		=	new geneuser();

$username		= 	$_POST['username'];
$password		= 	$_POST['password'];

$login_check	=	$objappuser->loginJsoncheck($username,$password);
$user_name		=	$login_check['sys_user_name'];
$pass_word		=	$login_check['sys_password'];

$url			=	"http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload";
    
/*
if($time == '0000-00-00 00:00:00')
{
	if($username !="" && $password !="")
	{
*/
	   //if($user_name == $username && $pass_word == $password)
	   if($login_check == 1)
		{  
				$loginarray = array("Reqfor"=>$login,"Username"=>$username,"Password"=>$password);
				$alluser	= $objuser->allusers();
				
				for($i=0;$i<count($alluser);$i++)
				{
					$gen_id				 	= 	$alluser[$i]['gene_user_id'];
					$gen_name 				= 	(isset($alluser[$i]['gene_name']) && $alluser[$i]['gene_name'] !='') ? $alluser[$i]['gene_name'] : '';
					$gene_surname 			= 	(isset($alluser[$i]['gene_surname']) && $alluser[$i]['gene_surname'] !='') ? $alluser[$i]['gene_surname'] : '';
					$nickName 				= 	(isset($alluser[$i]['gene_nickname']) && $alluser[$i]['gene_nickname'] !='') ? $alluser[$i]['gene_nickname'] : '';
					$gene_relation_type 	= 	(isset($alluser[$i]['gene_relation_type']) && $alluser[$i]['gene_relation_type'] !='') ? $alluser[$i]['gene_relation_type'] : '';
					$gen_rel_id 			= 	(isset($alluser[$i]['gene_rel_id_1']) && $alluser[$i]['gene_rel_id_1'] !='') ? $alluser[$i]['gene_rel_id_1'] : '';
					$gen_re_id2 			= 	(isset($alluser[$i]['gene_rel_id_2']) && $alluser[$i]['gene_rel_id_2'] !='') ? $alluser[$i]['gene_rel_id_2'] : '';
					$sex 					= 	(isset($alluser[$i]['gene_sex']) && $alluser[$i]['gene_sex'] !='') ? $alluser[$i]['gene_sex'] : '';
					$birthday 				= 	(isset($alluser[$i]['gene_birthday']) && $alluser[$i]['gene_birthday'] !='') ? $alluser[$i]['gene_birthday'] : '';
					$PlaceOfBirth 			= 	(isset($alluser[$i]['gene_place_birth']) && $alluser[$i]['gene_place_birth'] !='') ? $alluser[$i]['gene_place_birth'] : '';
					$UserDeathDay 			= 	(isset($alluser[$i]['gene_deathday']) && $alluser[$i]['gene_deathday'] !='') ? $alluser[$i]['gene_deathday'] : '';				
					$ResidentIn 			= 	(isset($alluser[$i]['gene_resident_in']) && $alluser[$i]['gene_resident_in'] !='') ? $alluser[$i]['gene_resident_in'] : '';	
					$gene_cap 				= 	(isset($alluser[$i]['gene_cap']) && $alluser[$i]['gene_cap'] !='') ? $alluser[$i]['gene_cap'] : '';	
					$gene_city 				= 	(isset($alluser[$i]['gene_city']) && $alluser[$i]['gene_city'] !='') ? $alluser[$i]['gene_city'] : '';
					$gene_province 			= 	(isset($alluser[$i]['gene_province']) && $alluser[$i]['gene_province'] !='') ? $alluser[$i]['gene_province'] : '';					
					$gene_nation 			= 	(isset($alluser[$i]['gene_nation']) && $alluser[$i]['gene_nation'] !='') ? $alluser[$i]['gene_nation'] : '';
					$gene_telephone_home 	= 	(isset($alluser[$i]['gene_telephone_home']) && $alluser[$i]['gene_telephone_home'] !='') ? $alluser[$i]['gene_telephone_home'] : '';				
					$gene_telephone_office	= 	(isset($alluser[$i]['gene_telephone_office']) && $alluser[$i]['gene_telephone_office'] !='') ? $alluser[$i]['gene_telephone_office'] : '';
					$gene_mobile_no_1 		= 	(isset($alluser[$i]['gene_mobile_no_1']) && $alluser[$i]['gene_mobile_no_1'] !='') ? $alluser[$i]['gene_mobile_no_1'] : '';					
					$gene_mobile_no_2		= 	(isset($alluser[$i]['gene_mobile_no_2']) && $alluser[$i]['gene_mobile_no_2'] !='') ? $alluser[$i]['gene_mobile_no_2'] : '';
					$gene_email_office 		= 	(isset($alluser[$i]['gene_email_office']) && $alluser[$i]['gene_email_office'] !='') ? $alluser[$i]['gene_email_office'] : '';					
					$gene_website			= 	(isset($alluser[$i]['gene_website']) && $alluser[$i]['gene_website'] !='') ? $alluser[$i]['gene_website'] : '';
					$gene_email_personel_1	= 	(isset($alluser[$i]['gene_email_personel_1']) && $alluser[$i]['gene_email_personel_1'] !='') ? $alluser[$i]['gene_email_personel_1'] : '';		
					$gene_email_personel_2	= 	(isset($alluser[$i]['gene_email_personel_2']) && $alluser[$i]['gene_email_personel_2'] !='') ? $alluser[$i]['gene_email_personel_2'] : '';
					$gene_image				= 	(isset($alluser[$i]['gene_image']) && $alluser[$i]['gene_image'] !='') ? $url."/".$alluser[$i]['gene_image'] : '';			
					$gene_generation		= 	(isset($alluser[$i]['gene_generation']) && $alluser[$i]['gene_generation'] !='') ? $alluser[$i]['gene_generation'] : '';
					
					$users = array( 'backend'		=>	$gen_id,
									'Firstname'		=>	$gen_name,
									'Lastname'		=>	$gene_surname,
									'NickName'		=>	$nickName,
									'Gender'		=>	$sex,
									'UserBirthDay'	=>	$birthday,
									'PlaceOfBirth'	=>	$PlaceOfBirth,
									'UserDeathDay'	=>	$UserDeathDay,
									'ResidentIn'	=>	$ResidentIn,
									'CAP'			=>	$gene_cap,
									'city'			=>	$gene_city,
									'Province'		=>	$gene_province,
									'Nation'		=>	$gene_nation,									
									'TelephoneHome'	=>	$gene_telephone_home,
									'TelephoneOffice'=>	$gene_telephone_office,
									'MobileNumber1'	=>	$gene_mobile_no_1,
									'MobileNumber2'	=>	$gene_mobile_no_2,
									'EmailOffice'	=>	$gene_email_office,
									'Website'		=>	$gene_website,									
									'EmailPersonel1'=>	$gene_email_personel_1,
									'EmailPersonel2'=>	$gene_email_personel_2,
									'Image'			=>	$gene_image,
									'genlevel' 		=>	$gene_generation
									);
					$info[$i]=$users;
				}
				$data1		= json_encode($alluser);
				
				$objpairs	  = $objuser->allpairs();
			   
				for($i=0;$i<count($objpairs);$i++)
				{
					$user_id		= $objpairs[$i]['gene_user_id'];
					$spouse_id		= $objpairs[$i]['gene_rel_id_1'];
					$pair_genration = $objpairs[$i]['gene_generation'];
					$gene_name      = $objpairs[$i]['gene_name'];
					$gene_surname   = $objpairs[$i]['gene_surname'];  
					$genration 		= $pair_genration;
					$genrations 	= $genration+1;
					$gender         = $objuser->fathermother($user_id);
					$gender_name    = $gender['gene_sex'];
					$relation_gender= $objuser->motherrelation($spouse_id);
					$relation_id    = $relation_gender['gene_sex'];
					if($gender_name == 'f')
					{						
						$mother_id	=  $gender['gene_user_id'];	
					}
					if($relation_id == 'f')
					{
						$mother_id  = $relation_gender['gene_user_id'];
						
					}
					if($gender_name == 'm')
					{
						$father_id =  $gender['gene_user_id'];
						
					}
					
					if($relation_id == 'm')
					{
						$father_id =  $relation_gender['gene_user_id'];
						
					}

					$objpairs[$i]['father']  = $father_id;
					$objpairs[$i]['mother']  = $mother_id;
					
					$objchild		=	array();
					$offspringarray	=	array();
					$objchilds		=	array();
					
					$objchild	=	$objuser->allchild($user_id, $spouse_id);
					
					$count      =	count($objchild);
					
					for($j=0;$j<count($objchild);$j++)
					{
						$obj = $objchild[$j]['gene_user_id'];
						$objchilds[$j] = $obj;
					}
					if($count>0)
					{
						$offspringarray    =  $objchilds;
					}
					else
					{
						$offspringarray    =  $objchild;
                        if($objchild == null)
						{
							$offspringarray = array();
						}

					} 
					
					$arrays =  array('m'=>$father_id,'f'=>$mother_id,'offsprings'=>$offspringarray);				
					$newPairs[$i]['couple']	=	$arrays;					
				}
				
				$allimages	= $objimages->allImages();

				for($i=0;$i<count($allimages);$i++)
				{                   
					$album_id		=	$allimages[$i]['id_gallery'];					
					$image_id		=	$allimages[$i]['id_image'];
					
					$image_name		= (isset($allimages[$i]['image_src'])) ? $url."/".$allimages[$i]['image_src'] : '';
					$image_title	= (isset($allimages[$i]['image_title'])) ? $allimages[$i]['image_title'] : '';
					$image_desc		= (isset($allimages[$i]['image_description'])) ? $allimages[$i]['image_description'] : '';
					$image_date		= (isset($allimages[$i]['image_date'])) ? $allimages[$i]['image_date'] : '';
									
					$getgallery     =   $objimages->getGallery($album_id);                   
					$taggingdetails =	$objtagging->taggingDetails($image_id);
					
					for($j=0;$j<count($taggingdetails);$j++)
					{
						$taguserid			=	$taggingdetails[$j]['gene_user_id'];
						$tagid				=	$taggingdetails[$j]['id_tag'];
						$lastmodified		=	$taggingdetails[$j]['LastModifiedTime'];
						if($lastmodified == null)
						{
							
							$taggingdetails[$j]['LastModifiedTime'] = "0000-00-00 00:00:00";

						}
						$username		=	$objuser->family_name($taguserid);
						$Name           =   $username['gene_name']." ".$username['gene_surname'];
						$taggingdetails[$j]['tagName']= $Name;
						$taggingdetails[$j]['tagId'] = $tagid;
						
					}
					
					$albums			=	$allimages[$i]['Albumdetails'];
					$images			=	$allimages[$i]['Imagedetails'];
					$tags			=   $allimages[$i]['taggindetails'];
				    //$url            =   "http://192.168.0.36/dea_albero_2/upload"; 
					//$url            =   "http://www.e-zenitsviluppo.it/dea_albero_2/upload"; 

					
					$albums			=	array('albumid' =>$album_id,'album_name' =>$getgallery);
					
					$images			=	array(	'imageId' =>$image_id,
												'image_name' =>$image_name,
												'image_date' =>$image_date,
												'image_title' =>$image_title,
												'image_description' =>$image_desc
											 );
					$tags			=   $taggingdetails;					

					if($taggingdetails == null)
					{
						$tags = array();
					}

					$finaljson[$i]= $albums;
					$finaljson[$i]['images']= $images;
					$finaljson[$i]['images']['tags']=$tags;  
					
				}
				$finalJson=$loginarray;
				$finalJson['Memberlist']['individual']=$info;
				
				if(sizeof($newPairs) > 0)				
					$finalJson['couples'] 		= $newPairs;
				else
					$finalJson['couples'] 		= array();
					
				$finalJson['ALBUMS']['gallery']	=	$finaljson; 
				$gentree['Gentree'] 			= $finalJson;
				echo json_encode($gentree);
				//echo "<PRE>"; print_r($gentree);echo "</PRE>";

		}
		else
		{
			echo "0";
		}
/*
	}
	else
	{
		echo "invalid";
	}
}
*/
/*if($time == '2013-09-20 05:09:58')
{

 $lastModifiedtime  = $objuser->user_tag();
 for($i=0;$i<count($lastModifiedtime);$i++)
 {
	 $lastModified_time = $lastModifiedtime[$i]['LastModifiedTime'];
 }
	
  if($username !="" && $password !="")
	{

	   if($user_name == $username && $pass_word == $password)
		{  
				$loginarray = array("Reqfor"=>$login,"Username"=>$username,"Password"=>$password);
				$alluser	= $objuser->alluserslist($lastModified_time,$time);
				for($i=0;$i<count($alluser);$i++)
				{
					$gen_id				 = $alluser[$i]['gene_user_id'];
					$gen_name			 = $alluser[$i]['gene_name'];
					$gene_surname		 = $alluser[$i]['gene_surname'];
					
					$gene_relation_type  = $alluser[$i]['gene_relation_type'];
					$gen_rel_id          = $alluser[$i]['gene_rel_id_1']; 
					$gen_re_id2			 = $alluser[$i]['gene_rel_id_2'];
					$gene_generation	 = $alluser[$i]['gene_generation'];
					$sex				 = $alluser[$i]['gene_sex'];
					
					$users = array('backend'=>$alluser[$i]['gene_user_id'],'Firstname'=>$alluser[$i]['gene_name'],'Lastname'=>$alluser[$i]['gene_surname'],'Gender'=>$sex,'UserBirthDay'=>$alluser[$i]['gene_birthday'],'UserDeathDay'=>$alluser[$i]['gene_deathday'],'genlevel' =>$alluser[$i]['gene_generation']);
					$info[$i]=$users;
				}
				$data1		= json_encode($alluser);
				$objpairs	  = $objuser->allpairslist($lastModified_time,$time);
			   
				for($i=0;$i<count($objpairs);$i++)
				{
					$user_id		= $objpairs[$i]['gene_user_id'];
					$spouse_id		= $objpairs[$i]['gene_rel_id_1'];
					$pair_genration = $objpairs[$i]['gene_generation'];
					$gene_name      = $objpairs[$i]['gene_name'];
					$gene_surname   = $objpairs[$i]['gene_surname'];  
					$genration 		= $pair_genration;
					$genrations 	= $genration+1;
					$gender         = $objuser->fathermother($user_id);
					$gender_name    = $gender['gene_sex'];
					$relation_gender= $objuser->motherrelation($spouse_id);
					$relation_id    = $relation_gender['gene_sex'];
					if($gender_name == 'f')
					{
						
						$mother_id	=  $gender['gene_user_id'];	
					}
					if($relation_id == 'f')
					{
						$mother_id  = $relation_gender['gene_user_id'];
						
					}
					if($gender_name == 'm')
					{
						$father_id =  $gender['gene_user_id'];
						
					}
					
					if($relation_id == 'm')
					{
						$father_id =  $relation_gender['gene_user_id'];
						
					}

					$objpairs[$i]['father']  = $father_id;
					$objpairs[$i]['mother']  = $mother_id;
					$objchild	=	$objuser->allchildlist($user_id,$spouse_id);
					$count      =	count($objchild);
					for($j=0;$j<count($objchild);$j++)
					{
						$obj = $objchild[$j]['gene_user_id'];
						$objchilds[$j] = $obj;
					}
					if($count>0)
					{
						$offspringarray    =  $objchilds;
					}
					else
					{
						$offspringarray    =  $objchild;
					}
					
					$arrays =  array('f'=>$father_id,'m'=>$mother_id,'offsprings'=>$offspringarray);
				
					$newPairs[$i]['couple']	=	$arrays;
						
				}
				
				$allimages	= $objimages->allImageslist($time);


				for($i=0;$i<count($allimages);$i++)
				{

					$album_id		=	$allimages[$i]['id_gallery'];
					
					$image_id		=	$allimages[$i]['id_image'];

					$image_name     =   $allimages[$i]['image_src'];

					$getgallery     =   $objimages->getGallerylist($album_id,$time);

					$taggingdetails =	$objtagging->taggingDetailslist($image_id,$time);
					

					for($j=0;$j<count($taggingdetails);$j++)
					{
						$taguserid			=	$taggingdetails[$j]['gene_user_id'];
						$tagid				=	$taggingdetails[$j]['id_tag'];
						$username		=	$objuser->family_name($taguserid);
						$Name           =   $username['gene_name'];
						$taggingdetails[$j]['tagName']= $Name;
						$taggingdetails[$j]['tagId'] = $tagid;
						
					}
					
					$albums			=	$allimages[$i]['Albumdetails'];
					$images			=	$allimages[$i]['Imagedetails'];
					$tags			=   $allimages[$i]['taggindetails'];
				   
					
					$albums			=	array('albumid' =>$album_id,'album_name' =>$getgallery);
					$images			=	array('imageId' =>$image_id,'image_name' =>$image_name);
					$tags			=   $taggingdetails;
					

					$finaljson[$i]= $albums;
					$finaljson[$i]['images']= $images;
					$finaljson[$i]['images']['tags']=$tags;  
					
				}
				$finalJson=$loginarray;
				$finalJson['Memberlist']['individual']=$info;
				$finalJson['couples'] = $newPairs;
				$finalJson['ALBUMS']['gallery']=$finaljson; 
				$gentree['Gentree'] = $finalJson;
				echo json_encode($gentree);

		}
	}
	else
	{
		echo "invalid";
	}

}*/

?>