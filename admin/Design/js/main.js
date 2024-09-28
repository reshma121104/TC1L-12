/*
    ======================================
    
    DASHBOARD PAGE ==== > TOGGLE BOOKINGS TABS IN DASHBOARD PAGE

    ========================================
*/

function openTab(evt, tabName) 
{
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    
    for (i = 0; i < tabcontent.length; i++) 
    {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) 
    {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    document.getElementById(tabName).style.display = "table";
    evt.currentTarget.className += " active";
}
$(document).ready(function() {
    $('.delete_car_bttn').click(function() {
        var carId = $(this).attr('data-id');
        $.ajax({
            url: 'path/to/car.php', // Adjust with actual path
            type: 'POST',
            data: { car_id: carId },
            success: function(response) {
                alert('Car Deleted Successfully!');
                // Optionally refresh the page or remove the car entry from the DOM
            },
            error: function() {
                alert('Error deleting car.');
            }
        });
    });
});
