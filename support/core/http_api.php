<?php
# MantisBT - a php based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * API for managing HTTP response headers and transactions.
 * @package CoreAPI
 * @subpackage HTTPAPI
 * @copyright Copyright (C) 2002 - 2009  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */

/**
 * Set caching headers that will allow or prevent browser caching.
 * @param boolean Allow caching
 */
function http_caching_headers( $p_allow_caching=false ) {
	global $g_allow_browser_cache;

	// Basic browser detection
	$t_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'none';

	$t_browser_name = 'Normal';
	if ( strpos( $t_user_agent, 'MSIE' ) ) {
		$t_browser_name = 'IE';
	}

	// Headers to prevent caching
	//  with option to bypass if running from script
	if ( !