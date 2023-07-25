

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $this->session->flashdata('message6');?>
                        </div>
                    </div>

                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <div class="card bg-danger">
                                    <div class="card-box ">

                                        <img src="<?= base_url('asset/img/profile/') . $user['img'];?>" class="card-img" >
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $user['name'];?></h5>
                                <p class="card-text"><?= $user['email'];?></p>
                                <p class="card-text"><small class="text-muted">Meber since <?= date('d F Y', $user['date_created']) ; ?></small></p>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

