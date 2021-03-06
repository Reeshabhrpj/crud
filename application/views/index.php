<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>

<div class="container">
		
		<br><br>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
		     Add Record
		</button><br><br>

        <form id="createForm">
			<!-- Modal -->
			<div class="modal fade" id="createModal" aria-hidden="true">
				<div class="modal-dialog" role="document">
				    <div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Add Record</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  	<span aria-hidden="true">&times;</span>
							</button>
						</div>
				      	<div class="modal-body">
				        	<div class="form-group">
							    <label>Name</label>
							    <input type="text" class="form-control" placeholder="Name here" name="name">
							</div>
							<div class="form-group">
								<label>Message</label>
							    <input type="text" class="form-control" placeholder="Message Here" name="message">
							</div>
							<div class="form-group">
							    <label>Age</label>
							    <input type="number" class="form-control" placeholder="Age Here" name="age">
							</div>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
				        	<button type="submit" class="btn btn-primary">Save</button>
				      	</div>
				    </div>
				</div>
			</div>
		</form>


    <table id="example1" class="display table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
</div>


<!-- edit modal -->
<div class="modal fade" id="editModal" aria-hidden="true">
	  	<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<h5 class="modal-title">Edit Record</h5>
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          		<span aria-hidden="true">&times;</span>
		        	</button>
		      	</div>
		      	<form id="editForm">
			      	<div class="modal-body">
			      		<input type="hidden" name="id" id="editID">
		        		<div class="form-group">
						    <label>Name</label>
						    <input type="text" class="form-control" placeholder="Name here" name="name" id="editName">
						</div>
						<div class="form-group">
						    <label>Message</label>
						    <input type="text" class="form-control" placeholder="Message Here" name="message" id="editMessage">
						</div>
						<div class="form-group">
						    <label>Age</label>
						    <input type="number" class="form-control" placeholder="Age Here" name="age" id="editAge">
						</div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary">Update</button>
			      	</div>
			  	</form>
		    </div>
	  	</div>
	</div>

<!--edit modal end-->

            
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   
   <script type="text/javascript">
  
    $("#createForm").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "<?php echo base_url('my_controller/create'); ?>",
                    data: $("#createForm").serialize(),
                    type: "post",
                    async: false,
                    dataType: 'json',
                    success: function(response){
                    
                        $('#createModal').modal('hide');
                        $('#createForm')[0].reset();
                        alert('Successfully inserted');
                        $('#example1').DataTable().ajax.reload();
                        loadDatatableAjax();
                    },
                error: function()
                {
                    alert("error");
                }
            });
            });


            $(document).ready(function(){
            $('#example1').DataTable({
                "ajax" : "<?php echo base_url('MY_Controller/fetchDatafromDatabase'); ?>",
                "order" : [],
            });
        });



        //edit function start here
		function editFun(id)
		{
			$.ajax({
				url: "<?php echo base_url('my_controller/getEditData'); ?>",
				method:"post",
				data:{id:id},
				dataType:"json",
				success:function(response)
				{
					$('#editID').val(response.id);
					$('#editName').val(response.name);
					$('#editMessage').val(response.message);
					$('#editAge').val(response.age);
					$('#editModal').modal({
						backdrop:"static",
						keyboard:false
					});
				}
			})
		}

        $("#editForm").submit(function(event) {
			event.preventDefault();
			$.ajax({
	            url: "<?php echo base_url('my_controller/update'); ?>",
	            data: $("#editForm").serialize(),
	            type: "post",
	            async: false,
	            dataType: 'json',
	            success: function(response){
	              
	                $('#editModal').modal('hide');
	                $('#editForm')[0].reset();
	                if(response==1)
	                {
	                	alert('Successfully updated');
	                }
	                else{
	                	alert('Updation Failed !');
	                }
                    $('#example1').DataTable().ajax.reload();
	            //    loadDatatableAjax();
	              },
	           error: function()
	           {
	            alert("error");
	           }
          });
		});

		//edit function work end here

        //delete function start here
		function deleteFun(id)
		{
			if(confirm('Are you sure want to delete?')==true)
			{
				$.ajax({
					url:'<?php echo base_url('my_controller/deleteSingleData'); ?>',
					method:"post",
					dataType:"json",
					data:{id:id},
					success:function(response)
					{
						if(response==1)
						{
							alert('Data Deleted Successfully');
                            $('#example1').DataTable().ajax.reload();
							// loadDatatableAjax();
						}
						else
						{
							alert('Deletion Failed !');
						}
                       
					}
				})
			}
		}
		//delete function end here

     </script>


</body>
</html>
