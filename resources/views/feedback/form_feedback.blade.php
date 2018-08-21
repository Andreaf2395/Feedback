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
					overflow:hidden;
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
					padding:10px;
    			
				}
				body{
					  background-image: -webkit-linear-gradient(45deg, #49a09d, #5f2c82);
  					  background-image: linear-gradient(45deg, #49a09d, #5f2c82);
  					  height:100%;
  					  background-repeat: no-repeat;
    				  background-size: cover;
    				  background-attachment: fixed;
    				 }
				html{
					 height:100% ; 
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
					margin:auto;
					padding: 10px;
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
				.info {
				    background-color: #41a7a599;
					border-left: 6px solid #5f2e82;
					border-radius: 5px
				}
				label::after{
						content:"*";
						color:red;
				}
			</style>
	</head>





	<body>

		<h2>header</h2>

		
			
		<div id="clg_lab_dtls" class="container col-md-8 ">
		
			<form action="savefeedback" method="POST"  enctype="multipart/form-data">
				{{csrf_field()}}

					<div class="form-group">
						<label for="college">College Name:</label><br>
						@if($errors->has('college'))
						<span class="text-danger">{{$errors->first('college')}}</span>
						@endif
						<select name="college"   class="form-control"  placeholder="select colleges">
							<option></option>
							@foreach($colleges as $c)	
								@if(old('college') == $c->id)
									<option value="{{ $c->id }}" selected>{{$c->college_name}},{{$c->district}}</option>
								@else
									<option value="{{ $c->id }}">{{$c->college_name}},{{$c->district}}</option>
								@endif
							@endforeach
						</select>
						
					</div>	

					<br>

					<div class="form-group">	
						<label for="faculty_data">Faculty:</label>
							<span id="msg1"></span>
							<table  id="faculty_data" class="table-inverse"></table>
					</div>

					<input id="add_faculty" type="button" class="btn btn-primary" value="Add faculty" data-target="#facultyModal"></input>
					<span class="text-danger" id="faculty_err"></span> 
					<!-- The Modal -->
						<div class="modal" id="facultyModal">
						  <div class="modal-dialog">
						    <div class="modal-content">

						      <!-- Modal Header -->
						      <div class="modal-header">
						        <h4 class="modal-title">Faculty Details</h4>
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						      </div>

						      <!-- Modal body -->
						      <div class="modal-body">
						        	<div class="form-group col-md-7">
              							<label for="faculty_name">Name:</label>
              							<input type="text" class="form-control" name="faculty_name" id="faculty_name">
              							<span id="faculty_name_err" class="text-danger"></span>
            						</div>
            						<div class="form-group col-md-7">
              							<label for="designation">Designation:</label>
              							<input type="text" class="form-control" name="designation" id="designation">
              							<span id="designation_err" class="text-danger"></span>
            						</div>
            						<div class="form-group col-md-7">
              							<label for="contact_co">Contact no:</label>
              							<input type="text" class="form-control" name="contact_no" id="contact_no">
              							<span id="contact_no_err" class="text-danger"></span>
            						</div>
            						<div class="form-group col-md-7">
              							<label for="email">Email:</label>
              							<input type="text" class="form-control" name="email" id="email">
              							<span id="email_err" class="text-danger"></span>
            						</div>
						      </div>

						      <!-- Modal footer -->
						      <div class="modal-footer">
						        <input type="button" class="btn btn-success" id="faculty_save" value="Save">
						      </div>

						    </div>
						  </div>
						</div>

					<div id="faculty_contact"></div>
				
					<br>

					<div class="form-group">
						<label for="no_students">Total number of students trained in the lab:</label><br>
						@if($errors->has('no_students'))
						<span class="text-danger">{{$errors->first('no_students')}}</span>
						@endif
						<input type="text" name="no_students" id="no_students" class="form-control col-md-3" value="{{old('no_students' )}}" >
					</div>

					<br>
					<div id="form-group">
						<label for="comment">In what way are you using the lab?</label><br>
						@if($errors->has('comment'))
							<span class="text-danger">{{$errors->first('comment')}}</span>
						@endif
						<textarea id="comment" name="comment" rows="5" cols="80" class="form-control"> {{old('comment')}}</textarea>
					</div>


					<div class="divider"></div>

					<br>

						<div class="form-group ">
							<label for="upload_element">Lab Photo:</label><br>
								<div class="info">
												<p>
													<ul>
														<li>The image must be of the following formats:jpg,jpeg,png,svg</li>
														<li>The maximum file size allowed is 2 MB</li>
														<li>The resolution of image should be at least 600x300 pixel</li>
														<li>The image name should be appropriate. Eg: Front_View_lab,Equipments etc</li>
														
													</ul>
												</p>
											</div>
								<div id="upload_element" >
									 <span class="col-md-2 ">
								
											<input type="button" id="add_img_btn" class="btn btn-primary" value="+ Add Images">
											<div class="fileinputs">
												<input type="file" class="file"  id="labimage" name="labimage"/>
											</div>
											
											
										@if($errors->has('labimage'))
											<span class="text-danger" id="image-err">{{$errors->first('labimage')}}</span>
										@endif
										<span class="text-danger" id="image-errors"></span> 
									</span>
								</div>
								<div class="col-md-12 row form-group " id="displayboard">
									
							</div>
						</div>	


		
					<br>
			
					<button type="submit" class="btn btn-primary">Submit</button>
			</form>

		</div>
		
	
		<script type="text/javascript">
			$(document).ready(function() {
			
			    var collegeID;
			    var index=1;


			    $('#add_faculty').click(function(e){
			    	$('#faculty_err').empty();
					if(collegeID){
						$('#facultyModal').modal('show');
					}
					else
					{
						$('#faculty_err').append('Please select a college first');
					}
			    	
			    	/*
			    	var html='<div><span>Name:<input name="faculty_name[]" type="text" id="faculty_name" /></span><span>Designation:<input name="designation[]" type="text" id="designation"/></span><span>Contact no:<input name="contact_no[]" id="contact_no" type="text" /></span><span>email:<input name="email[]" id="email" type="text" /><br></span></div>';
			    	$('#faculty_contact').append(html);*/
			    });

			    //getting faculty of the selected college 
			    $('select[name="college"]').on('change', function() {
			       		getfaculty()
			    });

			    function getfaculty(){
			    	collegeID= $('select[name="college"]').val();
			    	$('#image-errors').empty();
			        $('#displayboard').empty();
			        if(collegeID) {
				        $.ajax({
						    url: "/faculty/"+collegeID,
				            type: "GET",
				            dataType: "json",
				            cache: false,
				            success:function(data) {
				            	// console.log(data);
					            $('#faculty_data').empty();
					            $('#msg1').empty();
					            if(data.faculty.length== 0)
							    {

							  		$('#msg1').append('<p >NO FACULTY MEMBERS</p>');
					            }
							    else{

								    $('#faculty_data').append('<tr><th>Name</th><th>Designation</th><th>Conatct no</th><th>Email</th><th>Select Lab Incharge</th></tr>');
								    $.each(data.faculty, function (i, item) {
								        var username = data.faculty[i].name;
						  				var designation =(data.faculty[i].designation == null)?"-":data.faculty[i].designation;
						  				var contact =(data.faculty[i].contact_num == null)?"-":data.faculty[i].contact_num;
						  				var email=(data.faculty[i].emailid ==null )? "-":data.faculty[i].emailid;
						           		$('#faculty_data').append('<tr><td>'+username+'</td><td>'+designation+'</td><td>'+contact+'</td><td>'+email+'</td><td><input type="radio" name="lab_incharge" value="'+data.faculty[i].id+'"></td></tr>');
						        		});
							        }
							}
				        });
			        }
			    }
			 

			    if('{{old('college')}}')
				{
					getfaculty();

				}
			   

			    //display image
			    function display(data){


			    	if(!data.empty)
			    	{
			    		//console.log('/images/'+collegeID+'/'+data.image_name);
				    	
			    		$('#displayboard').append('<div class="col-md-2 " id="lab-pic'+index+'"><img class="img-responsive img-thumbnail" src="'+'/images/'+collegeID+'/'+data.image_name+'" id="preview_image_'+index+'" /><input type="hidden" value="'+data.image_name+'" id="file_name_'+index+'"><div class="delete_btn" id='+index+' ><img src="{{asset('images/delete.png')}}" /></div></div>');
			    			index++;
			    		
			    	}
			    	

			    }



			    //click on add button to trigger click on input type=file
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
			    	 $('#image-err').empty();
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
					            //console.log(data);
					            if (data.fail)
					           {
					               $('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
					               $('#image-errors').append(data.errors['image']);
					            }
					            else {
					        			
					                   	display(data);
					            }
					               	//$('#loading').css('display', 'none');
					        },
				            error: function (xhr, status, error) {
				                //alert(xhr.responseText);
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
			    function remove_image(image_name,id) {
			    				
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
				            	if(data.empty)
				            	{
					        		$('#labimage').val('');    // this condition is for checking if there are any files uploaded
					        		console.log('in remove image');
				            	}
				     			$('#lab-pic'+id).remove();
				                //$('#loading').css('display', 'none');
				            },
				             error: function (xhr, status, error) {
				                alert(xhr.responseText);
				            }
			            });
			        }
			  	}



			  	


				$('#displayboard').on('click','.delete_btn',function(){
				
					var id=$(this).attr("id");
		
					var ele ='#file_name_'+id;
				    var file=$(ele).val();
				 	remove_image(file,id);
				});





				$('#faculty_save').on('click',function(){
					$('#faculty_err').empty();
					 $('#faculty_name_err').empty();
					 $('#designation_err').empty();
					 $('#contact_no_err').empty();
					 $('#email_err').empty();
					var faculty_name = $('#faculty_name').val();
					var designation =$('#designation').val();
					var contact_no =$('#contact_no').val();
					var email=$('#email').val(); 
					var _token = $("input[name='_token']").val();

					    var form_data = new FormData();
				        form_data.append('_token', '{{csrf_token()}}');
				        form_data.append('faculty_name',faculty_name);
				        form_data.append('designation',designation);
				        form_data.append('contact_no',contact_no);
				        form_data.append('email',email);
				        form_data.append('clg_id',collegeID)
				
					   $.ajax({
				            url: "/faculty_save",
				            data:form_data,
				            type: 'POST',
				            contentType: false,
				            processData: false,
				            success: function (data) {
				            	if (data.fail)
					           {
					        		
					        		  $('#faculty_name_err').append(data.errors['faculty_name']);
					        		  $('#designation_err').append(data.errors['designation']);
					        		  $('#contact_no_err').append(data.errors['contact_no']);
					        		  $('#email_err').append(data.errors['email']);

					            }
					            else {
					        		  $('#facultyModal').modal('hide');
					        		  $('#facultydata').empty();
					        		  getfaculty();
					                 console.log('success');
					            }
				           		

				            },
				             error: function (xhr, status, error) {
				                alert(xhr.responseText);
				            }
			            });
				});


			}); 




		</script>
	</body>
</html>
