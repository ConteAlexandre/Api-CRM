/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

$('.sidebar-dropdown > a').click(function() {
    $('.sidebar-submenu').slideUp(200);
    if (
        $(this)
            .parent()
            .hasClass('active')
    ) {
        $('.sidebar-dropdown').removeClass('active');
        $(this)
            .parent()
            .removeClass('active');
    } else {
        $('.sidebar-dropdown').removeClass('active');
        $(this)
            .next('.sidebar-submenu')
            .slideDown(200);
        $(this)
            .parent()
            .addClass('active');
    }
});

$('#close-sidebar').click(function() {
    $('.page-wrapper').removeClass('toggled');
});
$('#show-sidebar').click(function() {
    $('.page-wrapper').addClass('toggled');
});
$(document).ready(function() {
    $('#tableClients').DataTable();
} );
