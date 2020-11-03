<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{csrf_token()}}">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="{{asset('css')}}/bootstrap.min.css">
<script src="{{asset('js')}}/jquery.js"></script>
 <title>Laravel Crud Ajax</title>
</head>
<body>
 



<section class="py-5">
 <div class="container">
  <h2 class="text-danger">
   <marquee behavior="" direction="">Laravel 8 Ajax Crud Application By Shishir Bhuiyan</marquee>
  </h2>
  <div class="row ">
   <div class="col-md-8 m-auto">
      <div class="card " style="">
       <div class="card-header text-center">
        <span class="h2">All Teacher List</span>
       </div>

       <div class="card-body">
         <div id="tablemessage"></div>
         <table class="table table-bordered table-striped" style="text-transform: capitalize;">
          <thead class="bg-dark text-light">
           <tr class="text-center">
            <th>
              <input type='checkbox' id='chkall' /> 
              <a href="" class="btn btn-dark btn-sm" id="deleteAll">Delete All</a>
            </th>
            <th>#</th>
            <th>Name</th>
            <th>Title</th>
            <th>Institutation</th>
            <th colspan="2">Action</th>
           </tr>
          </thead>

          <tbody>
            {{---here Data Is Added Dynamacally---}}
          </tbody>
         </table>
       </div>
      </div>
   </div>
   <div class="col-md-4 m-auto">

     <div class="card">
      <div class="card-header text-center bg-dark text-light h3">
       <span>Inter Your Action</span>
      </div>

      <div class="card-body">
       <div id="formmessage">
       </div>
       <form action="" id="forms">
           <div class="fom-group">
            <div class="px-1 d-flex justify-content-between">
              <label class="h6" for="name">Name</label>
              <strong class="text-danger" id="nameError"></strong>
            </div>
            <input id="name" type="text" class="form-control mb-3"/>
           </div>

           <div class="fom-group">
            <div class="px-1 d-flex justify-content-between">
              <label class="h6" for="title">Title</label>
              <strong class="text-danger" id="titleError"></strong>
            </div>
            <input id="title" type="text" class="form-control mb-3"/>
           </div>

           <div class="fom-group">
            <div class="px-1 d-flex justify-content-between">
              <label class="h6" for="institute">Institute</label>
              <strong class="text-danger" id="instituteError"></strong>
            </div>
            <input id="institute" type="text" class="form-control mb-3"/>
           </div>

           <input type="hidden" id="id">

            <div class="py-2">
             <button type="submit" class="btn btn-info form-control" id="addbtn" >Add</button>

             <button type="submit" class="btn btn-primary form-control" id="updatebtn">Update</button>
            </div>
        </form>
      </div>
     </div>
   </div>
  </div>
 </div>
</section>











<!-----Script Part Start----------->
<script>

$('#addbtn').show();
$('#updatebtn').hide();

$.ajaxSetup({
  headers:{
   'x-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
 });













//----- Fetch All teacher Information -----------
function allData()
{
 $.ajax({
   type: "GET",
   dataType: 'json',
   url: "/teacher/all",
   success: function(response)
   {
    var data = ""
    $.each(response, function(key,value){
      data = data + "<tr class='text-center' id='sid"+value.id+" '>"

      data = data + "<td class='text-left'>"
      data = data + "<input type='checkbox' name='ids' class='checkBoxClass' value="+value.id+" />"
      data = data + "</td>"
      
      data = data + "<td>"+value.id+"</td>"
      data = data + "<td>"+value.name+"</td>"
      data = data + "<td>"+value.title+"</td>"
      data = data + "<td>"+value.institute+"</td>"
      data = data + "<td>"
      data =data + "<button  class='btn btn-warning' onclick='editData("+value.id+")'>Edit</button>"
      data = data + "</td>"
      data = data + "<td>"
      data = data + "<button  class='btn btn-danger'onclick='deleteData("+value.id+")'>Delete</button>"
      data = data + "</td>"
      data = data + "</tr>"
    });
    $('tbody').html(data);
   }
 });
}
allData();
//----- Fetch All teacher Information End-----------


















//----- Clear Data ------------
function clearData()
{
  $('#name').val('');
  $('#title').val('');
  $('#institute').val('');
  $('#nameError').text('');
  $('#titleError').text('');
  $('#instituteError').text('');
}
//----- Clear Data ------------


















//------Insert Teacher Data------------------------
$('#addbtn').click(function(event){
  event.preventDefault();

  var name  = $('#name').val();
  var title  = $('#title').val();
  var institute  = $('#institute').val();
  
  $.ajax({
    type:"POST",
    dataType:'json',
    data:{
      name:name,
      title:title,
      institute:institute
    },
    url:"/teacher/store",
    success: function(data)
    {
       allData();
       
       $('#formmessage').show();
       $('#formmessage').html("<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>Added Data Successfully<strong></strong></div>");

       setTimeout(function(){
       $('#formmessage').hide(500);
       },3000);
       clearData();
    },
    error: function(error)
    {
      $('#nameError').text(error.responseJSON.errors.name);
      $('#titleError').text(error.responseJSON.errors.title);
      $('#instituteError').text(error.responseJSON.errors.institute  );
    }
  });
});
//------Insert Teacher Data End------------
  























//------Edit Teacher Data------------------------
function editData(id)
{
  $.ajax({
    type:"GET",
    dataType:"json",
    url:"/teacher/edit/"+id,
    success: function(data)
    {
      $('#addbtn').hide();
      $('#updatebtn').show();

       $('#id').val(data.id);
      $('#name').val(data.name);
      $('#title').val(data.title);
      $('#institute').val(data.institute);

      $('#nameError').text("");
      $('#titleError').text("");
      $('#instituteError').text("");
    }
  });
} 
//------Edit Teacher Data End------------------------



















//------updateData Teacher Data------------------------
$('#updatebtn').click(function(event){
  event.preventDefault();

  var id  = $('#id').val();
  var name  = $('#name').val();
  var title  = $('#title').val();
  var institute  = $('#institute').val();


  $.ajax({
    type:"POST",
    dataType:"json",
    data:{
      id:id,
      name:name,
      title:title,
      institute:institute
    },
    url:"/teacher/update/"+id,
    success: function(data)
    {
       clearData();
      $('#addbtn').show();
      $('#updatebtn').hide();

       allData();
       $('#formmessage').show();
       $('#formmessage').html("<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>Update Data Successfully<strong></strong></div>");

       setTimeout(function(){
       $('#formmessage').hide(500);
       },3000);


    },
    error: function(error)
    {
      $('#nameError').text(error.responseJSON.errors.name);
      $('#titleError').text(error.responseJSON.errors.title);
      $('#instituteError').text(error.responseJSON.errors.institute  );
    }
  });
});
//------updateData Teacher Data End------------------------

















//------Delete Teacher Data------------------------
function deleteData(id)
{
  $.ajax({
      type:"GET",
      dataType:"json",
      url:"/teacher/delete/"+id,
      success:function(data)
      {
       allData();
       $('#tablemessage').show();
       $('#tablemessage').html("<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>Delete Data Successfully<strong></strong></div>");
       //alert(response.success);

       setTimeout(function(){
       $('#tablemessage').hide(500);
       },3000);
      }
  });
}
//------Delete Teacher Data End------------------------


























//------Checkbox Functionality------------------------
$("#chkall").click(function(){
  $(".checkBoxClass").prop('checked', $(this).prop('checked'));
});

$("#deleteAll").click(function(e){
  e.preventDefault();
  var allids = [];
  $("input:checkbox[name=ids]:checked").each(function(){
    $push = allids.push($(this).val());
    //alert(allids);
  });

  $.ajax({
     type:"GET",
     url:"/allteacher/delete",
     dataType: 'json',
     data:{
       ids:allids
     },
     success:function(response)
     {  
       allData();
       $('#tablemessage').show();
       $('#tablemessage').html("<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>Delete Data Successfully<strong></strong></div>");
       //alert(response.success);

       setTimeout(function(){
       $('#tablemessage').hide(500);
       },3000);
     }
  });
});
//------Checkbox Functionality End--------------------













</script>
<!-----Script Part Start----------->



</body>
</html>