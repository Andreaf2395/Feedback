<!DOCTYPE html>
<html>
	<head>
		<title>Lab Ranking</title>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>	
			<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"></script>
			<script src="{{asset('js/bootstrap.min.js')}}" ></script>
		

			<style>
				table {
  					table-layout: fixed;
  					width: 100%;
  					border-collapse: collapse;
  					border: 3px solid lightblue;
  					background: linear-gradient(to top, white, #4AB3DD);

				}
				th,td {
					border:2px solid black;
					text-align: center;
					letter-spacing: 1px;

				}
				.divider{
					margin: 0.5em 0 0.5em 0;
					border :0;
					height:1px;
					width:100%;
					display:block;
					background-color: blue;
					background-image:linear-gradient(to right,pink,blue,pink,blue,pink);
				}
				.container{
					background-color: rgba(255,255,255,0.5);
					box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.30), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				}
				body{
					  background-image: -webkit-linear-gradient(45deg, #49a09d, #5f2c82);
  					  background-image: linear-gradient(45deg, #49a09d, #5f2c82);
  					  height:100%;
  					  background-repeat: no-repeat;
    				  background-size: cover;
				}
				.img-thumbnail{
					height:80px;
					width:80px;
					box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.30), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
					margin-bottom: 10px;
				}

				.row
				{
					background:white;
					border-radius: 5px;
		
				}
				.delete_btn{
					height:30px;
					width:30px;
				}
				
				.delete_btn:hover { 

					-moz-box-shadow: 0 1px 10px rgba(255,0,0,0.8); 
					-webkit-box-shadow: 0 1px 10px rgba(255,0,0,0.19);     
					box-shadow: 0 1px 10px rgba(255,0,0,0.8)
					}

				.delete_btn img{
					height:30px;width:30px;cursor:pointer;
				}	
    		
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

		<h2>header</h2>

		
			
		<div id="clg_lab_dtls" class="container col-md-8 ">
		
			<form action="savefeedback" method="POST"  id="upload" enctype="multipart/form-data">
				{{csrf_field()}}

					<div class="form-group">
						<label for="college">College Name:</label>
					
						<select name="college"   class="form-control" >
							<option value="">select college</option>
							@foreach($colleges as $c)	
							<option value="{{ $c->id }}">{{$c->college_name}},{{$c->district}}</option>
							@endforeach
						</select>
						@if($errors->has('college'))
						<span class="text-danger">{{$errors->first('college')}}</span>
						@endif
					</div>	

					<br>

					<div class="form-group">	
						<label for="faculty_data">Faculty:</label>
							<span id="msg1"></span>
							<table  id="faculty_data" class="table-inverse"></table>
					</div>

					<input id="add_faculty" type="button" class="btn btn-primary" value="Add faculty"></input>

					<div id="faculty_contact"></div>
				
					<br>

					<div class="form-group">
						<label for="no_students">Total number of students trained in the lab:</label>
						<input type="text" name="no_students" id="no_students" class="form-control" value="{{old('no_students' )}}" >
						@if($errors->has('no_students'))
						<span class="text-danger">{{$errors->first('no_students')}}</span>
						@endif
					</div>

					<br>
					<div id="form-group">
						<label for="comment">In what way are you using the lab?</label><br>
						<textarea id="comment" name="comment" rows="5" cols="80" class="form-control" value="{{old('comment')}}"></textarea>
						@if($errors->has('comment'))
							<span class="text-danger">{{$errors->first('comment')}}</span>
						@endif
					</div>


					<div class="divider"></div>

					<br>

						<div class="form-group ">
							<label for="upload_element">Lab Photo:</label><br>
								<div id="upload_element" >
									 <span class="col-md-2 ">
									<!--	<input type="file" name="image"  id="image" multiple/><br>-->
											<input type="button" id="add_img_btn" class="btn btn-primary" value="+ Add Images">
											<div class="fileinputs">
												<input type="file" class="file"  id="labimage" name="labimage"/>
											</div>
											
										@if($errors->has('image'))
											<span class="text-danger">{{$errors->first('image')}}</span>
										@endif
										<span class="text-danger" id="image-errors"></span> 
									</span>
								</div>
								<div class="col-md-12 row " id="displayboard">
									<?php 
										for($i=0; $i<5; $i++){ ?>
											<div class="col-md-2 lab-pic " id={{$i}}>
		 											<img class="img-responsive img-thumbnail" src="{{asset('images/no_image.png')}}" id="preview_image_{{$i}}" />
		 											<input type="hidden" value="" id="file_name_{{$i}}">
		 											<div class="delete_btn" id={{$i}} ><img src="{{asset('images/delete.png')}}" /></div>
												</div>
									<?php	} ?>
						
							</div>
						</div>	


		
					<br>

					<button type="submit" class="btn btn-primary">Submit</button>
			</form>

		</div>
		
	
		<script type="text/javascript">
			$(document).ready(function() {
				var count= 0;
				var html='Name:<input name="faculty_name" type="text" />Designation:<input name="faculty_name" type="text" />Contact no:<input name="faculty_name" type="text" />email:<input name="faculty_name" type="text" /><br>';
			    var collegeID;

			    $('#add_faculty').click(function(e){
			    	$('#faculty_contact').append(html);
			    });
			    		
			   			
			   

			    //getting faculty of the selected college 
			    $('select[name="college"]').on('change', function() {

			            collegeID = $(this).val();
			            	$('#image-errors').empty();
			            if(collegeID) {
			                $.ajax({
					        url: "/faculty/"+collegeID,
			                type: "GET",
			                dataType: "json",
			                cache: false,
			                success:function(data) {
			                    console.log(data);
			                    $('#faculty_data').empty();
			                    $('#msg1').empty();
			                    if(data.faculty.length== 0)
					                {

					                    $('#msg1').append('<p >NO FACULTY MEMBERS</p>');
			                        }
					                else{

						                $('#faculty_data').append('<tr><th>Name</th><th>Designation</th><th>Conatct no</th><th>Email</th></tr>');
						                $.each(data.faculty, function (i, item) {
						                    var username = data.faculty[i].name;
				  							var designation =(data.faculty[i].designation == null)?"-":data.faculty[i].designation;
				  							var contact =(data.faculty[i].contact_num == null)?"-":data.faculty[i].contact_num;
				  							var email=(data.faculty[i].emailid ==null )? "-":data.faculty[i].emailid;
				           					$('#faculty_data').append('<tr><td>'+username+'</td><td>'+designation+'</td><td>'+contact+'</td><td>'+email+'</td></tr>');
				        					});
					                    }
								}
			                });
			            }
			    });




			      //display all images
			    function display(data){
			    	 if(data.empty)
			    	 {
			    	 	for(i=0;i<5;i++)
			    	 	{
			    	 		$('#preview_image_'+i).attr('src', '/images/no_image.png');
			    	 		$('#file_name_'+i).val('');
			    	 	}
			    	 }
			    	 else{


				    	for(i=0;i<data.files.length;i++)
				    	{
				    		$('#preview_image_'+i).attr('src', "/"+data.files[i].dirname+"/"+data.files[i].basename);
				    		$('#file_name_'+i).val(data.files[i].basename);
				    		console.log(data.files[i].dirname+"/"+data.files[i].basename);
				    	}
			    	
			    		for(i=data.files.length;i<5;i++){
			    			$('#preview_image_'+i).attr('src', '/images/no_image.png');
			    		}
			    	} 
			    }

			    $('#add_img_btn').click(function () {
			      $('#labimage').click();      
			   
			    });

 				 //image upload
			    $('#labimage').change(function () {
			        if ($(this).val() != '') {
			            upload(this);
			      	}
			    });

			    			
			    function upload(img) {
					if(collegeID){
				        $('#image-errors').empty();
				        var form_data = new FormData();
				        form_data.append('image', img.files[0]);
				        form_data.append('_token', '{{csrf_token()}}');
				        form_data.append('college_id',collegeID);

				        //$('#loading').css('display', 'block');
				       	 $.ajax({
				           	url: "/imageupload",
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
					                   count++;
					                   	display(data);
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



			    //delete image  
			    function remove_image(image_name) {
			    				
			        if (image_name != '')
			        if (confirm('Are you sure want to remove the picture?')) {
			            //$('#loading').css('display', 'block');
			            var file_name=image_name;
				        var form_data = new FormData();
				        form_data.append('_method', 'DELETE');
				        form_data.append('_token', '{{csrf_token()}}');
				        form_data.append('college_id',collegeID);
				        form_data.append('filename',file_name);
				        $.ajax({
				            url: "/removeimage",
				            data: form_data,
				            type: 'POST',
				            contentType: false,
				            processData: false,
				            success: function (data) {
				            	count--;
				            	display(data);
				                //$('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
				                //$('#image').val('');
				                //$('#loading').css('display', 'none');
				            },
				             error: function (xhr, status, error) {
				                alert(xhr.responseText);
				            }
			            });
			        }
			  	}





				$(".delete_btn").click(function() {
				   
				    var ele ='#file_name_'+this.id;
				    var file=$(ele).val();

				 	remove_image(file);
				});


			   
			}); 

		</script>
	</body>
</html>
