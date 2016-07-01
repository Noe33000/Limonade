<?php $this->layout('layout', ['title' => 'Résultat de votre recherche']) ?>

<?php $this->start('main_content') ?>
	
 <div class="event-title">
 	<h1>Résultat de votre recherche :</h1>
 </div>
 	<?php foreach ($search as $result) :?>	
	<h2>
		<a href="<?= $this->url('event_showEvent', ['id' => $result['id']]);?>">
			<?php echo $result['title'] ?> 
		</a>
	</h2>
	<div class="event-desc">
	<h2> <?php echo $result['description'] ?> </h2>

	<div class="event-address">
	<h2> <?php echo $result['address'] ?> </h2>

	<div class="event-date">
	<h2> <?php echo $result['date_start'] ?> </h2>

	<div class="event-category">
	<h2> <?php echo $result['category'] ?> </h2>
	<br><br>
<?php endforeach ?>

<?php $this->stop('main_content') ?>  