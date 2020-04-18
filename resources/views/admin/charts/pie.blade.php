<select name="month" style="float: right" id="month">
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
<input type="hidden" id="individuals" value="{{$dataset['individuals']}}">
<input type="hidden" id="corporates" value="{{$dataset['corporates']}}">
<canvas id="pie" style="width: 100%;"></canvas>
<script>
    $(function () {

    function randomScalingFactor() {
        return Math.floor(Math.random() * 100)
    }
    window.chartColors = {
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
    };
    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    $('#individuals').val() ,
                    $('#corporates').val()
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
    var html_element = document.getElementById('pie').getContext('2d');
    var totalSalesChart = new Chart(html_element, config);

        $('#month').on('change', function(){
            var monthValue = $(this).val();

            $.ajax({
                url: "/api/v1/admin/statistics/sales/"+ monthValue,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(result) {
                    $('#individuals').val(result.individuals);
                    $('#corporates').val(result.corporates);

                    totalSalesChart.data.datasets[0].data[0] = result.individuals;
                    totalSalesChart.data.datasets[0].data[1] = result.corporates;

                    totalSalesChart.update();
                }
            });
        });
});

</script>
