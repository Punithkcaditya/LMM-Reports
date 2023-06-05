<div class="container-fluid pt-8">
    <div class="row">

        <div class="col-lg-12">
            <?= $this->include('message/message') ?>
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">Upload File</h2>
                </div>
                <form action="<?php echo base_url('BulkuploadController/singleupload');?>" method="post"
                    enctype="multipart/form-data"> 
                   <div class="card-body">
                   <div class="form-group">
                        <select name="admin_users" id="admin_users" class="form-control" required>
                            <option value="">-- Choose Employee
                            </option>
                            <?php foreach ($admin_users as $rowdata): ?>
                            <option value="<?php echo $rowdata['employee_id'] ?>">
                                <?php echo $rowdata['first_name'] .'-'. $rowdata['first_name'] ?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                        <div>
                            <input type="file" id="userfile" name="userfile" class="dropify" data-max-file-size="200M" />
                            <div>
                                <input type="submit" name="submit" value="Upload" class="btn btn-primary mt-3 mb-1" />
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>