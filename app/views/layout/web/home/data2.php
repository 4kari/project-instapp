<!-- template -->
<div class="container" style="margin-top: 80px">
    <div id="post-container"></div>
</div>

<script>
function loadPosts() {
    fetch('<?= base_url("Posts/get_data"); ?>')
        .then(response => response.json())
        .then(data => {
            let html = '';

            data.forEach(post => {
                //bagian comment
                let commentsHtml = '';
                if (post.comments && post.comments.length > 0) {
                    console.log(post.comments);
                    post.comments.forEach(comment => {
                        commentsHtml += `
                            <div style="padding:5px 0; border-bottom: 1px solid #eee;">
                                <b>${comment.full_name}</b>: ${comment.comment}
                            </div>
                        `;
                    });
                } else {
                    commentsHtml = '<div style="font-style: italic; color: #999;">Belum ada komentar</div>';
                }

                //complete html
                html += `
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="chip">
                                    <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Person" width="96" height="96">
                                    ${post.user_nama}
                                </div>
                            </div>

                            <div class="card-image">
                                <p class="text-center">${post.post_content}</p>
                            </div>

                            <div class="card-action">
                                <a href="#" onclick="likePost(${post.post_id}); return false;"><i class="fa fa-heart"></i> Like</a>
                                <a href="#" onclick="showCommentForm(${post.post_id}); return false;"><i class="fa fa-comments"></i> Comment</a>
                                <hr>
                                <span style="color: #ada8a8;font-style: italic;"><b>${post.total_like}</b> orang menyukai ini</span>
                            </div>

                            <div id="comment-form-${post.post_id}" style="display: none; padding:10px;">
                                <textarea id="comment-text-${post.post_id}" class="form-control" placeholder="Tulis komentar..."></textarea>
                                <button class="btn btn-primary btn-sm" style="margin-top:10px;" onclick="submitComment(${post.post_id});">Kirim</button>
                            </div>
                            <div style="padding:10px;">
                                ${commentsHtml}
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });

            document.getElementById('post-container').innerHTML = html;
        });
}

function likePost(postId) {
    fetch('<?= base_url("Posts/likepost"); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'post_id=' + postId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadPosts();
        } else {
            alert('Gagal Like');
        }
    });
}

function showCommentForm(postId) {
    const form = document.getElementById('comment-form-' + postId);
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}

function submitComment(postId) {
    const text = document.getElementById('comment-text-' + postId).value;
    if (text.trim() === '') {
        alert('Komentar kosong');
        return;
    }

    fetch('<?= base_url("Posts/commentpost"); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'post_id=' + postId + '&comment=' + encodeURIComponent(text)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadPosts();
        } else {
            alert('Gagal Kirim Komentar');
        }
    });
}
// Auto-load posts saat halaman dibuka
document.addEventListener('DOMContentLoaded', loadPosts);
</script>
