<?php
	$g_hostname = 'mysql.solocircl.com';
	$g_db_type = 'mysql';
	$g_database_name = 'parentsoloch10';
	$g_db_username = 'mother';
	$g_db_password = 'rehtom';
	
	$g_signup_use_captcha = OFF;
	
	#############################
	# Mantis Email Settings
	#############################
	
	# --- email variables -------------
	$g_administrator_email	= 'contact@neozaibatsu.com';
	$g_webmaster_email	 = 'contact@neozaibatsu.com';
	
	# the sender email, part of 'From: ' header in emails
	$g_from_email	 = 'noreply@solocircl.com';
	
	# the sender name, part of 'From: ' header in emails
	$g_from_name	 = 'Support';
	
	# the return address for bounced mail
	$g_return_path_email	= 'support@solocircl.com';
	
	# allow email notification
	# note that if this is disabled, sign-up and password reset messages will
	# not be sent.
	$g_enable_email_notification	= ON;
	
	# The following two config options allow you to control who should get email
	# notifications on different actions/statuses. The first option (default_notify_flags)
	# sets the default values for different user categories. The user categories
	# are:
	#
	# 'reporter': the reporter of the bug
	# 'handler': the handler of the bug
	# 'monitor': users who are monitoring a bug
	# 'bugnotes': users who have added a bugnote to the bug
	# 'threshold_max': all users with access <= max
	# 'threshold_min': ..and with access >= min
	#
	# The second config option (notify_flags) sets overrides for specific actions/statuses.
	# If a user category is not listed for an action, the default from the config
	# option above is used. The possible actions are:
	#
	# 'new': a new bug has been added
	# 'owner': a bug has been assigned to a new owner
	# 'reopened': a bug has been reopened
	# 'deleted': a bug has been deleted
	# 'updated': a bug has been updated
	# 'bugnote': a bugnote has been added to a bug
	# 'sponsor': sponsorship has changed on this bug
	# 'relation': a relationship has changed on this bug
	# '<status>': eg: 'resolved', 'closed', 'feedback', 'acknowledged', ...etc.
	# this list corresponds to $g_status_enum_string
	
	#
	# If you wanted to have all developers get notified of new bugs you might add
	# the following lines to your config file:
	#
	# $g_notify_flags['new']['threshold_min'] = DEVELOPER;
	# $g_notify_flags['new']['threshold_max'] = DEVELOPER;
	#
	# You might want to do something similar so all managers are notified when a
	# bug is closed. If you didn't want reporters to be notified when a bug is
	# closed (only when it is resolved) you would use:
	#
	# $g_notify_flags['closed']['reporter'] = OFF;
	
	$g_default_notify_flags	= array('reporter'	=> ON,
	'handler'	=> ON,
	'monitor'	=> ON,
	'bugnotes'	=> ON,
	'threshold_min'	=> NOBODY,
	'threshold_max' => NOBODY);
	
	# We don't need to send these notifications on new bugs
	# (see above for info on this config option)
	#@@@ (though I'm not sure they need to be turned off anymore
	# - there just won't be anyone in those categories)
	# I guess it serves as an example and a placeholder for this
	# config option
	$g_notify_flags['new']	= array('bugnotes'	=> OFF,
	'monitor'	=> OFF);
	
	# Whether user's should receive emails for their own actions
	$g_email_receive_own	= OFF;
	
	# set to OFF to disable email check
	$g_validate_email	 = ( substr( php_uname(), 0, 7 ) == 'Windows' ) ? OFF : ON;
	$g_check_mx_record	 = OFF;	# Not supported under Windows.
	
	# if ON, allow the user to omit an email field
	# note if you allow users to create their own accounts, they
	# must specify an email at that point, no matter what the value
	# of this option is. Otherwise they wouldn't get their passwords.
	$g_allow_blank_email	= OFF;
	
	# Only allow and send email to addresses in the given domain
	# For example:
	# $g_limit_email_domain	 = 'users.sourceforge.net';
	$g_limit_email_domain	= OFF;
	
	# This specifies the access level that is needed to get the mailto: links.
	$g_show_user_email_threshold = NOBODY;
	
	# If use_x_priority is set to ON, what should the value be?
	# Urgent = 1, Not Urgent = 5, Disable = 0
	# Note: some MTAs interpret X-Priority = 0 to mean 'Very Urgent'
	$g_mail_priority	 = 3;
	
	# select the method to mail by:
	# 0 - mail()
	# 1 - sendmail
	# 2 - SMTP
	$g_phpMailer_method	 = 2;
	
	# This option allows you to use a remote SMTP host. Must use the phpMailer script
	# One or more hosts, separated by a semicolon, can be listed. 
	# You can also specify a different port for each host by using this 
	# format: [hostname:port] (e.g. "smtp1.example.com:25;smtp2.example.com").
	# Hosts will be tried in order.
	$g_smtp_host	 = 'mail.solocircl.com:465';
	$g_smtp_connection_mode = 'ssl';
	
	# These options allow you to use SMTP Authentication when you use a remote
	# SMTP host with phpMailer. If smtp_username is not '' then the username
	# and password will be used when logging in to the SMTP server.
	$g_smtp_username = 'support@solocircl.com';
	$g_smtp_password = 'parent2009';
	
	# It is recommended to use a cronjob or a scheduler task to send emails. 
	# The cronjob should typically run every 5 minutes. If no cronjob is used,
	# then user will have to wait for emails to be sent after performing an action
	# which triggers notifications. This slows user performance.
	$g_email_send_using_cronjob = OFF;
	
	# Specify whether e-mails should be sent with the category set or not. This is tested
	# with Microsoft Outlook. More testing for this feature + other formats will be added
	# in the future.
	# OFF, EMAIL_CATEGORY_PROJECT_CATEGORY (format: [Project] Category)
	$g_email_set_category	 = OFF;
	
	# --- email separator and padding ------------
	$g_email_separator1	 = str_pad('', 70, '=');
	$g_email_separator2	 = str_pad('', 70, '-');
	$g_email_padding_length	= 28;
	
	#############################
?>
