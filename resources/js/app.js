class Tracker {
    constructor() {
        this.initStartTrackerButtonListener();
        this.initChrono();
    }

    initStartTrackerButtonListener() {
        $('#start-tracker').on('click', event => {
            let url = $('meta[name="start-tracker-url"]').attr('content');

            let data = {
                description: $('#trackerModal #description').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            }

            $.post(url, data).then(response => {
                console.log(response);
            });
        });
    }

    initChrono() {
        $('#tracker-timer').html(this._getTime());

        setInterval(() => {
            $('#tracker-timer').html(this._getTime());
        }, 1000);
    }

    _getTime() {
        let dateStart = $('#last-tracker-date').val();

        var now  = moment().format('DD/MM/YYYY HH:mm:ss');
        var then = moment(dateStart).format('DD/MM/YYYY HH:mm:ss');

        var ms = moment(now,"DD/MM/YYYY HH:mm:ss").diff(moment(then,"DD/MM/YYYY HH:mm:ss"));
        var d = moment.duration(ms);
        var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");

        return s;
    }
}

new Tracker();