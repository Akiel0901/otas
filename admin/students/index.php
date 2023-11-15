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
        <h3 class="card-title">List of Students</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Student</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ', middlename) as name from `student_list`  order by concat(lastname,', ',firstname,' ', middlename) asc ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class="text-center"><img src="<?php echo validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
                            <td><?php echo ucwords($row['name']) ?></td>
                            <td><p class="m-0 truncate-1"><?php echo $row['email'] ?></p></td>
                            <td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-pill badge-success">Verified</span>
                                <?php else: ?>
                                    <span class="badge badge-pill badge-primary">Not Verified</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm view_details" data-id="<?php echo $row['id'] ?>">
                                    <span class="fa fa-eye text-dark"></span> View
                                </button>
                                <?php if($row['status'] != 1): ?>
                                    <button type="button" class="btn btn-flat btn-default btn-sm verify_user" data-id="<?= $row['id'] ?>" data-name="<?= $row['email'] ?>">
                                        <span class="fa fa-check text-primary"></span> Verify
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-flat btn-default btn-sm delete_data" data-id="<?php echo $row['id'] ?>" data-name="<?= $row['email'] ?>">
                                    <span class="fa fa-trash text-danger"></span> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from Student List permanently?","delete_user",[$(this).attr('data-id')])
        })

        $('.verify_user').click(function(){
            _conf("Are you sure to verify <b>"+$(this).attr('data-name')+"<b/>?","verify_user",[$(this).attr('data-id')])
        })

        $('.view_details').click(function(){
            uni_modal('Student Details',"students/view_details.php?id="+$(this).attr('data-id'),'mid-large')
        })

        $('.table').dataTable();
    })

    function delete_user($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Users.php?f=delete_student",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occurred.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occurred.",'error');
                    end_loader();
                }
            }
        })
    }

    function verify_user($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Users.php?f=verify_student",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occurred.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occurred.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
