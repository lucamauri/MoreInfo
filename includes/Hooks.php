<?php

namespace MoreInfo;

use MediaWiki\MediaWikiServices;

class Hooks {
	
	/**
	 * Register the SERVERIP magic word
	 *
	 * @param array &$variableIDs Array of magic word IDs
	 */
	public static function onMagicWordwgVariableIDs( &$variableIDs ) {
		$variableIDs[] = 'serverip';
		return true;
	}

	/**
	 * Provide the value for the SERVERIP magic word
	 *
	 * @param \Parser $parser MediaWiki parser object
	 * @param array &$cache Cache array
	 * @param string $magicWordId ID of the magic word
	 * @param string &$ret Return value
	 */
	public static function onParserGetVariableValueSwitch( $parser, &$cache, $magicWordId, &$ret ) {
		if ( $magicWordId === 'serverip' ) {
			$ret = self::getServerPublicIP();
			return true;
		}
		return true;
	}

	/**
	 * Get the server's public IP address
	 *
	 * @return string Server's public IP address
	 */
	private static function getServerPublicIP() {
		// Method 1: Try to get from $_SERVER variables
		$possibleKeys = [
			'SERVER_ADDR',
			'LOCAL_ADDR',
			'HTTP_X_FORWARDED_FOR',
			'REMOTE_ADDR'
		];

		foreach ( $possibleKeys as $key ) {
			if ( isset( $_SERVER[$key] ) && !empty( $_SERVER[$key] ) ) {
				$ip = $_SERVER[$key];
				// Clean up if multiple IPs are present (X-Forwarded-For case)
				if ( strpos( $ip, ',' ) !== false ) {
					$ips = explode( ',', $ip );
					$ip = trim( $ips[0] );
				}
				// Validate it's a proper IP
				if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 ) ) {
					return $ip;
				}
			}
		}

		// Method 2: Fallback - try to get via external service (cached)
		// This is optional and should be used cautiously in production
		return self::getServerIPFallback();
	}

	/**
	 * Fallback method to get server IP via external service
	 *
	 * @return string IP address or error message
	 */
	private static function getServerIPFallback() {
		// Check if we have a cached value
		$cache = MediaWikiServices::getInstance()->getMainWANObjectCache();
		$cacheKey = $cache->makeKey( 'moreinfo', 'serverip' );

		$cachedIP = $cache->get( $cacheKey );
		if ( $cachedIP !== false ) {
			return $cachedIP;
		}

		// Try to get IP from external service with security measures
		$ip = self::fetchExternalIP();

		// Cache for 24 hours
		$cache->set( $cacheKey, $ip, 86400 );

		return $ip;
	}

	/**
	 * Fetch server IP from external service with security measures
	 *
	 * @return string IP address or error message
	 */
	private static function fetchExternalIP() {
		$services = [
			'https://api.ipify.org',
			'https://ipv4.icanhazip.com',
			'https://checkip.amazonaws.com'
		];

		foreach ( $services as $service ) {
			$context = stream_context_create([
				'http' => [
					'timeout' => 5, // 5 second timeout
					'method' => 'GET',
					'header' => 'User-Agent: MoreInfo-MediaWiki-Extension/1.0'
				],
				'ssl' => [
					'verify_peer' => true,
					'verify_peer_name' => true
				]
			]);

			$result = @file_get_contents( $service, false, $context );
			if ( $result !== false ) {
				$ip = trim( $result );
				if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 ) ) {
					return $ip;
				}
			}
		}

		return 'Unable to determine server IP';
	}
}
