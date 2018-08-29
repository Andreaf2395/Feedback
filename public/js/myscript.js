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
                        getfaculty();
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
