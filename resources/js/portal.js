import './bootstrap';


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

window.toggleDetails = function(element)
{
    $(element).find('.summary button:not(.summary_inner button) i').toggleClass("fa-chevron-up");
    $(element).find('.summary button:not(.summary_inner button) i').toggleClass("fa-chevron-down");

    $(element).find('.details:not(.summary_inner .details)').toggle();
}

window.toggleDetailsMobileOnly = function(element)
{
    if(window.innerWidth<700)
    {
        toggleDetails(element);
    }
}

window.toggleInnerDetails = function(element)
{
    if(window.innerWidth<700)
    {
        $(element).find('.summary .summary_inner button i').toggleClass("fa-chevron-up");
        $(element).find('.summary .summary_inner button i').toggleClass("fa-chevron-down");

        $(element).find('.details').toggle();
        $(element).find('hr').toggle();
        $(element).find('button:not(.summary_inner button):not(.pagination button)').toggle();

        $(element).find('.details:not(.summary_inner .details)').hide();

        $(element).find('.summary button:not(.summary_inner button) i').removeClass("fa-chevron-up");
        $(element).find('.summary button:not(.summary_inner button) i').addClass("fa-chevron-down");
    }
}

document.addEventListener('DOMContentLoaded',function()
{
	darkmode_init();
});

window.darkmode_init = function()
{
    let darkmodeSwitch = document.querySelector('#dark_mode_switch');

    const eventLightMode = new Event("lightMode");
    const eventDarkMode = new Event("darkMode");
	
	let darkmodeCookie = {
		set:function(key, value, time, path, secure=false)
		{
			let expires = new Date();
			expires.setTime(expires.getTime() + time);
			var path   = (typeof path !== 'undefined') ? 'path=' + path + ';' : '';
			var secure = (secure) ? ';secure' : '';
			
			document.cookie = key + '=' + value + ';' + path + 'expires=' + expires.toUTCString() + secure;
		},
		get:function()
		{
			let keyValue = document.cookie.match('(^|;) ?darkmode=([^;]*)(;|$)');
			return keyValue ? keyValue[2] : null;
		},
		remove:function()
		{
			document.cookie = 'darkmode=; Max-Age=0; path=/';
		}
	};
	
	if(darkmodeCookie.get() == 'true')
	{
        $('html').addClass("dark-mode");
        $('header a img').attr("src", "/assets/images/Logo_darkmode.svg");
        $('#dark_mode_switch img').attr("src", "/assets/images/LightMode.svg");
        $('#dark_mode_switch span').text('Light mode');
        darkmodeSwitch.dispatchEvent(eventDarkMode);
	}
    else
    {
        darkmodeCookie.remove();
        darkmodeSwitch.dispatchEvent(eventLightMode);
    }
	
    if(darkmodeSwitch)
    {
        darkmodeSwitch.addEventListener('click', (event) => {
            event.preventDefault();
            
            toggleLightDarkMode();
            
            if($('html').hasClass('dark-mode'))
            {
                darkmodeCookie.set('darkmode', 'true', 2628000000, '/', false);
                darkmodeSwitch.dispatchEvent(eventDarkMode);
            }
            else
            {
                darkmodeCookie.remove();
                darkmodeSwitch.dispatchEvent(eventLightMode);
            }
        });
    }

    window.toggleLightDarkMode = function()
    {
        $('html').toggleClass("dark-mode");
        
        if($('#dark_mode_switch img').attr('src') === "/assets/images/NightMode.svg")
        {
            $('header a img').attr("src", "/assets/images/Logo_darkmode.svg");
            $('#dark_mode_switch img').attr("src", "/assets/images/LightMode.svg");
            $('#dark_mode_switch span').text('Light mode');
        }
        else
        {
            $('header a img').attr("src", "/assets/images/Logo.svg");
            $('#dark_mode_switch img').attr("src", "/assets/images/NightMode.svg");
            $('#dark_mode_switch span').text('Dark mode');
        }
    }
}