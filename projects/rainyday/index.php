<html>
	<head>
		<title>Hydroclimate Extremes Research Group</title>
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  		<link rel="stylesheet" type="text/css" href="../../css/custom.css">
	</head>
	


	<body>
		<header class="navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
           	 		</button>
            		<a class="navbar-brand" href="../../">Hydroclimate Extremes Research Group</a>
				</div>

				<!-- Navbar Links -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="../../"><b>Home</b></a></li>
						<li><a href="../../groupmembers"><b>Group Members</b></a></li>
						      <li class="dropdown active"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><b>Projects</b><span class="caret"></span></a>
						        <ul class="dropdown-menu">
						          <li><a href="#">RainyDay: Rainfall for Modern Flood Hazard Assessment</a></li>
						          <li><a href="../landslide-modelling">Regional Landslide Modeling</a></li>
						          <li><a href="../tropical-cyclones">Tropical Cyclones, Flooding, and the Regional Hydroclimate</a></li>
						          <li><a href="../remote-sensing">Rainfall remote sensing for hydrology</a></li>
						          <li><a href="../urbanization">Urbanization and Hydrologic Change</a></li>
						        </ul>
						      </li>
						<li><a href="../../publications"><b>Publications</b></a></li>
						<li><a href="../../collaborators"><b>Collaborators</b></a></li>
					</ul>
				</div>

			</div>
		</header>
		
				<!-- Navbar Infomation -->
		<div class="container">
			<p class="navabr-navbar-info">Rainy Day: A Modern, Open Source rianfall infomation system</p>
		</div>
		
		<br>
		<!-- Rainyday Form -->
		<div class="container">
		  <form class="rainyday-form" method="post" action="function.php"> 
		  	<br>

				<fieldset class="form-group row">
			      <label class="col-2 col-form-label">1. Define rainfall input dataset.</label>
			      <div class="col-sm-10">
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="dataset" id="gridRadios1" value="option1" required>
			            NLDAS
			          </label>
			        </div>
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="dataset" id="gridRadios2" value="option2" >
			            Stage IV
			          </label>
			        </div>
			      </div>
    			</fieldset>


			    <div class="form-group row">
				  <label for="duration" class="col-2 col-form-label">2. Define the duration of rainfall accumulation period in hours.</label>
				  <div class="col-10">
				    <input class="form-control" type="number" min=0 name="duration" id="duration" required>
				  </div>
			    </div>


			    <div class="form-group row">
				  <label for="nstorms" class="col-2 col-form-label">3. Define how many storms to include in the process.</label>
				  <div class="col-10">
				    <input class="form-control" type="number" min=0 name="nstorms" id="nstorms" required>
				  </div>
			    </div>

			    <div class="form-group row">
				  <label for="nyears" class="col-2 col-form-label">4. Define how many years of annual maxima rainfall to be synthesized.</label>
				  <div class="col-10">
				    <input class="form-control" type="number" min=0 name="nyears" id="nyears" required>
				  </div>
			    </div>

			    <div class="form-group row">
				  <label for="nrealizations" class="col-2 col-form-label">5. Define how many years of long sequences to be generated.</label>
				  <div class="col-10">
				    <input class="form-control" type="number" min=0 name="nrealizations" id="nrealizations" required>
				  </div>
			    </div>

			    <div class="form-group row">
				  <label for="timeseparation" class="col-2 col-form-label">6. Define the minimum separation time in hours between two storms in the storm catalog.</label>
				  <div class="col-10">
				    <input class="form-control" type="number" min=0 name="timeseparation" id="timeseparation" required>
				  </div>
			    </div>

				<fieldset class="form-group row">
			      <label class="col-2 col-form-label">7. Frequency Analysis. (Create a ".FreqAnalysis" file)</label>
			      <div class="col-sm-10">
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="freqanalysis" id="freqanalysis1" required>
			            YES
			          </label>
			        </div>
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="freqanalysis" id="freqanalysis2" >
			            NO
			          </label>
			        </div>
			      </div>
    			</fieldset>

				
			    <div class="form-group row">
				  <label for="excludemonths" class="col-2 col-form-label">8. Define months(1-2 digit numeric) to be excluded from the storm catalog creation. </label>
				  <div class="col-10">
				    <input class="form-control" type="text" name="excludemonths" id="excludemonths" placeholder="Examples:10 or 8,9 or 9-12" required>
				  </div>
			    </div>


			    <div class="form-group row">
				  <label class="col-2 col-form-label">9. Define start and end year. (Availabe from 1979-2015) </label>
				  <br>
				  <div class="col-sm-4 ">
				    <input class="form-control" type="number" min="1979" max="2015" name="startyear" id="startyear" placeholder="Start Year (eg: 1979)" required>
				  </div>
				  <div class="col-sm-4">
				    <input class="form-control" type="number" min="1979" max="2015" name="endyear" id="endyear" placeholder="End Year (eg: 2010)" required>
				  </div>
			    </div>


				<fieldset class="form-group row">
			      <label class="col-2 col-form-label">10. Define the catchment. (Area of interest) </label>
			      <div class="col-sm-10">
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="catchment" id="catchment1" required>
			            Point Area
			          </label>
			        </div>
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="catchment" id="catchment2" >
			            Bounding box
			          </label>
			        </div>
			        <div class="form-check">
			          <label class="form-check-label">
			            <input class="form-check-input" type="radio" name="catchment" id="catchment3" >
			            Upload the shape file
			          </label>
			        </div>
			      </div>
    			</fieldset>


				<div class="form-group row">
				  <label for="client-email" class="col-2 col-form-label">11. Email Address. (Simulation outputs will be sent to your email address.)</label>
				  <div class="col-10">
				    <input class="form-control" type="email" placeholder="badger@example.com" name="client-email" id="client-email" required>
				  </div>
				</div>

				<div class="form-group row">
				  <label for="client-email" class="col-2 col-form-label">12. Run Rainy Day simulation.</label>
				  <div class="col-10">
				  	<button type="submit" class="btn btn-primary">Run Rainy Day</button>
				  </div>
				</div>

				<br>
				<br>
				<br>
				<br>


		  </form>
		</div>
		<br>

	</body>

	<footer>
		<div class="collapse navbar-collapse">
		<div class="container">
			<div class="col">
				<img src="../../images/home-uwlogo.png" style=" padding: 15px">
			</div>
			
			<div class="col">
				<h3>CONTACT</h3>
				<p>Room: 1269C Engineering Hall 1415 Engineering Drive Madison, WI 53706</p>
				<p>Ph: (608) 262-1978</p>
				<p><a href="mailto:danielb.wright@wisc.edu">danielb.wright@wisc.edu</a></p>
			</div>
			
			<div class="col" >
				<h3>LINKS</h3>
				<ul class="footer-ul">
		          <li><a href="https://www.engr.wisc.edu/department/civil-environmental-engineering/"> UW-Madison: Civil & Environmental Engineering</a></li>
		          <li><a href="http://www.usgs.gov/"> U.S. Geological Survey</a></li>
		          <li><a href="http://www.usbr.gov/"> U.S. Bureau of Reclamation</a></li>
		          <li><a href="http://www.nasa.gov/"> NASA</a></li>
		          <li><a href="http://www.noaa.gov/"> National Oceanic & Atmospheric Administration</a></li>
		          <li><a href="https://www.nsf.gov/"> National Science Foundation</a></li>
		        </ul>
			</div>
		</div>
		</div>
		<div class="copyright">
			<p>University of Wisconsin Madison</p>
		</div>
	</footer>

</html>


