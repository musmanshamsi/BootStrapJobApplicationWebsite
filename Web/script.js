    $(document).ready(function() {
    // Programmatically open the first accordion and add the background color
        $('#collapseWebDev').collapse('show');
        $('.card-header[data-toggle="collapse"][href="#collapseWebDev"]').addClass('accordion-open');
        $('.card-header[data-toggle="collapse"][href="#collapseWebDev"] .rotate-icon').addClass('rotate'); // Add rotation on page load

        $('.accordion-button').on('click', function() {
            $(this).find('.rotate-icon').toggleClass('rotate');
        });

        $('.card-header').on('click', function() {
            // Close all other accordions and remove their background color and rotation
            $('.card-header').not(this).removeClass('accordion-open');
            $('.card-header').not(this).find('.rotate-icon').removeClass('rotate');

            // Toggle background color for the clicked accordion
            $(this).toggleClass('accordion-open');
        });
    });



    function syncName() {
        const nameInput = document.getElementById("name").value;
        const nameDisplay = document.getElementById("nameDisplay");
        nameDisplay.textContent = nameInput;
    }

    document.querySelectorAll('button[type="submit"]').forEach(button => {
    button.addEventListener('click', function(event) {
        const partTimeCheckbox = document.getElementById('partTime');
        const fullTimeCheckbox = document.getElementById('fullTime');
        const jobCategory = document.getElementById('jobCategory').value;

        // Get the job role from the button name
        const selectedButton = event.target.name;

        // Check if at least one checkbox is selected
        if (!partTimeCheckbox.checked && !fullTimeCheckbox.checked) {
            event.preventDefault(); // Prevent form submission
            alert('Please select at least one job type.');
            return;
        }

        // Check if the selected job button matches the chosen job category
        if ((jobCategory === "Web Development" && !["frontend", "backend", "fullstack"].includes(selectedButton)) ||
            (jobCategory === "Game Development" && !["gameplay", "level", "artist"].includes(selectedButton)) ||
            (jobCategory === "Machine Learning" && !["mlengineer", "datascientist", "airesearcher"].includes(selectedButton))) {
            event.preventDefault(); // Prevent form submission
            alert('Selected job button does not match the chosen job category.');
        }
    });
});

