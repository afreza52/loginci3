<!-- UBAH MENU -->
<div class="container-fluid">
    <div class="row ">
        <div class="col-lg-5 mx-auto mb-4">
           <div class="card">
            <div class="card-body">
            <form action="<?= base_url('menu/editmenu/');?><?= $menu['id'];?>" method="post" >
                    <div class="modal-body">
                        <input type="text" class="form-control" id="menu" name="menu" value="<?= $menu['menu'];?>">
                    </div>
                    <div class="modal-footer">
                        <a href="<?= base_url('menu');?>"class="btn btn-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
           </div>
        </div>
    </div>
</div>



