
<style>
	header.masthead{
		background-image: url('') !important;
		background-color:purple;
	}
	header.masthead .container{
		font-family:italic;
		color:white;
		font-weight:bold;
	}
</style>
<!-- Masthead-->

<!-- Services-->
<section class="page-section bg-dark" id="home">
	<div class="container">
		<h2 class="text-center">Rooms</h2>
	<div class="d-flex w-100 justify-content-center">
		<hr class="border-warning" style="border:3px solid" width="15%">
	</div>
	<div class="row">
		<?php
		$rooms = $conn->query("SELECT * FROM `room_list` order by rand() limit 3");
			while($row = $rooms->fetch_assoc() ):
				$cover='';
				if(is_dir(base_app.'uploads/room_'.$row['id'])){
					$img = scandir(base_app.'uploads/room_'.$row['id']);
					$k = array_search('.',$img);
					if($k !== false)
						unset($img[$k]);
					$k = array_search('..',$img);
					if($k !== false)
						unset($img[$k]);
					$cover = isset($img[2]) ? 'uploads/room_'.$row['id'].'/'.$img[2] : "";
				}
				$row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));

		?>
			<div class="col-md-4 p-4 ">
				<div class="card w-100 rounded-0">
					<img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['room'] ?>" height="200rem" style="object-fit:cover">
					<div class="card-body">
					<h5 class="card-title truncate-1 w-100"><?php echo $row['room'] ?></h5><br>
    				<p class="card-text truncate"><?php echo $row['description'] ?></p>
					<div class="w-100 d-flex justify-content-end">
						<a href="./?page=view_room&id=<?php echo md5($row['id']) ?>" class="btn btn-sm btn-flat btn-warning">View Room <i class="fa fa-arrow-right"></i></a>
					</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	<div class="d-flex w-100 justify-content-end">
		<a href="./?page=rooms" class="btn btn-flat btn-warning mr-4">More Rooms <i class="fa fa-arrow-right"></i></a>
	</div>
	</div>
</section>
<!-- About-->
<section class="page-section" id="about">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">About Us</h2>
		</div>
		<div>
			<div class="card w-100">
				<div class="card-body">
					<p>Airport Residency is a budget-friendly lodge designed to cater to all types of travelers. 
						Our establishment offers a wide range of rooms, from luxurious VIP suites to spacious family 
						rooms, ensuring comfort for every guest. We pride ourselves on providing comprehensive 
						facilities that meet the needs of all our visitors, complemented by our exceptional 24x7 
						customer service. Strategically located near Karipur International Airport, Airport Residency 
						is the ideal choice for convenience and quality, making it a preferred destination for both 
						business and leisure travelers.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Contact-->
<section class="page-section" id="contact">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">Give Feedback</h2>
			<h3 class="section-subheading text-muted">Send us a message for inquiries.</h3>
		</div>
		<!-- * * * * * * * * * * * * * * *-->
		<!-- * * SB Forms Contact Form * *-->
		<!-- * * * * * * * * * * * * * * *-->
		<!-- This form is pre-integrated with SB Forms.-->
		<!-- To make this form functional, sign up at-->
		<!-- https://startbootstrap.com/solution/contact-forms-->
		<!-- to get an API token!-->
		<form id="contactForm" >
			<div class="row align-items-stretch mb-5">
				<div class="col-md-6">
					<div class="form-group">
						<!-- Name input-->
						<input class="form-control" id="name" name="name" type="text" placeholder="Your Name " required />
					</div>
					<div class="form-group">
						<!-- Email address input-->
						<input class="form-control" id="email" name="email" type="email" placeholder="Your Email " data-sb-validations="required,email" />
					</div>
					<div class="form-group mb-md-0">
						<input class="form-control" id="subject" name="subject" type="subject" placeholder="Subject " required />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group form-group-textarea mb-md-0">
						<!-- Message input-->
						<textarea class="form-control" id="message" name="message" placeholder="Your Feedback" required></textarea>
					</div>
				</div>
			</div>
			<div class="text-center"><button class="btn btn-primary btn-xl text-uppercase" id="submitButton" type="submit">Send Feedback</button></div>

		</form>
	</div>
</section>
<section class="page-section" id="locate">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">Locate Us</h2>
		</div>
		<div>
		<div className='about-us-locate'>
				<div class="card w-100">
				<div class="card-body">
				<div className='about-us-locate'>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3914.566549502936!2d75.94558697444766!3d11.145624452276458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba64f003959c3c1%3A0x4128ccef08150d89!2sAirport%20residency!5e0!3m2!1sen!2sin!4v1721836799258!5m2!1sen!2sin"
					 width="200" 
					 height="200" 
					 style="border:0;" 
					 allowfullscreen="" 
					 loading="lazy" 
					 referrerpolicy="no-referrer-when-downgrade"></iframe>
				<h3>Malappuram, Kerala, India</h3>
            </div>
			</div>
			</div>
            </div>			
		</div>
	</div>
</section>
<script>
$(function(){
	$('#contactForm').submit(function(e){
		e.preventDefault()
		$.ajax({
			url:_base_url_+"classes/Master.php?f=save_inquiry",
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("an error occured",'error')
				end_loader()
			},
			success:function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					alert_toast("Inquiry sent",'success')
					$('#contactForm').get(0).reset()
				}else{
					console.log(resp)
					alert_toast("an error occured",'error')
					end_loader()
				}
			}
		})
	})
})
</script>