<!DOCTYPE 
<html>
<head>
	<title>Project Details</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>	
			<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"></script>
			<script src="{{asset('js/bootstrap.min.js')}}" ></script>
			<link rel="stylesheet" type="text/css" href="{{asset('css/mystyle.css')}}" />
	
</head>
<style>
.container{

	border:2px solid white;
	background-color: rgba(255,255,255,0.1);

}
</style>
<body>
	
	<div class="container">
		<div id="success-msg"></div>
		<input type="button" value="Add Project" id="add-btn" class="btn btn-success"/>


		<form  action="/saveprojectfeedback" method="POST"  enctype="multipart/form-data" id="projform">
		

			{{csrf_field()}}
			<div id="projects_container" >
				<div id="project_dtls"  style="display:none" class="project_dtls">
					<div class="form-group">
						<label for="project_name">Name of the project:</label><br>
					
						<span class="text-danger" id="project_name_err"></span> 
			
						<input type="text" name="project_name" class="form-control" value="{{old('project_name[]')}}" >
					</div>

					<div class="form-group">
						<label for="no_participants"> No of participants:</label><br>
					
						<span class="text-danger"  id="no_participants_err"></span> 
				
						<input type="text" name="no_participants" class="form-control col-md-3" value="{{old('no_participants[0]')}}" >
					</div>

					<div class="form-group">
						<label for="category">Category:</label><br>
		
						<span class="text-danger" id="category_err"></span> 
	
						<select name="category"   class="form-control" >
									<option val=""></option>
									<option val="B.E">B.E.</option>
									<option val="Mini">Mini</option>
									<option val="course">Course</option>
									<option val="other">Other</option>
								</select>

					</div>

					<div class="form-group"> 
						<label  for="description">Desciption:</label><br>
	
						<span class="text-danger" id="description_err"></span> 
			
						<textarea name="description" class="form-control"></textarea>
					</div>


					<div class="form-group">
						<label>Project Images:</label>
						<div class="info">
													
							<ul>
								<li>The image must be of the following formats:jpg,jpeg,png,svg</li>
								<li>The maximum file size allowed is 2 MB</li>
								<li>The resolution of image should be at least 600x300 pixel</li>
								<li>The image name should be appropriate. Eg: Front_View_lab,Equipments etc</li>
							</ul>
						</div>
						<div id="upload_element" >
							<span class="col-md-2 ">
									<input type="button" id="add-btn" class="btn btn-primary add-btn" value="+ Add Images">
									<div class="fileinputs">
										<input type="file" class="file"  id="projimage" name="projimage"/>
									</div>
							</span>
							<span class="text-danger" id="image-err"></span> 
						</div>
						<div class="col-md-12 row form-group " id="displayboard"></div>
						<br>
						<div class="divider"></div>
						<br>
					
					</div>
				</div>
				<div id="project_dtls1"  class="project_dtls">
					<div class="form-group">
						<label for="project_name">Name of the project:</label><br>
				
						<span class="text-danger proj_error" id="project_1_project_name"></span> 
					
						<input type="text" id="projectname_1"name="project[1][project_name]" class="form-control" value="{{old('project.1.project_name')}}">
					</div>

					<div class="form-group">
						<label for="no_participants"> No of participants:</label><br>
				
						<span class="text-danger proj_error" id="project_1_no_participants"></span> 
						
						<input type="text" name="project[1][no_participants]" class="form-control col-md-3" value="{{old('project.1.no_participants')}}" >
					</div>

					<div class="form-group">
						<label for="category">Category:</label><br>
			
						<span class="text-danger proj_error" id="project_1_category"></span> 
					
						<select name="project[1][category]"   class="form-control"  >
									<option value=""></option>
									<option value="B.E" {{ old('project.1.category') == 'B.E' ? 'selected' : ''}}>B.E.</option>
									<option value="Mini"  {{ old('project.1.category') == 'Mini' ? 'selected' : ''}}>Mini</option>
									<option value="Course"  {{ old('project.1.category') == 'Course' ? 'selected' : ''}}>Course</option>
									<option value="Other"  {{ old('project.1.category') == 'Other' ? 'selected' : ''}}>Other</option>
								</select>

					</div>

					<div class="form-group"> 
						<label  for="description">Description:</label><br>
						<span class="text-danger proj_error" id="project_1_description"></span> 
						<textarea name="project[1][description]" class="form-control">{{old('project.1.description')}}</textarea>
					</div>


					<div class="form-group">
						<label>Project Images:</label>
						<div class="info">
													
							<ul>
								<li>The image must be of the following formats:jpg,jpeg,png,svg</li>
								<li>The maximum file size allowed is 2 MB</li>
								<li>The resolution of image should be at least 600x300 pixel</li>
								<li>The image name should be appropriate. Eg: Front_View_lab,Equipments etc</li>
							</ul>
						</div>
						<div id="upload_element" >
							<span class="col-md-2 ">
									<input type="button" id="add-btn_1" class="btn btn-primary add-btn" value="+ Add Images">
									<div class="fileinputs">
										<input type="file" class="file"  id="projimage_1" name="project[1][projimage]"/>
									</div>
							</span>
							<span class="text-danger" id="project_1_projimage"></span> 
						</div>
						<div class="col-md-12 row form-group " id="displayboard_1"></div>
						<br>
						<div class="divider"></div>
						<br>
					
					</div>
				</div>
			</div>


			<input type="button" value ="Submit" class="btn btn-success" id="submit-btn"/>

		</form>

	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			var index=1;
			$('#add-btn').click(function(){
				console.log('in addon');
				generateduplicate();
				
			});



			$('.container').on('click','.cancel',function(){
                	console.log('delete');
                    $(this).parent('div').remove();
                    
                });


			function generateduplicate(){
				var element=document.getElementById('project_dtls')
				var duplicate=element.cloneNode(true);

				element.id= 'project_dtls'+ ++index;
			
				element.parentNode.appendChild(duplicate, element);

			    $("#project_dtls"+index).attr('style',"display");
			    $("#project_dtls"+index).find('[name = project_name]').attr('name',"project["+index+"][project_name]").val("").attr('id',"projectname_"+index);
			    $("#project_dtls"+index).find('[name = no_participants]').attr('name',"project["+index+"][no_participants]").val("");
			    $("#project_dtls"+index).find('[name = category]').attr('name',"project["+index+"][category]").val("");
			    $("#project_dtls"+index).find('[name = description]').attr('name',"project["+index+"][description]");
			    $("#project_dtls"+index).find('[name = projimage]').attr('name',"project["+index+"][projimage]").val("").attr('id',"projimage_"+index);;

			    $("#project_dtls"+index).find('[id = add-btn]').attr('id',"add-btn_"+index);
			    $("#project_dtls"+index).find('[id = displayboard]').attr('id',"displayboard_"+index);
			    
			    $("#project_dtls"+index).find('[id = project_name_err]').attr('id',"project_"+index+"_project_name").attr('class',"proj_error text-danger");
			    $("#project_dtls"+index).find('[id = no_participants_err]').attr('id',"project_"+index+"_no_participants").attr('class',"proj_error text-danger");
			    $("#project_dtls"+index).find('[id = category_err]').attr('id',"project_"+index+"_category").attr('class',"proj_error text-danger");
				$("#project_dtls"+index).find('[id = description_err]').attr('id',"project_"+index+"_description").attr('class',"proj_error text-danger");
				$("#project_dtls"+index).find('[id = image-err]').attr('id',"project_"+index+"_projimage").attr('class',"proj_error text-danger");

				$("#project_dtls"+index).prepend('<div class="close_btn" id="close"><img src="{{asset('images/close.png')}}" /></div><br>');

			}

			
			$("#submit-btn").on('click',function(e) {
		    		var url = $('#projform').attr('action');
		    		var FormData = $("#projform").serialize();
				    $.ajax({
				           type: "POST",
				           url:url,
				           data: FormData,
				           cache:false,
				           processData: false,
		                   headers: {
		    					'X-CSRF-TOKEN': $('input[name="_token"]').attr('value') },
				           success: function(data)
				           {
				           		$('.proj_error').empty();
					           	if(data.fail)
					           	{
					           		console.log('fail');
					           		Object.keys(data.errors).forEach(function(key) {
									  var arr=key.split(".");
									  var ele_name='#project_'+arr[1]+'_'+arr[2];
									  console.log(ele_name);
									  $(ele_name).append(data.errors[key]);
									  
									});
					           		
					           	}
					           	else{
					           		//window.location.href = "{{ url("/submit_complete") }}";
					           		$('#success-msg').append('<div><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span class="glyphicon glyphicon-ok"></span> <p><center>Thank you for submitting your feedback.</center></p></div></div>');

					           	}

				      
				           },
				           error: function (xhr, status, error) {
				           	alert(xhr.responseText);
				           }
				           
				         });

				    e.preventDefault(); 
				});  


			$('#projects_container').on('click','#close',function(){
				console.log('in delete');
				$(this).parent('div').remove();
			});


				var i=0;
                //display image
                function display(data,project_id){
                	
                    if(!data.empty)
                    {
                        console.log('/'+data.image_path);
                        $('#displayboard_'+project_id).append('<div class="col-md-2 " id="proj-pic'+i+'"><img class="img-responsive img-thumbnail" src="/'+data.image_path+'" id="preview_image_'+i+'" /><input type="hidden" value="'+data.image_name+'" id="file_name_'+i+'"><div class="delete_btn" id="'+i+'" ><img src="{{asset('images/delete.png')}}" /></div></div>');
                            i++;
                    }
                    
                }



                //click on add button to trigger click on input type=file
                $('#projects_container').on('click','.add-btn',function () {
                	var val=$(this).attr("id");
                	var project_id=val.split("_");
                	console.log(project_id[1]);
                  $('#projimage_'+project_id[1]).click();   
   
                });


                 //image upload
				$('#projects_container').on('change','.file',function () {
					var val=$(this).attr("id");
					var project_id=val.split("_");
					if ($(this).val() != '') {
                        upload(this,project_id[1]);
                    }
				});

             	


                            
                function upload(img,project_id)
                {
                		var project_name=$('#projectname_'+project_id).val();
                		$('#project_'+project_id+'_projimage').empty();
                        var form_data = new FormData();
                        form_data.append('image', img.files[0]);
                        form_data.append('_token', '{{csrf_token()}}');
                        form_data.append('project_name',project_name);
                         $.ajax({
                            url: "/projectImageUpload",
                            data: form_data,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            success: function (data) {
                               console.log(data);
                                if (data.fail)
                                {
                              		$('#project_'+project_id+'_projimage').append(data.errors['project_name']);
                                    $('#project_'+project_id+'_projimage').append(data.errors['image']);
                                }
                                else {
                                       
                                        display(data,project_id);
                                }
                              
                            },
                            error: function (xhr, status, error) {
                                //alert(xhr.responseText);
                                $('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
                            }
                        });
                  
                    
                }



                //delete image  
                function remove_image(image_name,id,project_id) {
                    var project_name=$('#projectname_'+project_id).val();
                    if (image_name != '')
                    if (confirm('Are you sure want to remove the picture?')) {
                        //$('#loading').css('display', 'block');
                        var file_name=image_name;
                        var form_data = new FormData();
                        form_data.append('_method', 'DELETE');
                        form_data.append('_token', '{{csrf_token()}}');
                        form_data.append('project_name',project_name);
                        form_data.append('filename',file_name);

                        $.ajax({
                            url: "/removeProjectImage",
                            data: form_data,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if(data.empty)
                                {
                                    $('#projimage_'+project_id).val('');    // this condition is for checking if there are any files uploaded
                                    console.log('in remove image');
                                    
                                }
                               $('#proj-pic'+id).remove();
                                //$('#loading').css('display', 'none');
                            },
                             error: function (xhr, status, error) {
                                alert(xhr.responseText);

                            }
                        });
                    }
                }



                


                $('#projects_container').on('click','.delete_btn',function(){
                	var file_id=$(this).attr("id");
              		var temp= $(this).parent().parent().attr('id');
              		var project_id=(temp.split('_'))[1];
                    var ele ='#file_name_'+file_id;
                    var file=$(ele).val();
                    console.log('removing');
                    remove_image(file,file_id,project_id);
                });






          });
	</script>
</body>
</html>