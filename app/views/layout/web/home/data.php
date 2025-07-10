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
					<a href="#" onclick="likePost(<?= $value['post_id']; ?>);"><i class="fa fa-heart"></i> Like</a>
					<a href="#" onclick="showCommentForm(<?= $value['post_id']; ?>);"><i class="fa fa-comments"></i> Comment</a>
					<hr>
					<span style="color: #ada8a8;font-style: italic;"><b><?= $value['total_like'];?></b> orang menyukai ini</span>
				</div>

				<!-- Comment Form (Hidden by Default) -->
				<div id="comment-form-<?= $value['post_id']; ?>" style="display: none; padding: 10px;">
					<textarea id="comment-text-<?= $value['post_id']; ?>" class="form-control" placeholder="Tulis komentar..."></textarea>
					<button class="btn btn-primary btn-sm" style="margin-top:10px;" onclick="submitComment(<?= $value['post_id']; ?>);">Kirim</button>
				</div>
            </div>

		</div>

	</div>
	<?php }?>
</div>
<script>
function likePost(postId) {
    fetch('<?= base_url("Posts/likepost"); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'post_id=' + postId
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert('Berhasil like!');
            location.reload();
        } else {
            alert('Gagal like');
        }
    });
}

function showCommentForm(postId) {
    const form = document.getElementById('comment-form-' + postId);
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}

function submitComment(postId) {
    const commentText = document.getElementById('comment-text-' + postId).value;
    if (commentText.trim() === '') {
        alert('Komentar tidak boleh kosong');
        return;
    }

    fetch('<?= base_url("Posts/commentpost"); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'post_id=' + postId + '&comment=' + encodeURIComponent(commentText)
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert('Komentar terkirim!');
            location.reload();
        } else {
            alert('Gagal kirim komentar');
        }
    });
}
</script>
