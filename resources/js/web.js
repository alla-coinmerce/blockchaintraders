import './bootstrap';

// When the user scrolls the page, execute myFunction
window.onscroll = function() {handleSticky()};

// Get the header
var header = document.getElementById("webheader");

// Get the offset position of the navbar for the header
var stickyMobile = header.offsetTop + 850;
var stickyDesktop = header.offsetTop + 450;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function handleSticky()
{
    if (window.pageYOffset > stickyMobile)
    {
        // void header.offsetWidth;

        $('#webheader').addClass('stickyMobile');
    }
    else
    {
        $('#webheader').removeClass('stickyMobile');
    }

    if (window.pageYOffset > stickyDesktop)
    {
        // void header.offsetWidth;

        $('#webheader').addClass('stickyDesktop');
    }
    else
    {
        $('#webheader').removeClass('stickyDesktop');
    }
}

window.openBrochureRequestModal = function()
{
    var modal = document.getElementById('brochure_request');

    modal.style.display = "block";
}

window.openInformationRequestModal = function(request_document)
{
    var modal = document.getElementById('information_request');

    $("#requested_doc").text(request_document);
    $("#requested_document").val(request_document);

    var element = document.getElementById('requested_document');
    element.dispatchEvent(new Event('input'));

    modal.style.display = "block";
}

window.open_modal = function(id)
{
    // console.log("open_modal " + id);

    var modal = document.getElementById(id);

    modal.style.display = "block";
}

window.close_modal = function(id)
{
    // console.log("close_modal " + id);

    var modal = document.getElementById(id);

    modal.style.display = "none";

    Livewire.emit('refreshModals')
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event)
{
    var modals = document.getElementsByClassName('modal');

    for (var i = 0; i < modals.length; i++)
    {
        var modal = modals.item(i);

        if (event.target == modal)
        {
            modal.style.display = "none";

            Livewire.emit('refreshModals')
        }
    }
}

window.toggleFaqAnswer = function(element)
{
    $(element).find('button i').toggleClass("fa-chevron-up");
    $(element).find('button i').toggleClass("fa-chevron-down");

    $(element).find('.answer').toggle();
}

document.addEventListener('DOMContentLoaded',function()
{
	initSwiper();

    initLottie(document.getElementById("firstLottie"));
    initLottie(document.getElementById("secondLottie"));
    initLottie(document.getElementById("thirdLottie"));
    initLottie(document.getElementById("forthLottie"));
    initLottie(document.getElementById("fifthLottie"));
});

window.initSwiper = function()
{
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        // direction: 'horizontal',
        // loop: true,
        slidesPerView: 2.3,
        spaceBetween: 15,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 700px
            700: {
                slidesPerView: 5
            },
        }
    });
}

window.initLottie = function(lottieElement)
{
    if(lottieElement)
    {
         // Play as soon as the animation is 50% visible
        lottieElement.playOnShow({
            threshold: [0.50],
        });

        if($(lottieElement).is(":visible"))
        {
            lottieElement.play();
        }
    }
}
