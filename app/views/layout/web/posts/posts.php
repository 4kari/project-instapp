<div class="container" style="margin-top: 150px">
    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="img-logo" style="text-align: center; padding-bottom: 20px;">
                <img src="<?php echo base_url() ?>resources/images/logo.png">
            </div>

            <div class="card">
                <div class="card-content">

                    <?php echo form_open_multipart('posts/store') ?>
                        <div class="form-group">
                            <label for="content"><i class="fa fa-pencil"></i> ISI POSTINGAN</label>
                            <textarea name="content" id="content" class="form-control" rows="4" placeholder="Apa yang Anda pikirkan?" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image"><i class="fa fa-image"></i> GAMBAR (Opsional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="border-radius: 25px;"><i class="fa fa-paper-plane"></i> Posting</button>
                            <a href="<?= base_url('home'); ?>" class="btn btn-default" style="border-radius: 25px;"><i class="fa fa-arrow-left"></i> Batal</a>
                        </div>

                    <?php echo form_close() ?>

                </div>
            </div>

        </div>

    </div>
</div>
