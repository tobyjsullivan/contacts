<?php
/* @var $this SiteController */
/* @var $contacts array[Contact] */

$this->pageTitle="Contact List";
?>
<div class="text-center">
	<p class="text-center"><?php echo CHtml::link('New Contact', array('/site/add'), array('class' => 'btn btn-lg btn-primary')); ?></p>
	<?php
	foreach($contacts as $curContact) {
		$modal_id = "myModal".$curContact->contact_id;

		$followers_id = "followers".$curContact->contact_id;
		?>
	<div>
		<p class="contact"><?php echo CHtml::link(CHtml::encode($curContact->name), '#'.$modal_id, array('data-toggle'=>'modal')); ?></p>
		<!-- Modal -->
		  <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modal_id."Label" ?>" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 id="<?php echo $modal_id."Label" ?>" class="modal-title"><?php echo CHtml::encode($curContact->name); ?></h4>
		        </div>
		        <div class="modal-body">
					<?php 
					if(!empty($curContact->phone)) {
					?>
					<p><strong>Phone:</strong> <?php echo CHtml::encode($curContact->phone); ?></p>
					<?php 
					}
					
					if(!empty($curContact->twitter)) {
						?>
						<p>
						<?php echo CHtml::link('@'.CHtml::encode($curContact->twitter), 'https://twitter.com/'.CHtml::encode($curContact->twitter), array('target' => '_blank')) ?> 
						<span id="<?php echo $followers_id; ?>">(Counting followers...)</span>
						</p>
						<?php 
					}
					
					if(empty($curContact->phone) && empty($curContact->twitter)) {
						?>
						<p class="text-muted">You have no contact information for this person.</p>
						<?php 
					}
					?>
		        </div>
		        <div class="modal-footer">
		          <?php echo CHtml::link('Edit Contact', array('/site/edit', 'contact_id' => $curContact->contact_id), array('class' => 'btn btn-default')); ?>
		          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		        </div>
		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		  </div><!-- /.modal -->
		
	</div>
		<?php
		if(!empty($curContact->twitter)) {
			$url = $this->createUrl('/ajax/getFollowerCount', array('twitter_handle' => CHtml::encode($curContact->twitter)));
			?>
			<script language="javascript">
			$('<?php echo '#'.$modal_id; ?>').on('show.bs.modal', function () {
			  $.ajax({
			    url: "<?php echo $url; ?>",
				dataType: "json"
			  }).done(function(data) {
			    $('<?php echo '#'.$followers_id; ?>').html('('+data.count+' followers)');
			  }).fail(function(xhr, status, error) {
				alert('Oops:' + error + '(status: ' + status + ')');
			  });
			});
			</script>
			<?php
		}
	}
	?>
	
</div>