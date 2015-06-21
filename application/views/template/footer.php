			<div class="row">
				<div class="span12 text-center">
					<p>
						<?php
						if( $this->models->is_logged_in() == TRUE ){
							echo "Logged in as " . $this->session->userdata('user_name');
							echo "/" . $this->session->userdata('type');
							echo "/" . $this->session->userdata('user_id');
						}
						?>
						<br/>
						Automaticaly generated on <strong><?php echo date('Y-m-d h:i:s A'); ?></strong>
					</p>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
