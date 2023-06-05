<!-- Page content -->
<div class="container-fluid pt-8">

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">Add New User</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsives">
                        <form action="<?php echo base_url('addnewusers') ?>" method="POST" enctype="multipart/form-data">
                            <?= $this->include('message/message') ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Enter  Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            placeholder="Enter  Name" value="" required>
                                    </div>
                                 
                                    <div class="form-group">
                                        <input type="hidden" name="role_id" id="role_id" class="form-control" value="4" />
                                        <label class="form-label">Enter Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Enter Password Address" value="" required>
                                    </div>
                                  

            



                                </div>

                                <div class="col-md-6">
                                   
                                    <div class="form-group">
                                        <label class="form-label">Enter Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Enter Email Address" value="" required>
                                    </div>

                                </div>
                                <div class="col-md-12" style="text-align: center;">
                                    <div class="d-grid gap-1">
                                        <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>