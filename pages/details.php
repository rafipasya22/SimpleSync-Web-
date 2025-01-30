<?php

@include '../config.php';
session_start();

if(isset($_SESSION['Email'])) {
    $Email = $_SESSION['Email']; 
} else {
    header("Location: Edit.php?error=Email is not set in the session");

}

if(!isset($_SESSION['NamaDepan'])){
    header('location:../Login_Signup/Login.php');
}
$Query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$Email'");
$data = mysqli_fetch_array($Query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- My CSS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

	<link rel="stylesheet" href="../assets/css/style.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

	<title>Details</title>
</head>
<body>


	<!-- SIDEBAR -->
<section id="sidebar" class="hide">
    <a href="#" class="brand">
    <i class='bx bxl-stripe'></i>
    <span class="text-dark" id="teksbpm">Simple</span><span style="color: var(--red)">Sync</span>
    </a>
    
    <ul class="side-menu top">
        <li id="dashboard-menu">
            <a href="./home.php">
                <i class='bx bx-arrow-back' ></i>
                <span class="text">Back</span>
            </a>
        </li>
        
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <a href="#" id="Logout" class="logout">
                <i class='bx bx-log-out' ></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
        <button type="button" onclick="window.location.href='./details.php';" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="theme-toggle">
          <label class="form-check-label" for="theme-toggle">Dark Mode</label>
        </div>
      </div>
      <div class="modal-footer">
        <button onclick="window.location.href='./details.php';" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

	<!-- SIDEBAR -->



	<!-- CONTENT -->
<section id="content">
		<!-- NAVBAR -->
	<nav class="d-flex justify-content-between align-items-center p-3 bg-white">
    <!-- Bagian kiri -->
		<i class="bx bx-menu fs-3"></i>

		<!-- Bagian kanan -->
		<div class="d-flex align-items-center">
			
			<div class="text-end me-3">
				<p class="mb-0">Hello, <?php echo $_SESSION['NamaDepan']; ?></p>
				<small style="font-size: 0.8rem; color: #6c757d;">
					<?php 
					$query = "SELECT DATE_FORMAT(NOW(), '%W, %e %M %Y') AS formatted_date";
					$result = $conn->query($query);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $row['formatted_date'];
					} else {
						echo "Tanggal tidak tersedia";
					}
					?>
				</small>
			</div>
			<?php
				$carifoto = "SELECT Foto_Profil FROM users WHERE first_name = '$_SESSION[NamaDepan]'";
				$fotoprofil = mysqli_query($conn, $carifoto);
				if (mysqli_num_rows($fotoprofil) > 0) {
					while ($user = mysqli_fetch_assoc($fotoprofil)) {
						if ($user['Foto_Profil'] !== NULL) { ?>
							<img class="rounded-circle object-fit-cover" src="../uploads/<?=$user['Foto_Profil']?>" width="40" height="40">
						<?php  
						} else { ?>
							<img class="rounded-circle object-fit-cover" src="../assets/img/def.jpg" width="40" height="40">  
						<?php 
						}
					}
				} else { ?>
					<img class="rounded-circle object-fit-cover" src="../assets/img/def.jpg" width="40" height="40">
				<?php } ?>
		</div>

	</nav>

		<!-- NAVBAR -->

		<!-- MAIN -->
	<main id="main-content">
		<div class="head-title">
			<div class="left">
				<h1>Details</h1>
				<ul class="breadcrumb">
					<li>
						<a href="./home.php">Home</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="./details.php">Details</a>
					</li>
				</ul>
			</div>
		</div>

		<section class="chart">
			<div class="container" id="analytics">
				<div class="row">
					<div class="col-md-12">
						<div class="row ">
							<div class="mb-3 " id="container-dd">
							</div>

							<div id="heart-container" class="container-event position-relative border-radius-xl overflow-hidden chart-container">
								<div class="tab-content tab-space">
									<div class="tab-pane active" id="preview-btn-color">
									<div id="events-container">
										<div class="row justify-content-between align-items-center py-2">
										<canvas id="heart" class="chart-canvas"></canvas>
										</div>
									</div>
									</div>
								</div>
							</div>

                            <div id="temp-container" class="container-event position-relative border-radius-xl overflow-hidden chart-container">
								<div class="tab-content tab-space">
									<div class="tab-pane active" id="preview-btn-color">
									<div id="events-container">
										<div class="row justify-content-between align-items-center py-2">
										<canvas id="tempchart" class="chart-canvas"></canvas>
										</div>
									</div>
									</div>
								</div>
							</div>

                            <div id="avg-container" class="container-event position-relative border-radius-xl overflow-hidden chart-container">
								<div class="tab-content tab-space">
									<div class="tab-pane active" id="preview-btn-color">
									<div id="events-container">
										<div class="row justify-content-between align-items-center py-2">
										<canvas id="myChart" class="chart-canvas"></canvas>
										</div>
									</div>
									</div>
								</div>
							</div>


     					</div>
    				</div>
  				</div>
			</div>
		</section>
		
		<section class="pt-6 position-relative">  
			<div class="position-relative border-radius-xl overflow-hidden me-3" id="filter-card">
				<div class="container-fall">
					<div class="fs-6 text-muted mb-2">Stress Level: 
					</div>
					<div class="fs-4 fw-bold text-dark mb-3" id="teksbpm">
					High!
					</div>
					<div class="fs-9 text-muted">Heart Rate Variability: </div>
				</div>
			</div>

		</section>

	</main>
</section>
	

	<script src="../assets/js/script.js"></script>
	
	<script>
    fetch('../getavg.php')
    .then(response => response.json())
    .then(data => {
        const timestamps = data.map(entry => entry.time_interval);
        const heartRates = data.map(entry => entry.avg_heart_rate);

        const ctx = document.getElementById('myChart').getContext('2d');
        const sleepChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timestamps,
                datasets: [{
                    label: 'Heart Rate Average',
                    data: heartRates,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,

                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Heart Rate Average'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));

</script>

<script>
    fetch('../getdata.php')
    .then(response => response.json())
    .then(data => {
        const timestamps = data.map(entry => entry.time_only);
        const heartRates = data.map(entry => entry.heart_rate);
        const spo2 = data.map(entry => entry.spo2);

        const ctx = document.getElementById('heart').getContext('2d');
        const sleepChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timestamps,
                datasets: [
                    {
                        label: 'SpO2',
                        data: spo2,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 0
                    },
                    {
                        label: 'Heart Rate', 
                        data: heartRates,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: false,
                            text: 'Timestamp'
                        },
                        grid: {
                            display: false // Removes grid lines on the x-axis
                        },
						ticks: {
                            display: false // Hides x-axis labels
                        }
                    },
                    y: {
                        title: {
                            display: false,
                            text: 'Heart Rate'
                        },
                        beginAtZero: true,
                        grid: {
                            display: false // Removes grid lines on the y-axis
                        },
						
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>


<script>
    fetch('../gettemp.php')
    .then(response => response.json())
    .then(data => {
        const timestamps = data.map(entry => entry.time_interval);
        const temp = data.map(entry => entry.avg_temp);

        const ctx = document.getElementById('tempchart').getContext('2d');
        const sleepChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timestamps,
                datasets: [{
                    label: 'Body Temperature',
                    data: temp,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,

                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        title: {
                            display: false,
                            text: 'Heart Rate'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));

</script>

<script>
    fetch('../getHeartRate.php')
    .then(response => response.json())
    .then(data => {
        const avgHeartRate = data.heart_rate;

        const ctx = document.getElementById('bpm').getContext('2d');
        const sleepChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [avgHeartRate, 150 - avgHeartRate], 
                    backgroundColor: ['rgba(75, 192, 192, 0.8)', 'rgba(211, 211, 211, 0.5)'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '80%',
                plugins: {
                    legend: {
                        display: false 
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            },
            plugins: [{
                id: 'custom-text',
                beforeDraw: (chart) => {
                    const { width } = chart;
                    const { height } = chart;
                    const { ctx } = chart;

                    ctx.font = 'bold 30px Arial';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#000000'; 
                        const text = `${Math.round(avgHeartRate)}`;
                        ctx.fillText(text, width / 2, height / 2);
                        ctx.font = 'bold 16px Arial';
                        ctx.fillStyle = '#000000';
                        ctx.fillText('BPM', width / 2, height / 2 + 25);

           
                    ctx.restore();
                }
            }]
        });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>
<script>
    fetch('../getHeartRate.php')
    .then(response => response.json())
    .then(data => {
        const temp = data.temperature;

        const ctx = document.getElementById('temp').getContext('2d');
        const sleepChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [temp, 150 - temp], 
                    backgroundColor: ['rgba(75, 192, 192, 0.8)', 'rgba(211, 211, 211, 0.5)'], 
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '80%', 
                plugins: {
                    legend: {
                        display: false 
                    },
                    tooltip: {
                        enabled: false 
                    }
                }
            },
            plugins: [{
                id: 'custom-text',
                beforeDraw: (chart) => {
                    const { width } = chart;
                    const { height } = chart;
                    const { ctx } = chart;

                    ctx.font = 'bold 30px Arial';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#000000'; 

                        const text = `${Math.round(temp)}°`;
                        ctx.fillText(text, width / 2, height / 2);

                        ctx.font = 'bold 16px Arial';
                        ctx.fillStyle = '#000000'; 
                        ctx.fillText('Celcius', width / 2, height / 2 + 25);

           
                    ctx.restore();
                }
            }]
        });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
  const dropdownItems = document.querySelectorAll(".ddcanvas");
  const selectedEventText = document.getElementById("selectedEventText");

  dropdownItems.forEach((item) => {
    item.addEventListener("click", function () {
      // Dapatkan nilai data-text dan data-chart dari item yang diklik
      const text = this.getAttribute("data-text");
      const chartId = this.getAttribute("data-chart");

      // Perbarui teks dropdown untuk menunjukkan pilihan saat ini
      selectedEventText.textContent = text;

      // Sembunyikan semua chart
      const chartContainers = document.querySelectorAll(".chart-container");
      chartContainers.forEach((container) => {
        container.classList.add("d-none");
      });

      // Tampilkan chart yang sesuai dengan ID chart
      const selectedChartContainer = document.getElementById(chartId + "-container");
      if (selectedChartContainer) {
        selectedChartContainer.classList.remove("d-none");
      }
    });
  });
});



</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.getElementById("Logout").addEventListener("click", function(event){
        event.preventDefault(); // Menghentikan perilaku default dari tautan

        swal({
            title: "Logout Successful",
            text: "Directing to Login Page",
            icon: "success",
            button: "Ok",
        }).then((value) => {
            if (value) {
                window.location.href = "../Logout.php"; // Lakukan logout saat tombol "Ok" diklik
            }
        });
    });
</script>
</body>
</html>