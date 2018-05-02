
$(function(){

	var dropbox = $('#dragarea'),
		message = $('.message', dropbox);
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'pic',
		url: 'img_file.php', //this is the PHP file used for processing
		uploadFinished:function(i,file,response)
		{   
			createImage(file);	
			filename=file.name;
			upload(filename);
			$.data(file).addClass('done');
			// response is the JSON object that img_file.php returns
		},
		
		// Called before each upload is started
		beforeEach: function(file)
		{		
			if(!file.type.match(/^image\//))
			{
				alert('Only images are allowed!');
				// Returning false will cause the
				// file to be rejected
				return false;
			}
		},
		uploadStarted:function(i, file, len)
		{
			//alert('TEST');
			createLoader();
			//createImage(file);
		},
	});
	var template = '<div class="preview" id="did">'+
						'<span class="imageHolder">'+
							'<img id="img"/>'+
							'<span class="uploaded"></span>'+
						'</span>'+
						'<div class="imgHolder">'+
							'<div class="img" ></div>'+
						'</div>'+
					'</div>';
	
  	
	function createLoader()
	{
		message.hide();
		$("#im").attr('src',"img/ajaxloader.gif");
		$("#im").show();		
	}

	function createImage(file)
	{
		var preview = $(template), 
			image = $('img', preview);
		var reader = new FileReader();
        //change these settings to customize the preview
        //size of the picture
		image.width = 50;
		image.height = 50;
		
		reader.onload = function(e){
					
			// e.target.result holds the DataURL which
			// can be used as a source of the image:

			image.attr('src', e.target.result);
		};
		
		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);
		message.hide();
         //add the preview file to the div
		
		$("#did").remove();
		preview.prependTo(dropbox);	
		$("#im").css('display','none');
		// Associating a preview container
		// with the file, using jQuery's $.data():
		
		$.data(file,preview);
	}
	function showMessage(msg){
		message.html(msg);
	}
	function upload(filename)
	{
		
		$("#upl").click(function(){
			

			var gallery     = $('#galleryid').val();
			
			var url         = 'img_file.php';
			var type        = $('#type').val();
		    
			// the script where you handle the form input.
				$.ajax({
				   type: 'POST',
				   url: url,
				   data:'m=move'+'&filename='+filename+'&gallery='+gallery,
				   name:'pic',
				   success: function(data)
				   {
						location.href='photo_detail.php';
						
						
				   }
				});
		
		});
	}

	$("#can").click(function(){
    var url      = 'img_file.php'; // the script where you handle the form input.
   
	   $.ajax({
				type: 'POST',
				url: url,
				data:"c=can",
				success: function(data)
				{
					$("#img").css('display','none');
					template="";
				}
			});
	});	
	var preview = $(template), 
		image = $('img', preview);
	var btnUpload=$('#imgbrowse');
	
	var status=$('#status');
	var i=0;
	//var preview = $(template), 
	//image = $('img', preview);
	//var reader = new FileReader();
	new AjaxUpload(btnUpload, {
		action: 'img_file.php',
		name:'pic',
		async: false,
		onSubmit: function(file, ext){
		if (!(ext && /^(jpg|jpeg|png|gif)$/.test(ext)))
		{
			alert('E’ possibile caricare file con queste estensioni: JPG,PNG,GIF');
			return false;
		}

		message.hide();
		$("#im").attr('src',"img/ajaxloader.gif");
		$("#im").show();

		status.text('Uploading image. Please be patient...');
		},
		onComplete: function(file, response)
		{
			if(response == "error")
			{
				alert('Impossibile caricare il file');
				
				$("#error").css('display','block');
			}
		    if(response == "large")
            {
				alert("file too large");

			}
			else 
			{
					var nsrc="../temp/"+file;
					$("#did").remove();
					//$("#im").css('display','inline');
					$("#im").removeAttr('src');
	                $("#im").attr('src',nsrc);	
	                					
					//message.hide();
					status.text('');
					$('#statuss').val(response);
					upload(file);
					
			}
						
		}	
	});

});