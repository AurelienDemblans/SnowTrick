document.addEventListener('DOMContentLoaded', function () {
    let offset = document.getElementsByClassName("trick_comment_item").length;
    const loadMoreButton = document.getElementById('load-more-comments');

    loadMoreButton.addEventListener("click", function () {
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
});