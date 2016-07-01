<?php /* app/Model/CommentModel.php */
namespace Controller;

use \W\Controller\Controller;
use \Model\ListModel as ListModel;
use \Model\CardsModel as CardsModel;
use \Model\NewsfeedModel as NewsfeedModel;
use \Controller\EventController;

class ListController extends Controller
{

	/**
	 * Génère une liste
	 */
	public function addList()
	{
		$loggedUser = $this->getUser();
		if(!isset($loggedUser)){
			$this->redirectToRoute('default_home');
		}
			else{
			$post = [];
			$inputMaxLength = 151; // restrict list name length

			// var_dump($_POST['eventId']);
			if(!empty($_POST)) {
				// clean received data
				foreach ($_POST as $key => $value) {
					$post[$key] = trim(strip_tags($value));
				}
				// if our name input exists in correst state
				if(isset($post['newList']) && !empty($post['newList']) && isset($post['eventId']) && !empty($post['eventId'])) {
					//$user = $this->getUser();
					$idEvent = intval($post['eventId']);

					// create variable to prevent empty insertions
					$listName = $post['newList'];
					$timestamp = date('Y-m-d H:i:s');
					//form data to insert to the database
					$entryData = [
					  'list_title' 	=> $listName,
					  'id_event' 	=> $idEvent,
					  'date_add'	=> $timestamp,
					];
					// call model
					$insertList = new ListModel();
					$listInsertion = $insertList->insert($entryData);
					if($listInsertion) {

						$user = $this->getUser();
						$newsfeed = new NewsfeedModel();

						$newsfeedData = [
							'id_event'  => $idEvent,
							'id_user'   => $user['id'],
							'action'    => 'add',
							'id_list'   => $listInsertion['id'],
							'date_news' => $timestamp,
						];

						if($newsfeed->insert($newsfeedData)) {
							$this->showJson(['answer' => 'success']);
						}
					}

				}
			}
		}
	}

	/**
	 * Ajoute une chexbox
	 */
	public function addCard()
	{
		$loggedUser = $this->getUser();
		if(!isset($loggedUser)){
			$this->redirectToRoute('default_home');
		}
			else{
			$post = [];
			$errors = [];
			$inputMaxLength = 151; // restrict list name length
			$responsible = 0;
			$idList = 0;
			$idEvent = 0;

			if(!empty($_POST)) {

				// clean received data
				foreach ($_POST as $key => $value) {
					$post[$key] = trim(strip_tags($value));
				}
				// if our name input exists in correst state
				if(!isset($post['card_title']) || empty($post['card_title'])) {
					$errors[] = 'Le titre de la tâche est incorrect';
				}
				if(!isset($post['card_desc']) || empty($post['card_desc'])) {
					$errors[] = 'La description de la tâche est incorrecte';
				}
				if(!isset($post['card_quantity']) || empty($post['card_quantity']) && $post['card_quantity'] < 0) {
					$errors[] = 'La quantité de la tache est incorrecte';
				}
				if(!isset($post['card_price']) || empty($post['card_price']) || !is_numeric($post['card_price']) || $post['card_price'] < 0) {
					$errors[] = 'Le prix de la tache est incorrecte';
				}
				// create variable to prevent empty insertions
				if(isset($post['card_person']) && !empty($post['card_person'])) {
					$responsible = intval($post['card_person']);
				}
				else {
					$responsible = 0;
				}
				// check id of the event

				if(isset($post['eventId']) && !empty($post['eventId'])) {
					$idEvent = intval($post['eventId']);
				}
				else {
					$errors[] = 'Impossible d\'inserer cette tache dans l\'évènement';
				}
				// check id of the list
				if(isset($post['listId']) && !empty($post['listId'])) {
					$idList = intval($post['listId']);
				}
				else {
					$errors[] = 'Impossible d\'inserer cette tâche dans la liste';
				}
				// if input data is valid
				if(count($errors) == 0) {
					// current time for date_add
					$timestamp = date('Y-m-d H:i:s');
					//form data to insert to the database
					$cardData = [
					  'card_title' 		=> $post['card_title'],
					  'description' 	=> $post['card_desc'],
					  'quantity' 		=> $post['card_quantity'],
					  'price' 			=> $post['card_price'],
					  'id_user' 		=> $responsible,
					  'id_event' 		=> $idEvent,
					  'id_list' 		=> $idList,
					  'date_add'		=> $timestamp,
					];
					// call model
					$insertList = new CardsModel();
					// insert
					if($insertCard = $insertList->insert($cardData)) {

						$user = $this->getUser();
						$newsfeed = new NewsfeedModel();

						$newsfeedData = [
							'id_event' 	=> $idEvent,
							'id_user' 	=> $user['id'],
							'action' 	=> 'add',
							'id_card' 	=> $insertCard['id'],
							'date_news' => $timestamp,
						];

						if($newsfeed->insert($newsfeedData)) {
							$this->showJson(['answer' => 'success']);
						}
					}
				}
				else {
					$this->showJson(['errors' => $errors, 'list' => $idList, 'event' => $idEvent]);
				}
			}
		}
	}

	/**
	 * Récupere les listes
	 */
	public function getList()
	{
		$loggedUser = $this->getUser();
		if(!isset($loggedUser)){
			$this->redirectToRoute('default_home');
		}
		else{
			//get id of event from ajax
			$id = intval($_POST['eventId']);

			//temporary time vars
			$lastDateLists = null;
			$lastDateCards = null;

			// define lastDate for the first time
			if(isset($_POST['myDate']) && !empty($_POST['myDate'])) {
				$lastDate = $_POST['myDate'];
			} else {
				$lastDate = 0;
			}

			$listsData = new ListModel();
			// get lists and cards
			$newLists = $listsData->findLists($id, $lastDate);
	 		$newCards = $listsData->findCards($id, $lastDate);

			if(!empty($newLists)) {
				foreach ($newLists as $key => $value) {
					$lastDateLists = $value['date_add'];
				}
			}
			if(!empty($newCards)) {
				foreach ($newCards as $key => $value) {
					$lastDateCards = $value['date_add'];
				}
			}
			if( $lastDateLists != null && $lastDateCards != null) {
				if($lastDateLists > $lastDateCards) {
					$lastDate = $lastDateLists;
				}
				else {
					$lastDate = $lastDateCards;
				}
			}
			elseif($lastDateLists == null && $lastDateCards != null) {
				$lastDate = $lastDateCards;
			}
			elseif($lastDateLists != null && $lastDateCards == null) {
				$lastDate = $lastDateLists;
			}

			$this->showJson(['newLists' => $newLists, 'newCards' => $newCards, 'newDate' => $lastDate]);

		}
	}


	/**
	 * Supprime une liste
	 *
	 */
	public function deleteList()
	{
		$loggedUser = $this->getUser();
		if(!isset($loggedUser)){
			$this->redirectToRoute('default_home');
		}
			else{
			// just 0 so he can find nothing
			$idList = 0;
			if(isset($_POST['idList']) && !empty($_POST['idList'])) {
				$idList = intval($_POST['idList']);
			}

			$idEvent = 0;
			if(isset($_POST['idEvent']) && !empty($_POST['idEvent'])) {
				$idEvent = intval($_POST['idEvent']);
			}

			$deleteList = new ListModel();

			if($deleteList->delete($idList)) {

				$user = $this->getUser();
				$newsfeed = new NewsfeedModel();
				$timestamp = date('Y-m-d H:i:s');

				$newsfeedData = [
					'id_event' 	=> $idEvent,
					'id_user' 	=> $user['id'],
					'action' 	=> 'remove',
					'id_list' 	=> $idList,
					'date_news' => $timestamp,
				];

				if($newsfeed->insert($newsfeedData)) {
					$this->showJson(['deleteList' => 'done', 'idList' => $idList]);
				}
			}
		}
	}

	public function deleteCard()
	{
		$loggedUser = $this->getUser();
		if(!isset($loggedUser)){
			$this->redirectToRoute('default_home');
		}
			else{
			// just 0 so he can find nothing
			$idCard = 0;
			if(isset($_POST['idCard']) && !empty($_POST['idCard'])) {
				$idCard = intval($_POST['idCard']);
			}

			$idEvent = 0;
			if(isset($_POST['idEvent']) && !empty($_POST['idEvent'])) {
				$idEvent = intval($_POST['idEvent']);
			}

			$deleteCard = new ListModel();

			if($deleteCard->deleteCard($idCard)) {
				$user = $this->getUser();
				$newsfeed = new NewsfeedModel();
				$timestamp = date('Y-m-d H:i:s');

				$newsfeedData = [
					'id_event'	=> $idEvent,
					'id_user' 	=> $user['id'],
					'action'	=> 'remove',
					'id_card' 	=> $idCard,
					'date_news' => $timestamp,
				];

				if($newsfeed->insert($newsfeedData)) {
					$this->showJson(['deleteCard' => 'done']);
				}
			}
		}
	}

	public function modifyCard() {

		$post = [];
		$errors = [];
		$inputMaxLength = 151; // restrict list name length
		$responsible = 0;
		$idCard = 0;
		$idEvent = 0;

		if(!empty($_POST)) {

			// clean received data
			foreach ($_POST as $key => $value) {
				$post[$key] = trim(strip_tags($value));
			}
			// if our name input exists in correst state
			if(!isset($post['card_title']) || empty($post['card_title'])) {
				$errors[] = 'Le titre de la tâche est incorrect';
			}
			if(!isset($post['card_desc']) || empty($post['card_desc'])) {
				$errors[] = 'La description de la tâche est incorrecte';
			}
			if(!isset($post['card_quantity']) || empty($post['card_quantity']) && $post['card_quantity'] < 0) {
				$errors[] = 'La quantité de la tache est incorrecte';
			}
			if(!isset($post['card_price']) || empty($post['card_price']) || !is_numeric($post['card_price']) || $post['card_price'] < 0) {
				$errors[] = 'Le prix de la tache est incorrecte';
			}
			// create variable to prevent empty insertions
			if(isset($post['card_person']) && !empty($post['card_person'])) {
				$responsible = intval($post['card_person']);
			}
			else {
				$responsible = 0;
			}
			// check id of the event

			if(isset($post['eventId']) && !empty($post['eventId'])) {
				$idEvent = intval($post['eventId']);
			}
			else {
				$errors[] = 'Impossible d\'inserer cette tache dans l\'évènement';
			}
			// check id of the list
			if(isset($post['cardId']) && !empty($post['cardId'])) {
				$idCard = intval($post['cardId']);
			}
			else {
				$errors[] = 'Impossible d\'inserer cette tâche dans la liste';
			}
			// if input data is valid
			if(count($errors) == 0) {
				// current time for date_add
				$timestamp = date('Y-m-d H:i:s');
				//form data to insert to the database
				$cardData = [
				  'card_title' 		=> $post['card_title'],
				  'description' 	=> $post['card_desc'],
				  'quantity' 		=> $post['card_quantity'],
				  'price' 			=> $post['card_price'],
				  'id_user' 		=> $responsible,
				];
				// call model
				$modify = new CardsModel();
				// insert

				if($modifyCard = $modify->update($cardData, $idCard)) {

					$user = $this->getUser();
					$newsfeed = new NewsfeedModel();

					$newsfeedData = [
						'id_event' 	=> $idEvent,
						'id_user' 	=> $user['id'],
						'action' 	=> 'modify',
						'id_card' 	=> $modifyCard['id'],
						'date_news' => $timestamp,
					];

					if($newsfeed->insert($newsfeedData)) {
						$this->showJson(['answer' => 'modified']);
					}
				}
			}
			else {
				$this->showJson(['errors' => $errors, 'list' => $idCard, 'event' => $idEvent]);
			}
		}
	}

	public function refreshCard() {
		if(!empty($_POST)) {

			$idCard = 0;
			if(isset($_POST['idCard']) && !empty($_POST['idCard'])) {
				$idCard = intval($_POST['idCard']);
			}

			$cards = new CardsModel();
			$thisCard = $cards->find($idCard);

			$this->showJson(['card' => $thisCard]);

		}
	}
}
