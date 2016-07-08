<?php

/*
 +-----------------------------------------------------------------------+
 | Local configuration for the Roundcube Webmail installation.           |
 |                                                                       |
 | This is a sample configuration file only containing the minimum       |
 | setup required for a functional installation. Copy more options       |
 | from defaults.inc.php to this file to override the defaults.          |
 |                                                                       |
 | This file is part of the Roundcube Webmail client                     |
 | Copyright (C) 2005-2013, The Roundcube Dev Team                       |
 |                                                                       |
 | Licensed under the GNU General Public License version 3 or            |
 | any later version with exceptions for skins & plugins.                |
 | See the README file for a full license statement.                     |
 +-----------------------------------------------------------------------+
*/

$config = array();

// Database connection string (DSN) for read+write operations
// Format (compatible with PEAR MDB2): db_provider://user:password@host/database
// Currently supported db_providers: mysql, pgsql, sqlite, mssql or sqlsrv
// For examples see http://pear.php.net/manual/en/package.database.mdb2.intro-dsn.php
// NOTE: for SQLite use absolute path: 'sqlite:////full/path/to/sqlite.db?mode=0646'
// REPLACE
$config['db_dsnw'] = 'pgsql://webmail:DOCKER_DB_WEBMAIL_PASSWORD@db/webmail';

// The mail host chosen to perform the log-in.
// Leave blank to show a textbox at login, give a list of hosts
// to display a pulldown menu or set one host as string.
// To use SSL/TLS connection, enter hostname with prefix ssl:// or tls://
// Supported replacement variables:
// %n - hostname ($_SERVER['SERVER_NAME'])
// %t - hostname without the first part
// %d - domain (http hostname $_SERVER['HTTP_HOST'] without the first part)
// %s - domain name after the '@' from e-mail address provided at login screen
// For example %n = mail.domain.tld, %t = domain.tld
// CHANGED
$config['default_host'] = 'imapproxy:1143';

// SMTP server host (for sending mails).
// To use SSL/TLS connection, enter hostname with prefix ssl:// or tls://
// If left blank, the PHP mail() function is used
// Supported replacement variables:
// %h - user's IMAP hostname
// %n - hostname ($_SERVER['SERVER_NAME'])
// %t - hostname without the first part
// %d - domain (http hostname $_SERVER['HTTP_HOST'] without the first part)
// %z - IMAP domain (IMAP hostname without the first part)
// For example %n = mail.domain.tld, %t = domain.tld
// CHANGED
$config['smtp_server'] = 'tls://core';

// SMTP port (default is 25; use 587 for STARTTLS or 465 for the
// deprecated SSL over SMTP (aka SMTPS))
$config['smtp_port'] = 587;

// SMTP username (if required) if you use %u as the username Roundcube
// will use the current username for login
// CHANGED
$config['smtp_user'] = '%u';

// SMTP password (if required) if you use %p as the password Roundcube
// will use the current user's password for login
// CHANGED
$config['smtp_pass'] = '%p';

// provide an URL where a user can get support for this Roundcube installation
// PLEASE DO NOT LINK TO THE ROUNDCUBE.NET WEBSITE HERE!
// TODO
$config['support_url'] = '';

// Name your service. This is displayed on the login screen and in the window title
$config['product_name'] = 'Roundcube Webmail';

// this key is used to encrypt the users imap password which is stored
// in the session record (and the client cookie if remember password is enabled).
// please provide a string of exactly 24 chars.
// YOUR KEY MUST BE DIFFERENT THAN THE SAMPLE VALUE FOR SECURITY REASONS
// REPLACE
$config['des_key'] = 'DOCKER_RANDOM_STRING_24';

// List of active plugins (in plugins/ directory)
// CHANGED
$config['plugins'] = array(
    'archive',
    'attachment_reminder',
    'filesystem_attachments',
    'jqueryui',
    'managesieve',
    'markasjunk',
    'newmail_notifier',
    'password',
    'subscriptions_option',
    'vcard_attachments',
    'zipdownload',
);


// skin name: folder from skins/
$config['skin'] = 'larry';

// ADDED
$config['db_prefix'] = '';
$config['log_driver'] = 'syslog';
$config['temp_dir'] = '/tmp/';

$config['smtp_conn_options'] = array(
  'ssl'         => array(
    'verify_peer'  => false,
    'verify_depth' => 1,
    'cafile'       => '/etc/ssl/certs/ca-certificates.crt',
    'verify_peer_name' => false,
  ),
);

$config['imap_conn_options'] = array(
  'ssl'         => array(
    'verify_peer'  => false,
    'verify_depth' => 1,
    'cafile'       => '/etc/ssl/certs/ca-certificates.crt',
    'verify_peer_name' => false,
  ),
);

// the default locale setting (leave empty for auto-detection)
// RFC1766 formatted language name like en_US, de_DE, de_CH, fr_FR, pt_BR
// FIXME
$config['language'] = 'pl_PL';
$rcmail_config['locale_string'] = 'pl';

// Make use of the built-in spell checker. It is based on GoogieSpell.
// Since Google only accepts connections over https your PHP installatation
// requires to be compiled with Open SSL support
$config['enable_spellcheck'] = false;

// compose html formatted messages by default
// 0 - never, 1 - always, 2 - on reply to HTML message, 3 - on forward or reply to HTML message
$config['htmleditor'] = 2;

// save compose message every 300 seconds (5min)
$config['draft_autosave'] = 60;

// default setting if preview pane is enabled
$config['preview_pane'] = true;

// PLUGINS
// jquireyui
$config['jquery_ui_i18n'] = array('datepicker');
$config['jquery_ui_skin_map'] = array(
  'larry' => 'larry',
  'default' => 'larry',
  'groupvice4' => 'redmond',
);

