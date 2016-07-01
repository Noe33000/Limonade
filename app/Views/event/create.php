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
        }?>
    </p>
<?php endif; ?>
</div> 
<div class="container" id="form-crea">
    <form method="post" class="form-create-event" id="createEvent" onsubmit="return validateForm()">
        <h1 class="center">Créez votre événement</h1><br><br>
        <div class="row">
            <div class="part1">
                <div class="col-xs-3">
                    <label for="type-event">Visibilité d'événement</label><br>
                    <input type="radio" name="role" id="private" value="private">
                    <label for="private" class="masterTooltip" title="Seul les personnes invitées peuvent voir l'événement, ses membres et leurs publications.">Privé 
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></label>
                    <br>
                    <input type="radio" name="role" id="public" value="public">
                    <label for="public" class="masterTooltip" title="Tout le monde peut voir l'événement, ses membres et leurs publications.Et donc y participer.">Public <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></label>
                </div> 
                <div class="col-xs-3">
                    <label for="cat-event" class="masterTooltip" title="Ceci est le style de votre évènement">Type d'événement <i class="fa fa-info-circle" aria-hidden="true"></i></label>
                    <br>
                    <input type="radio" name="category" value="repas" id="repas"> <label for="repas" class="masterTooltip" title="Repas de famille, Anniversaire, etc">Repas</label><br>
                    <input type="radio" name="category" value="soiree" id="soiree"> <label for="soiree" class="masterTooltip" title="Soirée de départ de Jean au Japon, soirée à thème, etc">Soirée</label><br>
                    <input type="radio" name="category" value="vacances" id="vacances"> <label for="vacances" class="masterTooltip" title="Séjour en Espagne, camping etc">Vacance</label><br>
                    <input type="radio" name="category" value="journee" id="journee"> <label for="journee" class="masterTooltip" title="Journée plage, après-midi jeux de sociétés, etc">Journée</label>
                </div>
                 <div class="col-xs-3">
                    <label for="title-event" class="masterTooltip" title="Indiquez un titre à votre évènement, vous aurez la possibilité de la changer ultérieurement">Nom d'événement: <i class="fa fa-info-circle" aria-hidden="true"></i></label><br>
                    <input type="text" name="title" placeholder="Le titre" required><br><br>
                </div>
            </div>
        </div>    
        <hr>  
        <br>
        <div class="">
            <div class="row">
                <div class="col-xs-6 col-md-4">    
                    <label for="description" class="masterTooltip" title="Entrez une brève description de votre évènement">Description d'évenement: <i class="fa fa-info-circle" aria-hidden="true"></i></label><br>
                    <textarea name="description" rows="3" cols="70" placeholder="Une brève description de votre événement "></textarea>
                </div>  
            </div>
            <hr><br>
            <div class="row">
                <div class="col-xs-6 col-md-4">        
                    <label for="lieu-event" class="masterTooltip" title="Indiquez une adresse à votre événement">Adresse d'événement: <i class="fa fa-info-circle" aria-hidden="true"></i></label><br>        
                    <textarea name="address" rows="5" cols="70" placeholder="L'adresse de votre événement" required></textarea>
                </div>
            </div><hr>
            </div>
            <div class="row">
            <div class='col-xs-6 col-md-4'>
              <div class="form-group" id="date_start">
                <i class="fa fa-hourglass-start fa-2x" aria-hidden="true"> Début d'événement</i><br><br>
                <label for="date_start" name="date_start" class="masterTooltip" title="Début de votre évènement">Date et heure : <i class="fa fa-info-circle" aria-hidden="true"></i></label><br>
                  <div class="input-group">
                      <input type="text" name="date_start" class="form-control" id='datetimepickerstart'>
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
            </div>
            <div class='col-xs-6 col-md-4'>
                <div class="form-group" id="date_end">
                    <i class="fa fa-hourglass-end fa-2x" aria-hidden="true"> Fin d'événement</i><br><br>
                    <label for="date_end" name="date_end" class="masterTooltip" title="Fin de votre événement">Date et heure: <i class="fa fa-info-circle" aria-hidden="true"></i></label><br>
                    <div class="input-group">
                        <input type="text" name="date_end" class="form-control" id='datetimepickerend'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="validcreate-event">
                <button type="submit" id="validCreaEvent" class="btn btn-primary"><p class="glyphicon glyphicon-ok" aria-hidden="true"></p></button> 
            </div>
        </div>
        <hr>  
    </form>
</div><!-- fin du container -->

<?php endif; ?>

<?php $this->stop('main_content') ?>


<?php $this->start('js') ?>
  
  <script src="<?= $this->assetUrl('js/tooltip.js') ?>"></script><!-- Js Datetimepicker -->
<?php $this->stop('js') ?>

