<div class="container" style="margin-top: 80px">
	<?php foreach ($datapost as $key => $value) { ?>
		<div class="row">

		<div class="col-md-6 col-md-offset-3">

			<div class="card">
				<div class="card-content">
					<div class="chip">
					  <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Person" width="96" height="96">
					  <?= $value['user_nama'];?>
					</div>
				</div>
                <div class="card-image">
                    <p class="text-center"><?= $value['post_content'];?></p>
                </div>
                
                <div class="card-action">
                    <a href="#"><i class="fa fa-heart"></i> Like</a>
                    <a href="#" onclick="comment();" id="show_comment"><i class="fa fa-comments"></i> Comment</a>
                    <hr>
                    <span style="color: #ada8a8;font-style: italic;"><b><?= $value['total_like'];?></b> orang menyukai ini</span>
                </div>
            </div>

		</div>

	</div>
	<?php }?>
</div>