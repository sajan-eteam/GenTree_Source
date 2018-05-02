<?php
include "../includes/init_json.php";
require 'Fastimage.php';
$objuser		=	new geneuser();
$objappuser		= 	new user();
$objimages  	= 	new images();
$objtagging		=	new tagging();

$url			=	UPLOAD_PATH; //"http://".$_SERVER["SERVER_NAME"]."/dea_albero_2/upload";
function getAllUsers($objuser,$url,$condition,$reqfor)
{
	$info		= 	array();
    $trash      =   '1';
	$alluser	= 	$objuser->allusers($condition);			
	
	for($i=0;$i<count($alluser);$i++)
	{
		$gen_id				 	= 	 $alluser[$i]['gene_user_id'];
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
		$gene_publish_tree      =   (isset($alluser[$i]['gene_publish_tree']) && $alluser[$i]['gene_publish_tree'] !='') ? $alluser[$i]['gene_publish_tree'] : '';	
		$gene_website			= 	(isset($alluser[$i]['gene_website']) && $alluser[$i]['gene_website'] !='') ? $alluser[$i]['gene_website'] : '';
		$gene_email_personel_1	= 	(isset($alluser[$i]['gene_email_personel_1']) && $alluser[$i]['gene_email_personel_1'] !='') ? $alluser[$i]['gene_email_personel_1'] : '';		
		$gene_email_personel_2	= 	(isset($alluser[$i]['gene_email_personel_2']) && $alluser[$i]['gene_email_personel_2'] !='') ? $alluser[$i]['gene_email_personel_2'] : '';
		$gene_image				= 	(isset($alluser[$i]['gene_image']) && $alluser[$i]['gene_image'] !='') ? $url."/".$alluser[$i]['gene_image'] : '';			
		$gene_generation		= 	(isset($alluser[$i]['gene_generation']) && $alluser[$i]['gene_generation'] !='') ? $alluser[$i]['gene_generation'] : '';
		$lastmodifiedtime		= 	(isset($alluser[$i]['LastModifiedTime']) && $alluser[$i]['LastModifiedTime'] !='') ? $alluser[$i]['LastModifiedTime'] : '';
		$trash                  =  (isset($alluser[$i]['Trash']) && $alluser[$i]['Trash'] !='') ? $alluser[$i]['Trash'] : '';

		$mostraStatus           =  (isset($alluser[$i]['gene_publish_app']) && $alluser[$i]['gene_publish_app'] !='') ? $alluser[$i]['gene_publish_app'] : '';

        $label1 				= 	(isset($alluser[$i]['Label1']) && $alluser[$i]['Label1'] !='') ? $alluser[$i]['Label1'] : '';
		$Value1 				= 	(isset($alluser[$i]['Value1']) && $alluser[$i]['Value1'] !='') ? $alluser[$i]['Value1'] : '';
		$label2 				= 	(isset($alluser[$i]['Label2']) && $alluser[$i]['Label2'] !='') ? $alluser[$i]['Label2'] : '';
		$Value2 				= 	(isset($alluser[$i]['Value2']) && $alluser[$i]['Value2'] !='') ? $alluser[$i]['Value2'] : '';
		$label3 				= 	(isset($alluser[$i]['Label3']) && $alluser[$i]['Label3'] !='') ? $alluser[$i]['Label3'] : '';
		$Value3 				= 	(isset($alluser[$i]['Value3']) && $alluser[$i]['Value3'] !='') ? $alluser[$i]['Value3'] : '';

		$publishFatherName      =  (isset($alluser[$i]['gene_publish_father_name']) && $alluser[$i]['gene_publish_father_name'] !='') ? $alluser[$i]['gene_publish_father_name'] : '0';
		$publishYear      		=  (isset($alluser[$i]['gene_publish_year']) && $alluser[$i]['gene_publish_year'] !='') ? $alluser[$i]['gene_publish_year'] : '0';

        $gen_name				=	getCleanString($gen_name);
        $gene_surname			=	getCleanString($gene_surname);
        $nickName				=	getCleanString($nickName);
        $PlaceOfBirth			=	getCleanString($PlaceOfBirth);
        $ResidentIn 			=	getCleanString($ResidentIn);
        $gene_cap				=	getCleanString($gene_cap);
        $gene_city				=	getCleanString($gene_city);
        $gene_province			=	getCleanString($gene_province);
        $gene_nation			=	getCleanString($gene_nation);

        $label1 				=	getCleanString($label1);
        $Value1 				=	getCleanString($Value1);
        $label2 				=	getCleanString($label2);
        $Value2 				=	getCleanString($Value2);
        $label3 				=	getCleanString($label3);
        $Value3 				=	getCleanString($Value3);

		$delstatus = $trash;
		if($gene_publish_tree== 0)
		{
		   $delstatus = 0;
		}
		
        /*
        if($reqfor=='login')
		{
			//$time      = " ";
              $delstatus = $trash;

		}
		if($reqfor=='sync')
		{
             if($trash == 0 && $gene_publish_tree== 0)
			{
               $delstatus = 0;
			}
			else if($trash == 1 && $gene_publish_tree== 0)
			{
               $delstatus = 0;
			}
			else if($trash == 1 && $gene_publish_tree== 1)
			{
               $delstatus = 1;
			}
		}
		*/
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
						'genlevel' 		=>	$gene_generation,
			            'mostraStatus'	=> $mostraStatus,
			            'delStatus'     =>  $delstatus,
			            'titleone'     	=>  $label1,
			            'valueone'     	=>  $Value1,
			            'titletwo'     	=>  $label2,
			            'valuetwo'     	=>  $Value2,
			            'titlethree'    =>  $label3,	
			            'valuethree'    =>  $Value3,
			            'showFatherName' =>  $publishFatherName,	
			            'showBirthYear'  =>  $publishYear
						);
		$info[$i]=$users;
	}
	return $info;
	
}

function getAllPairs($objuser, $condition, $reqFor)
{
	$newPairs		= 	array();
    $infos			=	array();
	$spousearray    =   array();
	$delchild		=   array();
	$delarrays      =   array();


	$objpairs	  	= 	$objuser->allpairs($reqFor);	
	
	for($i=0; $i<count($objpairs); $i++)
	{
		$user_id				= $objpairs[$i]['gene_user_id'];
		$spouse_id				= $objpairs[$i]['gene_rel_id_1'];
		$pair_genration 		= $objpairs[$i]['gene_generation'];
		$gene_name      		= $objpairs[$i]['gene_name'];
		$gene_surname   		= $objpairs[$i]['gene_surname'];
		$relationtype   		= $objpairs[$i]['gene_relation_type'];
		$marriageYear			= $objpairs[$i]['gene_marriage_year'];

		$marriageYear_arr		= explode('-', $objpairs[$i]['gene_marriage_year']);

		$marriageYear			= 	(isset($marriageYear) && $marriageYear !='' && $marriageYear !='0000-00-00') ? $marriageYear_arr[0] : '';
		$couple_modified_date	= $objpairs[$i]['LastModifiedTime'];
		$gender         		= $objpairs[$i]['gene_sex'];		
		$reltype        		= $relationtype-2;		
		$genrations 			= $pair_genration+1;		
		$gender_name    		= $gender['gene_sex'];
		$relation_gender		= $objuser->motherrelation($spouse_id);
		$relation_id    		= $relation_gender['gene_sex'];
        
		if($gender == 'f')
		{						
			$mother_id		=  $objpairs[$i]['gene_user_id'];	
			$father_id 		=  $objpairs[$i]['gene_rel_id_1'];
		}
		if($gender == 'm')
		{
			$father_id 		=  $objpairs[$i]['gene_user_id'];
			$mother_id		=  $objpairs[$i]['gene_rel_id_1'];	
		}
		
			
		$objpairs[$i]['father']  = $father_id;
		$objpairs[$i]['mother']  = $mother_id;
		
		
		$objchild		=	array();
		$objchilds		=	array();
		$offspringarray	=	array();
		
		
		$objchild	=	$objuser->allchild($user_id, $spouse_id, $condition);
		$count      =	count($objchild);


		$userDetails			=	$objuser->getuser($spouse_id);
		$lastModifiedTimeUser	=	$userDetails['LastModifiedTime'];
		$userTrashStatus		=	$userDetails['Trash'];
		$userPublishStatus		=	$userDetails['gene_publish_tree'];

		if($userPublishStatus == 1) {
		
			if($count>0)
			{
				for($j=0;$j<count($objchild);$j++)
				{
					$objchilds[$j]	= $objchild[$j]['gene_user_id'];
				
				}		
				$offspringarray    =  $objchilds;
				
				$arrays =  array('m'=>$father_id, 'f'=>$mother_id, 'Relation_type'=>$reltype, 'Marriage_year'=>$marriageYear, 'offsprings'=>$offspringarray);			
				$newPairs[sizeof($newPairs)]['couple']	=	$arrays;
			}
			else
			{
				if($couple_modified_date > $condition) {

					$objchild	=	$objuser->allchild($user_id, $spouse_id);
					$count      =	count($objchild);	
					if($count>0)
					{
						for($j=0;$j<count($objchild);$j++)
						{
							$objchilds[$j]	= $objchild[$j]['gene_user_id'];
						
						}		
						$offspringarray    =  $objchilds;
					}

					$arrays =  array('m'=>$father_id, 'f'=>$mother_id, 'Relation_type'=>$reltype, 'Marriage_year'=>$marriageYear, 'offsprings'=>$offspringarray);			
					$newPairs[sizeof($newPairs)]['couple']	=	$arrays;				
				}
				else {
						if($userPublishStatus == 1) {

							if($lastModifiedTimeUser > $condition)
							{
								$objchild	=	$objuser->allchild($user_id, $spouse_id);
								$count      =	count($objchild);	
								if($count>0)
								{
									for($j=0;$j<count($objchild);$j++)
									{
										$objchilds[$j]	= $objchild[$j]['gene_user_id'];
									
									}		
									$offspringarray    =  $objchilds;
								}

								$arrays =  array('m'=>$father_id, 'f'=>$mother_id, 'Relation_type'=>$reltype, 'Marriage_year'=>$marriageYear, 'offsprings'=>$offspringarray);			
								$newPairs[sizeof($newPairs)]['couple']	=	$arrays;				
							}
						}
				}
			}
		}
	}
	return $newPairs;
}

function getGalleryDetails($objimages,$objtagging,$objuser,$url,$condition,$reqfor)
{
	$galleryList	=	$objimages->getGalleryLists();
	$album_list		=	array();
	for($i=0; $i<count($galleryList); $i++)
	{
		$gallery_id		=	$galleryList[$i]['id_gallery'];
		$gallery_name	=	$galleryList[$i]['gallery_title'];		
		
		$albums			=	array(	'albumid' =>$gallery_id, 
									'album_name' =>$gallery_name
								 );
		
		$image_list		=	$objimages->galleryImages($gallery_id, $condition);
		$image_tag_array	=	array();
		for($image_count=0; $image_count < sizeof($image_list); $image_count++)
		{
			$image_id			=	$image_list[$image_count]['id_image'];			
			$image_name			= 	(isset($image_list[$image_count]['image_src'])) ? $url.$image_list[$image_count]['image_src'] : '';
			
			list($width,$height) = 	getimagesize("../upload/".$image_list[$image_count]['image_src']);
			//list($width,$height)= 	getimagesize($image_name);
			
			if($width == NULL || $width =='')
				$width = 0;
			if($height == NULL || $height =='')
				$height = 0;

			if($width == 0 && $height == 0) {
				$imageURI = new FastImage(rawurlencode($image_name));
				list($width, $height) = $imageURI->getSize(); 				
			}

			$image_title		= 	(isset($image_list[$image_count]['image_title'])) ? $image_list[$image_count]['image_title'] : '';
			$image_desc			= 	(isset($image_list[$image_count]['image_description'])) ? $image_list[$image_count]['image_description'] : '';
			$image_date			= 	(isset($image_list[$image_count]['image_date'])) ? $image_list[$image_count]['image_date'] : '';
		    $updt_image_time    = 	(isset($image_list[$image_count]['LastModifiedTime'])) ? $image_list[$image_count]['LastModifiedTime'] : '';
			$trash              =   (isset($image_list[$image_count]['Trash'])) ? $image_list[$image_count]['Trash'] : '';
			$imagePublish       =   (isset($image_list[$image_count]['image_publish'])) ? $image_list[$image_count]['image_publish'] : '';
            $image_title		=	getCleanString($image_title);
            $image_desc			=	getCleanString($image_desc);

            if($trash == 1) {
            	$trash = $imagePublish;
            }
         
			$images				=	array(	'imageId' 			=>	$image_id,
											'image_name' 		=>	$image_name,
											'image_date' 		=>	$image_date,
											'image_title' 		=>	$image_title,
											'image_description' =>	$image_desc,
										    //'LastModifiedTime'  =>  $time,
										    'image_width'       =>  $width,
										    'image_height'      =>  $height,
											'delStatus'         =>  $trash 
										 );
					
			$tagDetails			=	array();
			$imageTagDetails 	=	$objtagging->taggingDetails($image_id,$condition);			
			for($tag_count=0; $tag_count<count($imageTagDetails);$tag_count++)
			{
				$tag_user_id		=	$imageTagDetails[$tag_count]['gene_user_id'];
				
				$tag_id				=	$imageTagDetails[$tag_count]['id_tag'];
                $tag_x				=	$imageTagDetails[$tag_count]['tag_x_cord'];
				$tag_y              =   $imageTagDetails[$tag_count]['tag_y_cord'];
				$tag_width          =   $imageTagDetails[$tag_count]['tag_width'];
				$tag_height         =   $imageTagDetails[$tag_count]['tag_heigth'];

				$last_modified		=	$imageTagDetails[$tag_count]['LastModifiedTime'];
				$del_sttaus         =   $imageTagDetails[$tag_count]['Trash'];
			
				
				$tag_username		=	$objuser->family_name($tag_user_id,$condition);
				$tag_name           =   $tag_username['gene_name']." ".$tag_username['gene_surname'];
				
				$tagDetails[$tag_count]['tagName']			=	$tag_name;
                $tagDetails[$tag_count]['BackendId']		=	$tag_user_id;
				$tagDetails[$tag_count]['tagId'] 			= 	$tag_id;
                $tagDetails[$tag_count]['tag_x_cord'] 	    = 	$tag_x;
                $tagDetails[$tag_count]['tag_y_cord'] 	    = 	$tag_y;
                $tagDetails[$tag_count]['tag_width'] 	    = 	$tag_width;
                $tagDetails[$tag_count]['tag_heigth'] 	    = 	$tag_height;
            
                $tagDetails[$tag_count]['delStatus']        =   $del_sttaus;
				
			}
			
			$image_tag_array[$image_count]			=	$images;
			$image_tag_array[$image_count]['tags']	=	$tagDetails;
		}
		
		$album_list[$i]				=	$albums;	
		$album_list[$i]['images']	=	$image_tag_array;
	}	
	return $album_list;
}
function getTestiDetails($objtesti,$reqfor,$condition)
{
  $textDetails			=	array();
  $array				=	array();
  $testidetails			=	$objtesti->GetAllTestiDetails($condition);

  if($testidetails[0]['id_text'] > 0) {
  		$testdetails	=	$objtesti->GetAllTestiDetails();
  		$text_title		=   $testidetails[0]['text_title'];
		$text_desc		=   $testidetails[0]['text_desc'];
		$msg_title		=   $testidetails[1]['text_title'];
		$msg_desc		=   $testidetails[1]['text_desc'];
  } else {

  		$text_title		=   '';
		$text_desc		=   '';
		$msg_title		=   '';
		$msg_desc		=   '';
  }

  /*
  for($i=0;$i<2;$i++)
	{
		
		$text_title		=   $testidetails[0]['text_title'];
		$text_desc		=   $testidetails[0]['text_desc'];
		$msg_title		=   $testidetails[1]['text_title'];
		$msg_desc		=   $testidetails[1]['text_desc'];
	}
 */

	$array['message_albero']['TextTitile']              = getCleanString($text_title);
	$array['message_albero']['TextDescription']         = getCleanString($text_desc);
    $array['message_introduzione']['TextTitile']        = getCleanString($msg_title);
    $array['message_introduzione']['TextDescription']   = getCleanString($msg_desc);
   return $array;
}

function getgeneration($objuser,$condition,$reqfor)
{

	$generartion 	=	array();
	$gene           =   array();
	$allgeneration	=	$objuser->allgeneration();

	for($i=0;$i<count($allgeneration);$i++)
	{
      
	$generartion[$i] =  $allgeneration[$i]['gene_user_id'];
	
	}
    
    return $generartion;

}

function get_rubrica_email($objtesti)
{

	$testidetails	=	$objtesti->getTestidata(4);
	return trim($testidetails[0]['text_desc']);
}

function getImageName($photoName, $photoObject, $user_id)
{
	$hex 		 = preg_replace('/[\s\W]+/','',$photoObject);
	$binary 	 = pack("H*", $hex);
	$photoObject = base64_decode($binary);
	$im 		 = imagecreatefromstring($binary);
	$photoName   = preg_replace('/\s+/', '_' , $photoName);
	if ($im !== false) {
		$filedb = '../upload/'.time().'_'.$user_id.'_'.$photoName;
	    imagepng($im, $filedb);
	    imagedestroy($im);
	    return $filedb;
	}
	else {
    	return "error";
    }
}

function getInstaImages($objInstaAlbum, $objappuser, $objInstaTags, $uploadPath, $condition, $reqfor){
	 

	$image_list		=	$objInstaAlbum->instaImages($condition);

	$imagearray 	=   array();
	$instaAlbum     =   array();
	for($i=0;$i<count($image_list);$i++){

			$image_id		    =	$image_list[$i]['id_image'];	
			//$user_id 			=	$image_list[$i]['user_id'];		
			$image_name			= 	(isset($image_list[$i]['image_src'])) ? $uploadPath.$image_list[$i]['image_src'] : '';
	        $image_title		= 	(isset($image_list[$i]['image_title'])) ? $image_list[$i]['image_title'] : '';
			$image_desc			= 	(isset($image_list[$i]['image_description'])) ? $image_list[$i]['image_description'] : '';
			$image_date			= 	(isset($image_list[$i]['image_date'])) ? $image_list[$i]['image_date'] : '';
		    $updt_image_time    = 	(isset($image_list[$i]['LastModifiedTime'])) ? $image_list[$i]['LastModifiedTime'] : '';
			$trash              =   (isset($image_list[$i]['Trash'])) ? $image_list[$i]['Trash'] : '';
			$imagePublish       =   (isset($image_list[$i]['image_publish'])) ? $image_list[$i]['image_publish'] : '';
            $image_title		=	getCleanString($image_title);
            $image_desc			=	getCleanString($image_desc);
            list($width,$height) = 	getimagesize("../upload/".$image_list[$i]['image_src']);
			//list($width,$height)= 	getimagesize($image_name);
			
			if($width == NULL || $width =='')
				$width = 0;
			if($height == NULL || $height =='')
				$height = 0;

			if($width == 0 && $height == 0) {
				$imageURI = new FastImage(rawurlencode($image_name));
				list($width, $height) = $imageURI->getSize(); 				
			}

			if($reqfor=='sync' || $reqfor=='fullsync')
			{
				//echo $trash; echo $imagePublish;	
	             if($trash == '0' && $imagePublish== '0')
				{
	               $delstatus = '0';
				}
				else if($trash == '1' && $imagePublish== '0')
				{
	               $delstatus = '0';
				}
				else if($trash == '1' && $imagePublish== '1')
				{
	               $delstatus = '1';
				}
			}
			else{
				   $delstatus = $trash;
			}

		

            $imagearray[$i]     =   array(	'imageId' 			=>	$image_id,
            								//'user_id'			=>  $user_id,
											'image_name' 		=>	$image_name,
											'image_date' 		=>	$image_date,
											'image_title' 		=>	$image_title,
											'image_description' =>	$image_desc,
										    'LastModifiedTime'  =>  $updt_image_time,
										    'image_width'       =>  $width,
										    'image_height'      =>  $height,
											'delStatus'         =>  $delstatus 
										 ); 

        }

	// $instaAlbum['instaAlbum'] = $imagearray;

	 return $imagearray;
}
?>