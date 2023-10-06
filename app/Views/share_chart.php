<?= view('app_global/nav'); ?>
<?= view('app_global/board_header'); ?>
 
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="p-5">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($data_chart['labels']);?>,
      datasets: <?php echo json_encode($data_chart['datasets']);?>,
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>