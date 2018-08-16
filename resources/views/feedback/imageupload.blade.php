<!DOCTYPE html>
<html>
<head>
	<title>Image Upload</title>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>	
			<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"></script>
			<script src="{{asset('js/bootstrap.min.js')}}" ></script>
	<style>
		
	
		div.fileinputs {
			position: relative;
			text-align: right;
			-moz-opacity:0;
			filter:alpha(opacity: 0);
			opacity: 0;
			z-index: -3;

		}
	</style>
</head>
<body>


<div class="fileinputs">
	<input type="file" class="file"  id="labimage" name="labimage"/>
</div>
<input type="button" id="add_img_btn" class="btn btn-primary" value="+ Add Images">

<script type="text/javascript">

 $('#add_img_btn').click(function () {
			      $('#labimage').click();      
			   
			    });

  //image upload
			    $('#labimage').change(function () {
			        if ($(this).val() != '') {
			            upload(this);
			      	}
			    });
			    	

			var count=0; var collegeID=903;  ////////////////// do not take this value


			    function upload(img) {
			        if(count>5){
			        	$('#image-errors').append('You can upload only 5 pictures');
			        }
			        else{
				        if(collegeID){
				        	$('#image-errors').empty();
				        	var form_data = new FormData();
				        	form_data.append('image', img.files[0]);
				        	form_data.append('_token', '{{csrf_token()}}');
				        	form_data.append('college_id',collegeID);

				        	//$('#loading').css('display', 'block');
				       		 $.ajax({
				            	url: "/newimageupload",                           /////changes done here!!
					            data: form_data,
					            type: 'POST',
					            contentType: false,
					            processData: false,
					            success: function (data) {
					            	console.log(data);
					            	if (data.fail)
					                {
					            	   $('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
					            	   $('#image-errors').append(data.errors['image']);
					                }
					                else {
					                	//$('#file_name').val(data.filename);
					                   // $('#preview_image').attr('src', data.path);
					                   //count++;
					                   	//display(data);
					                   	console.log('hsdfh')
					                	}
					               	//$('#loading').css('display', 'none');
					            },
				            	error: function (xhr, status, error) {
				                	alert(xhr.responseText);
				                	$('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
				            	}
				        	});
				        }
				        else
				        { 
				           $('#image-errors').append('Please select a college first');
				        	$('#image').val('');
				        }
			        }
			    }






</script>



</body>
</html>