<?php

	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
		['GET|POST', '/team', 'Default#team', 'default_team'],
		['GET|POST', '/contact', 'Contact#contact', 'contact_contact'],
		['GET|POST', '/faq', 'Default#faq', 'default_faq'],

		/**************************** event ********************/
		['GET|POST', '/event/[i:id]', 'Event#showEvent', 'event_showEvent'],
		['GET|POST', '/create', 'Event#createEvent', 'event_createEvent'],
		['GET|POST', '/invite/[i:id]', 'Event#invite', 'event_invite'],
		['GET|POST', '/update/[i:id]', 'Event#update', 'event_update'],

		/**************************** Search ********************/
		['GET|POST', '/search-result', 'Search#searchResult', 'event_searchResult'],

		/************************************ ourAccount ****************************/
		['GET|POST', '/ourAccounts', 'Count#ourAccounts', 'count_ourAccounts'],

		/***************************** users *************************/
		['GET|POST', '/register', 'User#register', 'user_register'],
		['GET|POST', '/registerConfirm', 'User#registerConfirm', 'user_registerConfirm'],
		['GET|POST', '/login', 'User#login', 'user_login'],
		['GET|POST', '/logout', 'User#logout', 'user_logout'],
		['GET|POST', '/lostpassword', 'User#lostPassword', 'user_lostPassword'],
		['GET|POST', '/getnewpassword', 'User#getNewPassword', 'user_getNewPassword'],
		['GET|POST', '/updateUser', 'User#updateUser', 'user_updateUser'],

		['GET|POST', '/facebook/auth', 'User#loginFacebook', 'user_loginFacebook'],
		['GET|POST', '/facebook/logged', 'User#fbCallBack', 'user_fbCallBack'],

		/***************************** admin *************************/
		['GET|POST', '/admin', 'Admin#admin', 'admin_admin'],
		['GET|POST', '/admin/checkEvent/[i:id]', 'Admin#checkEvent', 'admin_checkEvent'],
		['GET|POST', '/admin/checkUser/[i:id]', 'Admin#checkUser', 'admin_checkUser'],
		['GET|POST', '/admin/banUser/[i:id]', 'Admin#banUser', 'admin_banUser'],
		['GET|POST', '/admin/users', 'Admin#users', 'admin_users'],
		['GET|POST', '/admin/events', 'Admin#events', 'admin_events'],
		['GET|POST', '/admin/comments', 'Admin#comments', 'admin_comments'],
		['GET|POST', '/admin/delete-comment/[i:id]', 'Admin#supprComment', 'admin_supprComment'],
		['GET|POST', '/admin/contact', 'Admin#messageConctact', 'admin_messageConctact'],
		['GET|POST', '/admin/check-contact/[i:id]', 'Admin#checkContact', 'admin_checkContact'],



		/************************************ ajax ************************************/
		/*********************************** list ************************************/
		['GET|POST', '/ajax/get-list', 'List#getList', 'list_getList'],
		['GET|POST', '/ajax/add-list', 'List#addList', 'list_addList'],
		['GET|POST', '/ajax/delete-list', 'List#deleteList', 'list_deleteList'],
		['GET|POST', '/ajax/modify-list', 'List#modifyList', 'list_modifyList'],
		['GET|POST', '/ajax/refresh-list', 'List#refreshList', 'list_refreshList'],

				/******************* Cards ******************/
		['GET|POST', '/ajax/add-card', 'List#addCard', 'list_addCard'],
		['GET|POST', '/ajax/delete-card', 'List#deleteCard', 'list_deleteCard'],
		['GET|POST', '/ajax/modify-card', 'List#modifyCard', 'list_modifyCard'],
		['GET|POST', '/ajax/refresh-card', 'List#refreshCard', 'list_refreshCard'],

		/*********************************** Price**********************************/
		['GET|POST', '/ajax/get-price', 'Event#calcul', 'event_calcul'],

		/*********************************** Price**********************************/
		['GET|POST', '/ajax/get-newsfeed', 'NewsFeed#getNewsfeed', 'event_getNewsfeed'],
		/*********************************** Comment**********************************/
		['GET|POST', '/ajax/add-comment', 'Comment#insertComment', 'comment_insertComment'],
		['GET|POST', '/ajax/show-comment', 'Comment#showComments', 'comment_showComments'],
		['GET|POST', '/ajax/join-comment', 'Comment#joinComment', 'comment_joinComment'],
		['GET|POST', '/ajax/delete-comment', 'Comment#deleteComment', 'commment_deleteComment'],

		/******************************* Participant **************************************/
		['GET|POST', '/ajax/list-users', 'Event#listUsers', 'event_listUsers'],
		['GET|POST', '/ajax/add-participant', 'Event#addParticipant', 'event_addParticipant'],
		['GET|POST', '/ajax/delete-participant', 'Event#deleteParticipant', 'event_deleteParticipant'],
		['GET|POST', '/ajax/get-all-participants', 'Event#getAllParticipants', 'event_getAllParticipants'],
		['GET|POST', '/join-event/[i:id]', 'Event#joinEvent', 'event_joinEvent'],

		/******************************************* Notif **********************************/
		['GET|POST', '/ajax/update-notif', 'Notifications#updateNotif', 'event_updateNotif'],
);
