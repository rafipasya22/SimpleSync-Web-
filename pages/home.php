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
	

	<title>Home Dashboard</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar" class="hide">
    <a href="#" class="brand">
		<i class='bx bxl-stripe'></i>
        <span class="text-dark" id="teksbpm">Simple</span><span style="color: var(--red)">Sync</span>
    </a>
    
    <ul class="side-menu top">
        <li class="active" id="dashboard-menu">
            <a href="#">
				<i class='bx bx-home' ></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li id="medicine-menu">
            <a href="#">
				<i class='bx bxs-capsule' ></i>
                <span class="text">Meds</span>
            </a>
        </li>
        <li id="profile-menu">
            <a href="#">
				<i class='bx bx-user' ></i>
                <span class="text">Profile</span>
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
        <button type="button" onclick="window.location.href='./home.php';" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="theme-toggle">
          <label class="form-check-label" for="theme-toggle">Dark Mode</label>
        </div>
      </div>
      <div class="modal-footer">
        <button onclick="window.location.href='./home.php';" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
				<p class="mb-0" id="teksbpm">Hello, <?php echo $_SESSION['NamaDepan']; ?></p>
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
				<h1>Dashboard</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="#">Home</a>
					</li>
				</ul>
			</div>
		</div>

		<section class="chart">
			<div class="container" id="analytics">
				<div class="row">

					<div class="col-lg-4 col-md-12 mb-4" id="hehe">
						<div class="position-relative border-radius-xl overflow-hidden me-3 mt-3" id="filter-card">
							<div class="container-fall">
							<div class="fs-6 text-muted mb-2">Last Updated: <br>
								<?php
								$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
								$result = mysqli_query($conn, $query);
								if (mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									echo $row["latest"];
								} else {
									echo json_encode(['error' => 'No data found']);
								}
								?>
							</div>
							<div class="fs-4 text-dark mb-3 d-flex justify-content-between align-items-center">
								<span class="fw-bold fs-2" id="teksbpm">
									<?php
									$query = "SELECT temperature FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row['temperature'];
									} else {
										echo json_encode(['error' => 'No data found']);
									}
									?>
									°C
								</span>
								<i id="icon-container" class="rounded-circle bx bxs-thermometer fs-2"></i>
							</div>

							<div class="fs-9 text-muted">Body Temperature</div>
							</div>
						</div>
						<div class="row">
							<div class="container d-flex justify-content-start">
							<!-- Vital Data Cards -->
							<div class="border-radius-xl overflow-hidden me-3" id="filter-card">
								<div class="container-vital">
								<div class="fs-6 text-muted mb-2">Last Updated: <br>
									<?php
									$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["latest"];
									} else {
										echo json_encode(['error' => 'No data found']);
									}
									?>
								</div>
								<div class="fs-4 text-dark mb-3" id="teksbpm">
									<span class="fw-bold justify-content-between fs-2" id="teksbpm">
									<?php
										$query = "SELECT spo2 FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
										$result = mysqli_query($conn, $query);
										if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["spo2"];
										} else {
										echo json_encode(['error' => 'No data found']);
										}
									?>
									</span>
									%
									<i id="icon-container" class="rounded-circle bx bx-droplet fs-2"></i>
								</div>
								<div class="fs-9 text-muted">Blood Oxygen Level</div>
								</div>
							</div>

							<div class="border-radius-xl overflow-hidden me-3" id="filter-card">
								<div class="container-vital">
								<div class="fs-6 text-muted mb-2">Last Updated: <br>
									<?php
									$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["latest"];
									} else {
										echo json_encode(['error' => 'No data found']);
									}
									?>
								</div>
								<div class="fs-4 justify-content-between text-dark mb-3" id="teksbpm">
									<span class="fw-bold fs-2" id="teksbpm">
									<?php
										$query = "SELECT heart_rate FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
										$result = mysqli_query($conn, $query);
										if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["heart_rate"];
										} else {
										echo json_encode(['error' => 'No data found']);
										}
									?>
									</span>
									BPM
									<i id="icon-container" class="rounded-circle bx bx-pulse fs-2"></i>
								</div>
								<div class="fs-9 text-muted">Heart Rate</div>
								</div>
							</div>

							</div>
						</div>

						<div class="position-relative border-radius-xl overflow-hidden me-3 mt-3" id="filter-card">
							<div class="container-fall">
							<div class="fs-6 text-muted mb-2">Last Updated: <br>
								<?php
								$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
								$result = mysqli_query($conn, $query);
								if (mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									echo $row["latest"];
								} else {
									echo json_encode(['error' => 'No data found']);
								}
								?>
							</div>
							<div class="fs-4 text-dark mb-3">
								<span class="fw-bold fs-2" id="teksbpm">
								<?php
									$query = "SELECT jatuh FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									if($row["jatuh"] = 1) {
										echo "Fall Detected!";
									} else {
										echo "Jatuh Belum Terdeteksi";
									}
									} else {
									echo json_encode(['error' => 'No data found']);
									}
								?>
								</span>
							</div>
							<div class="fs-9 text-muted">Fall Detection</div>
							</div>
						</div>
					</div>
					<!-- Kolom 8 untuk chart, responsif untuk layar besar dan menengah -->
					<div class="col-lg-8 col-md-12">
						<div class="row ">
							<div class="mb-3 " id="container-dd">
							</div>

							<div id="heart-container" class="container-event position-relative border-radius-xl overflow-hidden chart-container">
								<div class="tab-content tab-space">
									<div class="tab-pane active" id="preview-btn-color">
									<div id="events-container">
										<div class="row justify-content-between align-items-center py-2">
										<!-- Canvas for the chart -->
										<canvas id="heart" class="chart-canvas"></canvas>
										</div>
										<!-- Button Details -->
										<div class="d-flex justify-content-end mt-1 mb-4">
										<button onclick="window.location.href='./details.php';"  class="btn btn-primary home" id="details-button">See Details</button>
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
		document.addEventListener('DOMContentLoaded', function () {
			// Get all sidebar menu items
			const sidebarItems = document.querySelectorAll('.side-menu li');
			const mainContent = document.getElementById('main-content');

			// Define a function to change the main content based on clicked menu item
			function updateMainContent(content, renderChart = false) {
				mainContent.innerHTML = content;
				if (renderChart) {
					renderHeartRateChart();  // Render chart after content is updated
				}
			}

			// Function to render heart rate chart
			function renderHeartRateChart() {
				fetch('../getdata.php')
					.then(response => response.json())
					.then(data => {
						const timestamps = data.map(entry => entry.time_only);
						const heartRates = data.map(entry => entry.heart_rate);
						const spo2 = data.map(entry => entry.spo2);

						const ctx = document.getElementById('heart').getContext('2d');
						new Chart(ctx, {
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
											display: false
										},
										ticks: {
											display: false
										}
									},
									y: {
										title: {
											display: false,
											text: 'Heart Rate'
										},
										beginAtZero: true,
										grid: {
											display: false
										},
									}
								}
							}
						});
					})
					.catch(error => console.error('Error fetching data:', error));
			}

			// Attach event listeners to sidebar menu items
			sidebarItems.forEach(item => {
				item.addEventListener('click', function () {
					// Remove active class from all items
					sidebarItems.forEach(item => item.classList.remove('active'));
					
					// Add active class to the clicked item
					item.classList.add('active');
					
					// Switch the content based on the clicked menu
					switch (item.id) {
						case 'dashboard-menu':
							// Update content for Dashboard and render the chart
							updateMainContent(`
								<div class="head-title">
                            <div class="left">
                                <h1>Dashboard</h1>
                                <ul class="breadcrumb">
                                    <li>
                                        <a href="#">Dashboard</a>
                                    </li>
                                    <li><i class='bx bx-chevron-right' ></i></li>
                                    <li>
                                        <a class="active" href="#">Home</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <section class="chart">
			<div class="container" id="analytics">
				<div class="row">

					<div class="col-lg-4 col-md-12 mb-4" id="hehe">
						<div class="position-relative border-radius-xl overflow-hidden me-3 mt-3" id="filter-card">
							<div class="container-fall">
							<div class="fs-6 text-muted mb-2">Last Updated: <br>
								<?php
								$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
								$result = mysqli_query($conn, $query);
								if (mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									echo $row["latest"];
								} else {
									echo json_encode(['error' => 'No data found']);
								}
								?>
							</div>
							<div class="fs-4 text-dark mb-3 d-flex justify-content-between align-items-center">
								<span class="fw-bold fs-2" id="teksbpm">
									<?php
									$query = "SELECT temperature FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row['temperature'];
									} else {
										echo json_encode(['error' => 'No data found']);
									}
									?>
									°C
								</span>
								<i id="icon-container" class="rounded-circle bx bxs-thermometer fs-2"></i>
							</div>

							<div class="fs-9 text-muted">Body Temperature</div>
							</div>
						</div>
						<div class="row">
							<div class="container d-flex justify-content-start">
							<!-- Vital Data Cards -->
							<div class="border-radius-xl overflow-hidden me-3" id="filter-card">
								<div class="container-vital">
								<div class="fs-6 text-muted mb-2">Last Updated: <br>
									<?php
									$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["latest"];
									} else {
										echo json_encode(['error' => 'No data found']);
									}
									?>
								</div>
								<div class="fs-4 text-dark mb-3" id="teksbpm">
									<span class="fw-bold justify-content-between fs-2" id="teksbpm">
									<?php
										$query = "SELECT spo2 FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
										$result = mysqli_query($conn, $query);
										if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["spo2"];
										} else {
										echo json_encode(['error' => 'No data found']);
										}
									?>
									</span>
									%
									<i id="icon-container" class="rounded-circle bx bx-droplet fs-2"></i>
								</div>
								<div class="fs-9 text-muted">Blood Oxygen Level</div>
								</div>
							</div>

							<div class="border-radius-xl overflow-hidden me-3" id="filter-card">
								<div class="container-vital">
								<div class="fs-6 text-muted mb-2">Last Updated: <br>
									<?php
									$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["latest"];
									} else {
										echo json_encode(['error' => 'No data found']);
									}
									?>
								</div>
								<div class="fs-4 justify-content-between text-dark mb-3" id="teksbpm">
									<span class="fw-bold fs-2" id="teksbpm">
									<?php
										$query = "SELECT heart_rate FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
										$result = mysqli_query($conn, $query);
										if (mysqli_num_rows($result) > 0) {
										$row = mysqli_fetch_assoc($result);
										echo $row["heart_rate"];
										} else {
										echo json_encode(['error' => 'No data found']);
										}
									?>
									</span>
									BPM
									<i id="icon-container" class="rounded-circle bx bx-pulse fs-2"></i>
								</div>
								<div class="fs-9 text-muted">Heart Rate</div>
								</div>
							</div>

							</div>
						</div>

						<div class="position-relative border-radius-xl overflow-hidden me-3 mt-3" id="filter-card">
							<div class="container-fall">
							<div class="fs-6 text-muted mb-2">Last Updated: <br>
								<?php
								$query = "SELECT TIME(timestamp) as latest FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
								$result = mysqli_query($conn, $query);
								if (mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									echo $row["latest"];
								} else {
									echo json_encode(['error' => 'No data found']);
								}
								?>
							</div>
							<div class="fs-4 text-dark mb-3">
								<span class="fw-bold fs-2" id="teksbpm">
								<?php
									$query = "SELECT jatuh FROM sensor_readings ORDER BY timestamp DESC LIMIT 1;";
									$result = mysqli_query($conn, $query);
									if (mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									if($row["jatuh"] = 1) {
										echo "Fall Detected!";
									} else {
										echo "Jatuh Belum Terdeteksi";
									}
									} else {
									echo json_encode(['error' => 'No data found']);
									}
								?>
								</span>
							</div>
							<div class="fs-9 text-muted">Fall Detection</div>
							</div>
						</div>
					</div>
					<!-- Kolom 8 untuk chart, responsif untuk layar besar dan menengah -->
					<div class="col-lg-8 col-md-12">
						<div class="row ">
							<div class="mb-3 " id="container-dd">
							</div>

							<div id="heart-container" class="container-event position-relative border-radius-xl overflow-hidden chart-container">
								<div class="tab-content tab-space">
									<div class="tab-pane active" id="preview-btn-color">
									<div id="events-container">
										<div class="row justify-content-between align-items-center py-2">
										<!-- Canvas for the chart -->
										<canvas id="heart" class="chart-canvas"></canvas>
										</div>
										<!-- Button Details -->
										<div class="d-flex justify-content-end mt-1 mb-4">
										<button onclick="window.location.href='./details.php';"  class="btn btn-primary home" id="details-button">See Details</button>
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
							`, true);  // Render chart after content
							break;

						case 'medicine-menu':
							updateMainContent(`
								<div class="head-title">
									<div class="left">
										<h1>Medicine</h1>
										<ul class="breadcrumb">
											<li>
												<a href="#">Dashboard</a>
											</li>
											<li><i class='bx bx-chevron-right' ></i></li>
											<li>
												<a class="active" href="#">Medicine</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="text-start fs-2 fw-bold mb-3" id="teksbpm">
									Closest Medicine
								</div>

								<div class="position-relative border-radius-xl overflow-hidden me-3 mt-3" id="filter-card">
									<div class="container-fall" id="meds">
										<div class="fs-6 text-light mb-2">
											Closest Medicine
										</div>
										<div class="fs-4 text-light mb-3">
											<span class="fw-bold fs-2">
											<?php
												date_default_timezone_set('Asia/Jakarta'); 
												$query = "SELECT * FROM reminders WHERE meds_for = '$_SESSION[Email]'";
												$result = mysqli_query($conn, $query);
												
												
												$closestMedicationName = null;
												$closestMedicationTime = null;
												$closestMedicationTimeDiff = null;
												
												if (mysqli_num_rows($result) > 0) {
													$smallestTimeDifference = PHP_INT_MAX; 
													while ($row = mysqli_fetch_assoc($result)) {
														$db_time = $row['waktu']; 
														$current_time = date("Y-m-d H:i:s"); 
												
														$time_difference = strtotime($db_time) - strtotime($current_time);
												
														$hours = floor(abs($time_difference) / 3600);
														$minutes = floor((abs($time_difference) % 3600) / 60);
												
														$time_difference_str = "";
														if ($time_difference > 0) {
															$time_difference_str = "$hours hours and $minutes minutes";
														} elseif ($time_difference < 0) {
															$time_difference_str = "$hours hours and $minutes minutes ago";
														} else {
															$time_difference_str = "Now";
														}
												
														if ($time_difference > 0 && $time_difference < $smallestTimeDifference) {
															$smallestTimeDifference = $time_difference;
															$closestMedicationName = $row['nama_obat']; 
															$closestMedicationTime = $row['waktu']; 
															$closestMedicationTimeDiff = $time_difference_str; 
														}
													}
												
													if ($closestMedicationName) {
														echo "Take $closestMedicationName in $closestMedicationTimeDiff";
													} else {
														echo "No Medications";
													}
												}
											?>
											</span>
										</div>
										<div class="d-flex justify-content-between align-items-center mt-1 mb-4">
											<div class="fs-9 text-light">Please Do Not Forget!</div>
											<button onclick="window.location.href='./addmeds.php';" class="btn btn-primary addmeds" id="details-button">Add Medicine</button>
										</div>
									</div>
								</div>


								<div class="text-start fs-2 fw-bold my-3" id="teksbpm">
									Medicine List
								</div>

								<section class="pt-6 position-relative">
									<?php
									// Query untuk mendapatkan data obat
									$query = "SELECT * FROM reminders WHERE meds_for = '$_SESSION[Email]'";
									$result = mysqli_query($conn, $query);

									// Periksa apakah ada data obat
									if (mysqli_num_rows($result) > 0) {
										while ($medicine = mysqli_fetch_assoc($result)) { ?>
											<div class="position-relative border-radius-xl overflow-hidden me-3" id="medicine-card">
												<div class="container-medicine">
													<div class="d-flex align-items-start justify-content-between">
														<div class="container-meds">
															<div class="d-flex align-items-start">
																<i id="icon-container" class="rounded-circle bx bxs-capsule fs-1 me-3"></i>
																<div>
																	<h5 class="mb-1" id="teksbpm"><?= $medicine['nama_obat']; ?></h5>
																	<p class="fs-6 text-muted">
																		Note: <?= $medicine['catatan']; ?> <br>
																		Time: <?= $medicine['waktu']; ?>
																	</p>
																</div>
															</div>
															<div>
																<button onclick="window.location.href='./editmeds.php?id=<?= $medicine['id']; ?>'" class="btn btn-sm btn-primary edit">Edit</button>
																<button onclick="window.location.href='../deletemeds.php?id=<?= $medicine['id']; ?>'" class="btn btn-sm btn-primary edit">Delete</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php }
									} else { ?>
										<div class="text-center text-muted">
											<p>No medicine data found.</p>
										</div>
									<?php } ?>
								</section>
							`, true); 
							break;

						case 'profile-menu':
							updateMainContent(`
								<div class="head-title">
									<div class="left">
										<h1>Profile</h1>
										<ul class="breadcrumb">
											<li>
												<a href="#">Dashboard</a>
											</li>
											<li><i class='bx bx-chevron-right' ></i></li>
											<li>
												<a class="active" href="#">Profile</a>
											</li>
										</ul>
									</div>
								</div>

								<section class="pt-6 position-relative">
									<div class="position-relative border-radius-xl overflow-hidden me-3" id="filter-card">
										<div class="container-fall">
										<div class="d-flex align-items-start justify-content-between">
											<!-- Left Section -->
											<div class="d-flex align-items-start">
											<?php
											$carifoto = "SELECT Foto_Profil FROM users WHERE first_name = '$_SESSION[NamaDepan]'";
											$fotoprofil = mysqli_query($conn, $carifoto);
											if (mysqli_num_rows($fotoprofil) > 0) {
												while ($user = mysqli_fetch_assoc($fotoprofil)) {
													if ($user['Foto_Profil'] !== NULL) { ?>
														<img class="rounded-circle object-fit-cover me-3" src="../uploads/<?=$user['Foto_Profil']?>" width="80" height=80">
													<?php  
													} else { ?>
														<img class="rounded-circle object-fit-cover me-3" src="../assets/img/def.jpg" width="80" height="80">  
													<?php 
													}
												}
											} else { ?>
												<img class="rounded-circle object-fit-cover me-3" src="../assets/img/def.jpg" width="80" height="80">
											<?php } ?>
											<div>
												<h5 class="mb-1" id="teksbpm"><?php echo $_SESSION['NamaDepan'] . ' ' . $_SESSION['NamaBelakang']; ?></h5>
												<p class="text-muted mb-1"><?php echo $_SESSION['Email']?></p>
												<div class="mt-3">
												<button onclick="window.location.href='./editprofile.php';" class="btn btn-primary edit btn-sm">Edit Profile</button>
												</div>
											</div>
											</div>
											<!-- Right Section -->
											<div class="text-end">
											<ul class="list-unstyled mb-3" id="teksbpm">
												<li><strong>Age:</strong> <?php 
													if ($data['age'] !== NULL) { 
														echo $data['age'];
													} else { 
														echo "Age Hasn't been set yet";
													} ?></li>
												<li><strong>Location:</strong> <?php 
													if ($data['location'] !== NULL) { 
														echo $data['location'];
													} else { 
														echo "Location Hasn't been set yet";
													} ?></li>
											</ul>
											<div class="d-flex justify-content-end gap-2">
												<a href="#" class="text-dark"><i class="fab fa-github"></i></a>
												<a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
												<a href="#" class="text-dark"><i class="fab fa-facebook"></i></a>
												<a href="#" class="text-dark"><i class="fab fa-linkedin"></i></a>
												<a href="#" class="text-dark"><i class="fab fa-dribbble"></i></a>
												<a href="#" class="text-dark"><i class="fas fa-thumbs-up"></i></a>
											</div>
											</div>
										</div>
										</div>
									</div>
								</section>

								<div class="text-start fs-2 fw-bold my-3" id="teksbpm">
									Health Analytics
								</div>

								<div class="col-lg-10 col-md-12">
									<div class="row ">
										<div class="mb-3 " id="container-dd">
										</div>

										<div id="heart-container" class="container-event position-relative border-radius-xl overflow-hidden chart-container">
											<div class="tab-content tab-space">
												<div class="tab-pane active" id="preview-btn-color">
												<div id="events-container">
													<div class="row justify-content-between align-items-center py-2">
													<!-- Canvas for the chart -->
													<canvas id="heart" class="chart-canvas"></canvas>
													</div>
													<!-- Button Details -->
													<div class="d-flex justify-content-end mt-1 mb-4">
													<button onclick="window.location.href='./details.php';" class="btn btn-primary home" id="details-button">See Details</button>
													</div>
												</div>
												</div>
											</div>
										</div>

									</div>
								</div>

								

							`, true); 
							break;

						case 'message-menu':
							updateMainContent('<h1>Message</h1><p>Here you can view your messages.</p>');
							break;

						case 'team-menu':
							updateMainContent('<h1>Team</h1><p>This section shows your team and their details.</p>');
							break;

						default:
							updateMainContent('');
							break;
					}
				});
			});
		});

	</script>
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>