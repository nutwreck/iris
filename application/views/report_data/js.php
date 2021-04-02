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
                format: 'YYYY/MM/DD'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
            /* ,
            function(start, end) {
                $('#from').val(start.format('YYYY-MM-DD'));
                $('#to').val(end.format('YYYY-MM-DD'));
            } */
        });

        var region_name = document.getElementById("region_name").value;
        if( region_name == "-1" ) {
            document.getElementById("exportexcel").disabled = true;
        }
    });
</script>

<script type="text/javascript">
    function export_excel() {
        var a = document.getElementById("typebutton").value = 2; //1 Submit 2 Export Excel
        validate_searchform();
    }

    function open_export(){
        var region_name = document.getElementById("region_name").value;
        if( region_name == "-1" ) {
            document.getElementById("exportexcel").disabled = true;
        } else {
            document.getElementById("exportexcel").disabled = false;
        }
    }
</script>

<script>
    function validate_searchform(){
        if( document.formsearch.region_name.value == "-1" ) {
            document.getElementById('region_name_er').innerHTML = 'Region Wajib Dipilih!';
            document.formsearch.region_name.focus();
            return false;
        }
        return( true );
    }
</script>