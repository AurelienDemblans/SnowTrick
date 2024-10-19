document.addEventListener('DOMContentLoaded', function () {
    const deletePictureButton = Array.from(document.getElementsByClassName('delete_picture'));
    const deleteVideoButton = Array.from(document.getElementsByClassName('delete_video'));
    const picturesId = [];
    const videosId = [];

    deletePictureButton.forEach(deleteButton => {
        deleteButton.addEventListener("click", function () {
            const id = this.getAttribute('data-id');

            if (!picturesId.includes(id)) {
                picturesId.push(id);
            }

            const pictureToDelete = document.getElementById('picture-' + id);
            pictureToDelete.style.display = 'none';

            const pictureCardNumber = document.getElementsByClassName('picture-card').length - picturesId.length;
            if (pictureCardNumber === 0) {
                noPictureCard = document.getElementById('no-picture-card').style.display = '';
            }

            document.getElementById('trick_form_pictures_id').value = picturesId.join(',');
        });
    });

    deleteVideoButton.forEach(deleteButton => {
        deleteButton.addEventListener("click", function () {
            const id = this.getAttribute('data-id');

            if (!videosId.includes(id)) {
                videosId.push(id);
            }

            const videoToDelete = document.getElementById('video-' + id);
            videoToDelete.style.display = 'none';

            const videoCardNumber = document.getElementsByClassName('video-card').length - videosId.length;
            if (videoCardNumber === 0) {
                noVideoCard = document.getElementById('no-video-card').style.display = '';
            }

            document.getElementById('trick_form_videos_id').value = videosId.join(',');
        });
    });
});