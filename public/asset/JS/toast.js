$(document).ready(function () {
    const flashMessagesElement = document.getElementById('flash-messages');
    const flashMessages = JSON.parse(flashMessagesElement.getAttribute('data-flash'));

    const toastList = document.getElementsByClassName('toast');

    const toastInstanceList = [];
    for (let toast of toastList) {
        toastInstanceList.push(new bootstrap.Toast(toast));
    }
    toastInstanceList.forEach((toastInstance) => toastInstance.show());
});