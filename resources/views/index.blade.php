<!DOCTYPE html>
<html>
<head>
    <title>User Add task for crosspoles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style type="text/css">
        #preview-image{
            width: 100px;
        }
    </style>
</head>
       
<body>
<div class="container">
         
    <div class="panel panel-primary">
    
          <div class="panel-heading">
            <h2>Add User Test for Crosspoles</h2>
          </div>
        <div class="panel-body">
        <div class="btn-danger">
            
        </div>
        <form action="{{ route('user.save') }}" method="POST" id="add-user-form" enctype="multipart/form-data">
            @csrf
            <div class="row px-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"  required>
                </div>
                <div class="col-md-3">
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" placeholder="Enter the Email" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" onkeypress="return isNumberKey(event)" maxlength="10" required>
                </div>
                <div class="col-md-3">
                    <select id="role_id" class="form-control" name="role_id">
                        <option value="">Select the role</option>
                        @foreach($role as $key=>$value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>  

            <div class="row mt-2 ">
                <div class="col-md-2">
                  <input  type="file" name="image" id="inputImage" class="form-control">
                </div>
                <div class="col-md-1">
                  <img src="" alt="image" name="image" id="preview-image">
                </div>
                <div class="col-md-2">
                    <label> Description</label>
                </div>
                <div class="col-md-3">
                    <textarea class="form-control" rows="1"  id="description"  name="description" required></textarea>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="submit">Add User</button>
                </div>
                
            </div>
          </form>
        </div>

    </div>
</div>
<hr>
<div class="container">
    <h2>All Users</h2>
    <div id="user-data">
        <table class="table">
            <thead>
              <tr>
                <th>Sno</th>
                <th>Profile</th>
                <th>Role</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user as $key=>$value)
              <tr>
                <td>{{$key+1}}</td>
                <td><img src="{{asset('images/'.$value->profile)}}" style="width: 100px;height: 100px;"></td>
                <td>{{$value['get_role']->name}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->email}}</td>
                <td>{{$value->phone}}</td>
              </tr>
              @endforeach
              
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('#inputImage').change(function(){    
        let reader = new FileReader();
   
        reader.onload = (e) => { 
            $('#preview-image').attr('src', e.target.result); 
        }   
        reader.readAsDataURL(this.files[0]); 
     
    });
  
    $('#add-user-form').submit(function(e) {
           e.preventDefault();
           let formData = new FormData(this);
           $('#image-input-error').text('');
  
           $.ajax({
              type:'POST',
              url: "{{ route('user.save') }}",
               data: formData,
               contentType: false,
               processData: false,
               success: (response) => {
                if (response.status == 2) 
                    $('.btn-danger').html(response.message);
                else{
                  getUser();
                  $('#add-user-form')[0].reset();
                  $('#preview-image').reset();
                }
               },
               error: function(response){
                    $('.btn-danger').html(response.message);
               }
           });
    });
    function getUser() {
       $.ajax({
              type:'get',
              url: "{{ route('get.user') }}",
               contentType: false,
               processData: false,
               success: (response) => {
                if (response) {
                  $('#user-data').html(response);
                }
               },
               error: function(response){
                    $('#image-input-error').text(response.responseJSON.message);
               }
           });   
    }  
</script>
</body>
  

      
</html>