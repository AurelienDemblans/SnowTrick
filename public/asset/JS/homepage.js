$(document).ready(function () {
    $('a.smooth_scroll_up').on('click', function (e) {
        e.preventDefault();
        let target = $(this).data('target');
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 1000);
    });
    $('a.smooth_scroll_down').on('click', function (e) {
        e.preventDefault();
        let target = $(this).data('target');
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 1000);
    });
});

let trickTarget = 1;
$(document).ready(function () {
    let nbTricksPerPage = document.getElementById("trick_list").getAttribute('data-nbTricksPerPage');

    // on click 'show more trick' button a new round of tricks are displayed into the page
    $('button#moreTricks').on('click', function (e) {
        const divs = document.querySelectorAll('div[data-trickTarget="' + trickTarget + '"]');
        trickTarget++;

        divs.forEach(div => {
            div.classList.remove('hide');
            div.classList.add('show');
        });

        // scroll to bottom page when new tricks are revealed
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });

        // hide button if all tricks displayed
        if (trickTarget >= (trickListLength / nbTricksPerPage)) {
            const showMoreButton = document.getElementById("moreTricks");
            showMoreButton.classList.add('hide');
        }
        if ((trickTarget * nbTricksPerPage) >= 8) {
            const arrowUp = document.getElementById('arrowUp');
            arrowUp.classList.remove('hide');
            arrowUp.classList.add('show_trick');

        }
    });
});