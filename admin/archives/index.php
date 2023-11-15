<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Research Archives</h3>
		<div class="card-tools">
		<button type="button" class="btn btn-flat btn-sm btn-primary" id="create_new"><span class="fas fa-plus"></span>  Add New Research</button>
		</div>
	</div>
	<div class="modal fade" id="addResearchModal" tabindex="-1" role="dialog" aria-labelledby="addResearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResearchModalLabel">Add New Research</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addResearchForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="researchTitle">Research Title</label>
                        <input type="text" class="form-control" id="researchTitle" name="researchTitle" required>
                    </div>
                    <div class="form-group">
                                <label for="year" class="control-label text-navy">Year</label>
                                <select name="year" id="year" class="form-control form-control-border" required>
                                    <?php 
                                        for($i= 0;$i < 14; $i++):
                                    ?>
                                    <option <?= isset($year) && $year == date("Y",strtotime(date("Y")." -{$i} years")) ? "selected" : "" ?>><?= date("Y",strtotime(date("Y")." -{$i} years")) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                     <div class="form-group">
                            <label for="department">Department</label>
                            <select class="form-control" id="department" name="department" required>
                            <!-- Department options will be dynamically populated here -->
                            </select>
                            </div>
                     <div class="form-group">
                            <label for="course">Course</label>
                            <select class="form-control" id="course" name="course" required>
                            <!-- Course options will be dynamically populated here -->
                            </select>
                            </div> 
                    <div class="form-group">
                                <label for="members" class="control-label text-navy">Project Members</label>
                                <textarea rows="3" name="members" id="members" placeholder="members" class="form-control form-control-border summernote-list-only" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="abstract" class="control-label text-navy">Abstract</label>
                                <textarea rows="3" name="abstract" id="abstract" placeholder="abstract" class="form-control form-control-border summernote" required></textarea>
                            </div>
                    <div class="form-group">
                        <label for="researchPDF">Upload PDF File</label>
                        <input type="file" class="form-control-file" id="researchPDF" name="researchPDF" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Research</button>
                </div>
            </form>
        </div>
    </div>
</div>

	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Archive Code</th>
						<th>Project Title</th>
						<th>Course</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
   <?php 
      $i = 1;
      $curriculum = $conn->query("SELECT * FROM curriculum_list where id in (SELECT curriculum_id from `archive_list`)");
      $cur_arr = array_column($curriculum->fetch_all(MYSQLI_ASSOC),'name','id');
      $qry = $conn->query("SELECT * from `archive_list` order by `year` desc, `title` desc ");
      while($row = $qry->fetch_assoc()):
   ?>
   <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
      <td><?php echo ($row['archive_code']) ?></td>
      <td><?php echo ucwords($row['title']) ?></td>
      <td><?php echo $cur_arr[$row['curriculum_id']] ?></td>
      <td class="text-center">
         <?php
            switch($row['status']){
               case '1':
                  echo "<span class='badge badge-success badge-pill'>Published</span>";
                  break;
               case '0':
                  echo "<span class='badge badge-secondary badge-pill'>Not Published</span>";
                  break;
            }
         ?>
      </td>
      <td align="center">
         <a class="btn btn-flat btn-default btn-sm text-primary mr-2" href="<?= base_url ?>/?page=view_archive&id=<?php echo $row['id'] ?>" target="_blank"><span class="fa fa-external-link-alt"></span></a>
         <!-- Update Status Icon -->
         <a class="btn btn-flat btn-default btn-sm text-success mr-2 update_status" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="<?php echo $row['status'] ?>"><span class="fa fa-check"></span></a>
         <!-- Delete Icon -->
         <a class="btn btn-flat btn-default btn-sm text-danger delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash"></span></a>
      </td>
   </tr>
   <?php endwhile; ?>
</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.verified').click(function(){
			_conf("Are you sure to verify this enrollee Request?","verified",[$(this).attr('data-id')])
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this project permanently?","delete_archive",[$(this).attr('data-id')])
		})
		$('.update_status').click(function(){
            uni_modal("Update Details","archives/update_status.php?id="+$(this).attr('data-id')+"&status="+$(this).attr('data-status'))
        })
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_archive($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_archive",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
    $(document).ready(function () {
    $('#create_new').click(function () {
        $('#addResearchModal').modal('show');
        fetchDepartments();
        fetchCourses();
    });

    function fetchDepartments() {
        $.ajax({
            url: 'fetch_departments.php', // Replace with the correct URL
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate the Department dropdown with data
                var departmentDropdown = $('#department');
                departmentDropdown.empty();
                $.each(data, function (id, name) {
                    departmentDropdown.append($('<option>', {
                        value: id,
                        text: name
                    }));
                });
            }
        });
    }

    function fetchCourses() {
        $.ajax({
            url: 'fetch_courses.php', // Replace with the correct URL
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate the Course dropdown with data
                var courseDropdown = $('#course');
                courseDropdown.empty();
                $.each(data, function (id, name) {
                    courseDropdown.append($('<option>', {
                        value: id,
                        text: name
                    }));
                });
            }
        });
    }
});


    $(function(){
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                [ 'table', [ 'table' ] ],
                ['insert', ['link', 'picture']],
                [ 'view', [ 'undo', 'redo', 'help' ] ]
            ]
        })
        $('.summernote-list-only').summernote({
            height: 200,
            toolbar: [
                [ 'font', [ 'bold', 'italic', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ]
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul' ] ],
                [ 'view', [ 'undo', 'redo', 'help' ] ]
            ]
        })
    })

</script>