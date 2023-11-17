<?php

// Pages
$routes->get('/', 'Chat@index');
$routes->get('/faq', 'Chat@faq');
$routes->get('/faq-swp', 'Chat@faq_swp');
$routes->get('/changelog', 'Chat@changelog');
$routes->get('/engines', 'Chat@engines');

// Namenswahl
$routes->get('/name', 'Stats@form_name');
$routes->get('/name/liste', 'Stats@list_name');
$routes->post('/name', 'Stats@save_name');

// API
$routes->post('/ask', 'Chat@ask');
$routes->get('/ping', 'API@ping');
$routes->get('/stream/{id}', 'API@stream');
$routes->get('/stream/force4/{id}', 'API@stream_force_gpt4');

// Conversations
$routes->get('/conversation/{id}', 'Chat@show_conversation');
$routes->get('/conversation/{id}/json', 'Chat@get_conversation_json');
$routes->get('/conversation/{id}/pop', 'Chat@remove_last_conversation_entry');
$routes->get('/conversations', 'Chat@conversation_list');

// Image Generator
$routes->get('/image', 'Image@index');
$routes->post('/image/generate', 'API@generate_image');

// Imports
$routes->get('/import/ticker/{id}', 'Import@ticker');
$routes->get('/import/article/{portal}/{id:\d+}', 'Import@article');
$routes->get('/import/pdf', 'Import@pdf');
$routes->post('/import/file', 'Import@file_upload');

// Settings / Prompts
$routes->get('/settings', 'Settings@index');
$routes->get('/settings/new', 'Settings@new');
$routes->post('/settings/new', 'Settings@create');
$routes->get('/settings/{id:\d+}', 'Settings@edit');
$routes->post('/settings/{id:\d+}', 'Settings@save');
$routes->get('/settings/{id:\d+}/delete', 'Settings@delete');

// Stats
$routes->get('/stats', 'Stats@index');
$routes->get('/stats/hour', 'Stats@hourly_stats');
$routes->get('/stats/day', 'Stats@daily_stats');
$routes->get('/stats/week', 'Stats@weekly_stats');
$routes->get('/stats/weekday', 'Stats@weekday_stats');
$routes->get('/stats/import', 'Stats@import_and_summarize');

// Authentication Routes
$routes->get('/login', 'Authentication@login');
$routes->post('/login', 'Authentication@login');
$routes->get('/logout', 'Authentication@logout');
$routes->get('/profile', 'Authentication@profile');
$routes->get('/password-reset', 'Authentication@password_reset_form');
$routes->post('/password-reset', 'Authentication@password_reset_send_mail');
$routes->get('/password-change[/{resetToken}]', 'Authentication@password_change_form');
$routes->post('/password-change[/{resetToken}]', 'Authentication@password_change_process');
$routes->get('/profile/edit', 'Authentication@edit_profile');
$routes->post('/profile/edit', 'Authentication@edit_profile');

// Usermanagement / Admin Routes
$routes->get('/admin', 'Usermanagement@index');
$routes->get('/admin/new', 'Usermanagement@new');
$routes->post('/admin', 'Usermanagement@create');
$routes->get('/admin/{id:\d+}', 'Usermanagement@show');
$routes->get('/admin/{id:\d+}/delete/{token}', 'Usermanagement@delete');
$routes->post('/admin/{id:\d+}', 'Usermanagement@update');

$routes->get('/{category}', 'Chat@category');