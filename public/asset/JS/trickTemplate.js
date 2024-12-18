document.addEventListener('DOMContentLoaded', function () {
    let offset = document.getElementsByClassName("trick_comment_item").length;
    const loadMoreButton = document.getElementById('load-more-comments');
    const showPictureButton = document.getElementById('show_pictures_videos_list_button');

    loadMoreButton?.addEventListener("click", function () {
        fetch(`/trick_comments/${trickId
            }/comments_offset/${offset
            }`).then(response => response.text()).then(data => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;

                var hasMoreCommentsDiv = tempDiv.querySelector('[data-hasmorecomments]');
                const hasMoreCommentsValue = hasMoreCommentsDiv.getAttribute('data-hasmorecomments');

                if (hasMoreCommentsValue !== '1') {
                    const moreCommentButton = document.getElementById('load-more-comments-container');
                    if (moreCommentButton) {
                        moreCommentButton.remove();
                    }
                }
                const commentsContainer = document.getElementById('more_comments_container');
                commentsContainer.insertAdjacentHTML('beforeend', data);
                offset += 5;

            }).catch(error => console.error('Error:', error));
    });

    //show pictures on mobile
    showPictureButton.addEventListener("click", function () {
        const pictureVideoList = document.getElementById('pictures_videos_list');
        const bouton = showPictureButton.querySelector('button');

        if (pictureVideoList.classList.contains('hidden')) {
            pictureVideoList.classList.remove('hidden');
            bouton.textContent = "Cacher les photos et vidéos";

        } else {
            pictureVideoList.classList.add('hidden');
            bouton.textContent = "Afficher les photos et vidéos";
        }
    });
});