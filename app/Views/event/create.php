<?php $this->layout('layout', ['title' => '']) ?>

<?php $this->start('main_content') ?>

<?php if(!isset($w_user) && empty($w_user)): ?>

  <h2>
    <a href="<?= $this->url('user_login') ?>"><strong>Connectez-vous</strong></a>
    Ou
    <a href="<?= $this->url('user_register') ?>"><strong>Inscrivez-vous</strong></a>
    pour pourvoir créer un évènement !
  </h2>

<?php else: ?>

<?php if(isset($success) && $success === true): ?>
<div class="alert alert-success">
    <p style="color:green;">Votre évènement a bien été créé.</p>
    <p><a href="<?= $this->url('event_showEvent', ['id' => $newEvent['id']]);?>">Aller à l'évènement</a></p>
  <?php endif; ?>
</div>

<?php if(isset($errors) && !empty($errors)): ?>
<div class="alert alert-warning">
  <p style="color:red;">
    <?php foreach ($errors as $err) {
      echo $err.'<br>';
    }
    ?>
  </p>
<?php endif; ?>
</div>
  <hr>

<form method="post" class="form-create-event" id="createEvent" onsubmit="return validateForm()">
<h1 class="center">Votre événement</h1>
<hr>
  <div class="row">
    <div class="col-xs-6 .col-md-4">
      <label for="type-event">Etendue de votre l'événement</label><br>
        <input type="radio" name="role" id="private" value="private"><label for="private">Privée <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></label>
        <fieldset>Seul les personnes invitées peuvent voir l'événement, ses membres et leurs publications.</fieldset><br>
        <input type="radio" name="role" id="public" value="public"><label for="public">Publique <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></label>
        <fieldset>Tout le monde peut voir l'événement, ses membres et leurs publications.Et donc y participer.</fieldset><br>
    </div>  
    <div class="col-xs-6 .col-md-4">
      <label for="cat-event">Catégorie de votre événement</label> <i class="fa fa-info-circle" aria-hidden="true"></i>
      <br>
        <input type="radio" name="category" value="repas" id="repas"><label for="repas">Repas</label><br>
        <input type="radio" name="category" value="soiree" id="soiree"><label for="soiree">Soirées</label><br>
        <input type="radio" name="category" value="vacances" id="vacances"><label for="vacances">Vacances</label><br>
        <input type="radio" name="category" value="journee" id="journee"><label for="journee">Journées</label><br>
    </div>
  </div>
  <hr>  

  <div class="row">
    <div class="col-xs-6 .col-md-4">
      <label for="title-event">Intitulé de votre événement:</label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>
        <input type="text" name="title" placeholder="Le titre" required><br><br>
    </div>
    <div class="col-xs-6 .col-md-4">    
      <label for="description" >Description de votre évenement:</label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>
      <textarea name="description" rows="3" cols="70" placeholder="Une brève description de votre événement "></textarea>
    </div>  
  </div>
  <hr>
  <div class="form-group">        
      <label for="lieu-event">Adresse de votre événement:</label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>        
      <textarea name="address" rows="5" cols="70" placeholder="L'adresse de votre événement" required></textarea>
  </div>
  <hr>

  <div class="row">
    <div class="col-xs-6 .col-md-4">
      <label for="date_begin">Date du début de votre événement: </label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>
      <input type="date" name="date_begin">
      <br>
      <label for="time_begin">Heure du début de votre évènemet: </label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>
      <input type="time" name="time_begin">
    </div>    
    <div class="col-xs-6 .col-md-4">
      <label for="date_end">Date de la fin de votre événement:</label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>
      <input type="date" name="date_end">
      <br>
      <label for="date_end">Heure de la fin de votre événement:</label> <i class="fa fa-info-circle" aria-hidden="true"></i><br>
      <input type="time" name="time_end">
    </div>
  </div>
  <hr>  
  <button type="submit" id="validCreaEvent" class="btn btn-primary"><p class="glyphicon glyphicon-ok" aria-hidden="true"></p></button>
</form>

<?php endif; ?>

<?php $this->stop('main_content') ?>
