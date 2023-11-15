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
		<h3 class="card-title">List of Curriculum</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Course</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="25%">
					<col width="25%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Department</th>
						<th>Course</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT c.*, d.name as department from `curriculum_list` c inner join `department_list` d on c.department_id = d.id order by c.`name` asc");
						while($row = $qry->fetch_assoc()):
						
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class=""><?php echo $row['department'] ?></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td class="text-center">
                                <?php
                                    switch($row['status']){
                                        case '1':
                                            echo "<span class='badge badge-success badge-pill'>Active</span>";
                                            break;
                                        case '0':
                                            echo "<span class='badge badge-secondary badge-pill'>Inactive</span>";
                                            break;
                                    }
                                ?>
                            </td>
							<td align="center">
                                <a class="btn btn-flat btn-default btn-sm" href="javascript:void(0)" onclick="viewCurriculum(<?php echo $row['id'] ?>)"><span class="fa fa-eye text-dark"></span></a>
                                <a class="btn btn-flat btn-default btn-sm" href="javascript:void(0)" onclick="editCurriculum(<?php echo $row['id'] ?>)"><span class="fa fa-edit text-primary"></span></a>
                                <a class="btn btn-flat btn-default btn-sm" href="javascript:void(0)" onclick="deleteCurriculum(<?php echo $row['id'] ?>)"><span class="fa fa-trash text-danger"></span></a>
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
        $('#create_new').click(function(){
			uni_modal("Curriculum Details","curriculum/manage_curriculum.php")
		})
	})

    function viewCurriculum(id) {
        uni_modal("Curriculum Details", "curriculum/view_curriculum.php?id=" + id);
    }

    function editCurriculum(id) {
        uni_modal("Curriculum Details", "curriculum/manage_curriculum.php?id=" + id);
    }

    function deleteCurriculum(id) {
        _conf("Are you sure to delete this Curriculum permanently?", "delete_curriculum", [id]);
    }
</script>
