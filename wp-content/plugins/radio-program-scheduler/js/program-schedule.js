jQuery(document).ready(function ($) {
    let weekOffset = 0;

    function loadSchedule() {
        $.ajax({
            url: programScheduleAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_program_schedule',
                week: weekOffset,
            },
            success: function (response) {
                const schedule = response.schedule;
                const dates = response.dates;

                let html = '<table class="week-view-calendar">';
                html += '<thead><tr>';

                // Add days with dates as table headers
                for (let day in schedule) {
                    html += `<th>${day}<br><span class="date">(${dates[day]})</span></th>`;
                }

                html += '</tr></thead><tbody><tr>';

                // Add program schedules for each day
                for (let day in schedule) {
                    html += '<td>';
                    if (schedule[day].length) {
                        schedule[day].forEach(program => {
                            html += `
                                <div class="program">
                                    <img src="${program.thumbnail}" alt="${program.name}" style="width: 50px; height: 50px;">
                                    <p><strong>${program.name}</strong><br>${program.time}</p>
                                </div>`;
                        });
                    } else {
                        html += '<p>No programs scheduled</p>';
                    }
                    html += '</td>';
                }

                html += '</tr></tbody></table>';
                $('#schedule-content').html(html);
            },
            error: function () {
                $('#schedule-content').html('<p>Error loading schedule. Please try again.</p>');
            },
        });
    }

    $('#prev-week').click(() => {
        weekOffset--;
        loadSchedule();
    });

    $('#next-week').click(() => {
        weekOffset++;
        loadSchedule();
    });

    // Load the current week on page load
    loadSchedule();
});
