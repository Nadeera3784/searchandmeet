<div x-data="timeZoneHandler()" x-init="init()">
    <span x-text="getLocalTime(dateTime, null, format)"></span>
</div>

<script>

    function timeZoneHandler() {
        return {
            dateTime: '{{$date_time}}',
            format: '{{$format}}',
            init(){

            },
            getLocalTime(dateTime, timezone, format = 'YYYY-MM-DD HH:mm:ss') {
                return moment.utc(dateTime).local().format(format);
            },
        }
    }
</script>