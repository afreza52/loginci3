<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                        <form action="<?= base_url('menu/editsubmenu/'). $subMenu['id'];?>" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="title" name="title" value="<?= $subMenu['title']; ?>">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <select name="menu_id" id="menu_id" class="form-control">
                                    <?php foreach ($menu as $m) : ?>
                                        <?php if ($m['id'] == $subMenu['menu_id']) : ?>
                                            <option value="<?= $m['id']; ?>" selected><?= $m['menu']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="url" name="url" value="<?= $subMenu['url']; ?>">
                                <?= form_error('url', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="icon" name="icon" value="<?= $subMenu['icon']; ?>">
                                <?= form_error('icon', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" <?= ($subMenu['is_active'] == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active?
                                    </label>
                                </div>
                            </div>
                            <a href="<?= base_url('menu/submenu');?>"class="btn btn-secondary">Close</a>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
