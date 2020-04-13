<select name="month" style="float: right" id="monthOrder">
    <option value="1"> Jan </option>
    <option value="2"> Feb </option>
    <option value="3"> March </option>
    <option value="4"> April </option>
    <option value="5"> May </option>
    <option value="6"> June </option>
    <option value="7"> July </option>
    <option value="8"> Aug </option>
    <option value="9"> Sept </option>
    <option value="10"> Oct </option>
    <option value="11"> Nov </option>
    <option value="12"> Dec </option>
</select>
<input type="hidden" id="individualsOrder" value="{{$dataset['individualsOrder']}}">
<input type="hidden" id="corporatesOrder" value="{{$dataset['corporatesOrder']}}">
<canvas id="pieOrders" style="width: 100%;"></canvas>
<script>
    $(function () {

    function randomScalingFactor() {
        return Math.floor(Math.random() * 100)
    }
    window.chartColors = {
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
    };
    var configOrders = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    $('#individualsOrder').val() ,
                    $('#corporatesOrder').val()
                ],
                backgroundColor: [
                    window.chartColors.yellow,
                    window.chartColors.green
                ],
                label: 'Dataset 1'
            }],
            labels: [
                'Individuals',
                'Corporates'

            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'By Type'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };
    var html_element_orders = document.getElementById('pieOrders').getContext('2d');
    var totalOrdersChart = new Chart(html_element_orders, configOrders);

        $('#monthOrder').on('change', function(){
            var monthValue = $(this).val();

            $.ajax({
                url: "/api/v1/admin/statistics/orders/"+ monthValue,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(result) {
                    $('#individualsOrder').val(result.individualsOrder);
                    $('#corporatesOrder').val(result.corporatesOrder);

                    totalOrdersChart.data.datasets[0].data[0] = result.individualsOrder;
                    totalOrdersChart.data.datasets[0].data[1] = result.corporatesOrder;

                    totalOrdersChart.update();
                }
            });
        });
});

</script>
