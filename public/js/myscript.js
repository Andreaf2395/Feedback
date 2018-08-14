$(document).ready(function() {

	var html='Name:<input name="faculty_name" type="text" />Designation:<input name="faculty_name" type="text" />Contact no:<input name="faculty_name" type="text" />email:<input name="faculty_name" type="text" /><br>';
    var collegeID;

    $('#add_faculty').click(function(e){
    	$('#faculty_contact').append(html);
    });
    		
   			
   

    //getting faculty of the selected college 
    $('select[name="college"]').on('change', function() {

            collegeID = $(this).val();
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

		                    $('#msg1').append('<p>NO FACULTY MEMBERS</p>');
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




    //image upload
    $('#image').change(function () {
        if ($(this).val() != '') {
            upload(this);
      	}
    });
    			
    function upload(img) {
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
                	alert(data.errors['image']);
                }
                else {
                	$('#file_name').val(data.filename);
                    $('#preview_image').attr('src', data.path);
                	}
               	//$('#loading').css('display', 'none');
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
                $('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
            }
        });
    }



    //delete image  
    $('#delete_btn').click(function () {
    				
        if ($('#file_name').val() != '')
        if (confirm('Are you sure want to remove profile picture?')) {
            //$('#loading').css('display', 'block');
            var file_name=$('#file_name').val();
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
	                $('#preview_image').attr('src', '{{asset('images/no_image.png')}}');
	                $('#image').val('');
	                //$('#loading').css('display', 'none');
	            },
	             error: function (xhr, status, error) {
	                alert(xhr.responseText);
	            }
            });
        }
  	});

   
}); 
