<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-green shadow elevation-2"style="height: 100px;">
            <span class="info-box-icon bg-green elevation-2"style="width: 80px;"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text"style= "font-size: 18px;">Department List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `department_list` where status = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-yellow shadow elevation-2"style="height: 100px;">
            <span class="info-box-icon bg-yellow elevation-2"style="width: 80px;"><i class="fas fa-scroll"></i></span>
            <div class="info-box-content">
            <span class="info-box-text"style= "font-size: 18px;">Course List</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `curriculum_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-primary shadow elevation-2"style="height: 100px;">
            <span class="info-box-icon bg-blue elevation-2"style="width: 80px;"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text"style= "font-size: 18px;">Verified Students</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `student_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-danger shadow elevation-2"style="height: 100px;">
            <span class="info-box-icon bg-danger elevation-2"style="width: 80px;"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text"style= "font-size: 18px;">Not Verified Students</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `student_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-gray shadow elevation-2"style="height: 100px;">
            <span class="info-box-icon bg-gray elevation-2"style="width: 80px;"><i class="fas fa-archive"></i></span>

            <div class="info-box-content">
            <span class="info-box-text"style= "font-size: 18px;">Verified Archives</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `archive_list` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-dark shadow elevation-2"style="height: 100px;">
            <span class="info-box-icon bg-dark elevation-2"style="width: 80px;"><i class="fas fa-archive"></i></span>

            <div class="info-box-content">
            <span class="info-box-text"style= "font-size: 18px;">Not Verified Archives</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `archive_list` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>