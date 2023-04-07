<!doctype html>
<html lang="en">
<?php //echo base_url("dashboard/fetchdata_con"); ?>
<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Bootstrap CSS v5.2.1 -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	 <style>
	.error{
		color : red;
	}
</style>	 
</head>

<body>

<div class="container">
<!-- Button trigger modal -->
<button type="button" class="btn btn-success mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal" id="add_button_id">
  Add Records
</button>

<!-- Modal -->
<form id="my_form">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
	<div class="mb-3">
    	<label class="form-label">Name</label>
    	<input type="text" class="form-control" name = "name" id="name_id">
  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" id="save_id">Save</button>
      </div>
    </div>
  </div>
</div>
</form>

	<table class="table table-bordered table-striped" id="table_id"  data-ordering="false">
	<thead class="table-light">
		<tr>
		<th>S No.</th>
		<th>Name</th>
		<th>Action</th>
		</tr>
	</thead>
	</table>

</div>

<!-- EDIT Modal -->
<form id="edit_form">
<div class="modal fade" id="edit_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	<!-- <form id="edit_form"> -->
	  <div class="modal-body">
		<input type="hidden" name="id" id="edit_id">
		<div class="mb-3">
    		<label class="form-label">Name</label>
    		<input type="text" class="form-control" name = "name" id="edit_name_id">
  		</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" id="update_id">Update</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- EDIT Modal -->

  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
	integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
	integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
	

	<script>
		$(document).ready(function() {
			$('#table_id').DataTable({
				"ajax": {
					url :"<?php echo base_url('dashboard/fetchdata_con'); ?>",
					type :'GET'
				},
			});			
		});

		function edit_data(id){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('dashboard/edit_data'); ?>",
				data : {id : id},
				dataType: "json",
				success: function (response) {
					$('#edit_id').val(response.id);
					$('#edit_name_id').val(response.name);
					$('#edit_Modal').modal('show');
				}
			});
		}

		function delete_data(id) {
			if(confirm('Are You Sure ?') == true)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('dashboard/delete_data'); ?>",
					data: {id : id},
					dataType: "json",
					success: function (response) {
						if (response == 1) {
							alert('Record Deleted Successfully');
							$('#table_id').DataTable().ajax.reload();
						}else{
							alert('Record Failed to Deleted');
						}
					}
				});
			}
		}

		$('#update_id').click(function() {
			var edit_name = $('#edit_name_id').val();
			if(edit_name == ""){
			jQuery('#edit_form').validate({
				rules:{
					name: "required"
				}, messages:{
					name: "The Name field is Required"
				}
            });
			}else{
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('dashboard/update');  ?>",
				data: $('#edit_form').serialize(),
				dataType: "json",
				success: function (response) {
					$('#edit_Modal').modal('hide');
					$('#table_id').DataTable().ajax.reload();
				}
			});
		}
		});

		$('#save_id').click(function() {
			var name = $('#name_id').val();
			if(name == ""){
			jQuery('#my_form').validate({
				
				rules:{
					name: "required"
				}, messages:{
					name: "The Name field is Required"
				}

            });
			}else{
			event.preventDefault();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('dashboard/add_data')  ?>",
					data: $('#my_form').serialize(),
					success: function (data) {
						$('#exampleModal').modal('hide');
						$('#table_id').DataTable().ajax.reload();
						document.getElementById("my_form").reset();				
					}
				});
			}
		});

	</script>
</body>

</html>