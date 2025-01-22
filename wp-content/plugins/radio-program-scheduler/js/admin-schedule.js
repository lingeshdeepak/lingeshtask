jQuery(document).ready(function ($) {
    $('#post').on('submit', function (e) {
        let hasErrors = false; // Initialize error tracking

        // Collect rps_schedule data as an associative array
        const rps_schedule = {};
        $('input[name^="rps_schedule"]').each(function () {
            const match = $(this).attr('name').match(/\[([^\]]+)\]/); // Match the day inside brackets
            if (match && match[1]) {
                const day = match[1]; // Extract the day (e.g., "Mon")
                const time = $(this).val(); // Get the time value
                rps_schedule[day] = time; // Build the associative array
            }
        });

        // Prepare data for AJAX validation
        const scheduleData = {
            action: 'rps_validate_schedule',
            post_ID: $('#post_ID').val(),
            rps_schedule: rps_schedule,
            rps_schedule_start_date: $('#rps_schedule_start_date').val(),
            rps_schedule_end_date: $('#rps_schedule_end_date').val(),
            rps_schedule_nonce: $('#rps_schedule_nonce').val(),
        };

        // Send AJAX request
        $.post(rpsAjax.ajax_url, scheduleData, function (response) {
            $('#rps-error-messages').empty(); // Clear previous errors
            $('input, textarea').removeClass('error-field'); // Remove previous error highlighting

            if (!response.success) {
                hasErrors = true; // Flag that there are validation errors
                let firstErrorField = null; // To store the first error field to focus

                // Process errors
                response.data.errors.forEach(function (error) {
                    $('#rps-error-messages').append('<p style="color: red;">' + error + '</p>');

                    if (error.includes('Start Date')) {
                        const field = $('#rps_schedule_start_date');
                        field.addClass('error-field');
                        if (!firstErrorField) firstErrorField = field;
                    }
                    if (error.includes('End Date')) {
                        const field = $('#rps_schedule_end_date');
                        field.addClass('error-field');
                        if (!firstErrorField) firstErrorField = field;
                    }
                    if (error.includes('broadcast time')) {
                        $('input[name^="rps_schedule"]').each(function () {
                            $(this).addClass('error-field');
                            if (!firstErrorField) firstErrorField = $(this);
                        });
                    }
                });

                // Focus on the first invalid field
                if (firstErrorField) {
                    firstErrorField.focus();
                }
            } else {
                $('#post')[0].submit(); // Submit the form if no errors
            }
        });

        if (hasErrors) {
            e.preventDefault(); // Prevent form submission if errors exist
        }
    });
});
