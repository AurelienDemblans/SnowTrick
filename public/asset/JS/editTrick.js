document.addEventListener('DOMContentLoaded', function () {
    const deletePictureButton = Array.from(document.getElementsByClassName('delete_picture'));
    const deleteVideoButton = Array.from(document.getElementsByClassName('delete_video'));
    const toggleCoverButton = Array.from(document.getElementsByClassName('toggle_cover_input'));
    const revertRemovalPictureButton = Array.from(document.getElementsByClassName('revert-removal-picture'));
    const revertRemovalVideoButton = Array.from(document.getElementsByClassName('revert-removal-video'));
    let picturesId = [];
    let videosId = [];

    deletePictureButton.forEach(deleteButton => {
        deleteButton.addEventListener("click", function () {
            const id = this.getAttribute('data-id');

            if (!picturesId.includes(id)) {
                picturesId.push(id);
            }

            const pictureToDelete = document.getElementById('removed-picture-' + id);
            pictureToDelete.classList.remove('hidden');

            document.getElementById('trick_form_pictures_id').value = picturesId.join(',');
        });
    });

    deleteVideoButton.forEach(deleteButton => {
        deleteButton.addEventListener("click", function () {
            const id = this.getAttribute('data-id');

            if (!videosId.includes(id)) {
                videosId.push(id);
            }

            const videoToDelete = document.getElementById('removed-video-' + id);
            videoToDelete.classList.remove('hidden');

            document.getElementById('trick_form_videos_id').value = videosId.join(',');
        });
    });

    toggleCoverButton.forEach(toggleButton => {
        toggleButton.addEventListener("click", function () {
            document.getElementById('cover_input').classList.remove('hidden');
            document.getElementById('cover_picture').classList.add('hidden');
        });
    });

    revertRemovalPictureButton.forEach(revertButton => {
        revertButton.addEventListener("click", function () {
            const pictureId = this.getAttribute('data-id');

            picturesId = picturesId.filter((id) => id !== pictureId);

            document.getElementById('removed-picture-' + pictureId).classList.add('hidden');
            document.getElementById('trick_form_pictures_id').value = picturesId.join(',');
        });
    });

    revertRemovalVideoButton.forEach(revertButton => {
        revertButton.addEventListener("click", function () {
            const videoId = this.getAttribute('data-id');

            videosId = videosId.filter((id) => id !== videoId);
            console.log(videosId);
            document.getElementById('removed-video-' + videoId).classList.add('hidden');
            document.getElementById('trick_form_videos_id').value = videosId.join(',');
        });
    });
});