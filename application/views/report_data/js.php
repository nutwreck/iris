<!-- Select Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- Daterangepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="daterange"]').daterangepicker({
            minYear: 1980,
            maxDate: moment().startOf('day'),
            showWeek: true,
            changeYear: true,
            showDropdowns: true,
            opens: 'center',
            drops: 'down',
            timePicker: false,
            startDate: moment().subtract(6, 'days'),
            endDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            function(start, end) {
                console.log("Callback has been called!");
                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('#to').val(start.format('YYYY-MM-DD'));
                $('#from').val(end.format('YYYY-MM-DD'));
            }
        });
    });
</script>

<script>
    function search_data(){
        
    }
</script>