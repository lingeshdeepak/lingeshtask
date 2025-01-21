jQuery(document).ready(function ($) {
    let week = 0;

    function loadSchedule() {
        $.post(rps_ajax.ajax_url, { action: 'rps_get_schedule', week }, function (response) {
            $('#schedule-content').html(response.map(program => `
                <div>
                    <h3>${program.name}</h3>
                    <img src="${program.thumbnail}" alt="${program.name}">
                    <p>${JSON.stringify(program.schedule)}</p>
                </div>
            `).join(''));
        });
    }

    $('#prev-week').click(() => { week--; loadSchedule(); });
    $('#next-week').click(() => { week++; loadSchedule(); });

    loadSchedule();
});
