<?php 

class SignUrl 
{
	
	/**
	 *  @const 	KEY_PAID_ID 				The AWS Key Pair ID
	 *  @const 	STREAMING_URL 				The AWS CloudFront Domain Name (eg. abc123.cloudfront.net) 
	 *  @const 	CLOUDFRONT_PRIVATE_PEM_LOCATION 	Location to your private .pem file provided by AWS. 
	 */
	const KEY_PAIR_ID = 'ABCDEFGHIJKLMNOPQRST';
	const STREAMING_URL = 'https://abc123.cloudfront.net/';		// Requires http(s):// and the trailing slash
	const CLOUDFRONT_PRIVATE_PEM_LOCATION = '/home/.aws/CloudFront-Private-File.pem'; // The exact location of the .pem file
	
	/**
	 *  @var	$signer		The AWS Signer class. Stored here to call on in the future. 
	 */
	static $signer;
	
	// Set the signer class. Used so this isn't set more than once.
	protected static function setSigner( $key_pair_id_string = self::KEY_PAIR_ID ) {

		if(!self::$signer) {
			self::$signer = new Aws\CloudFront\UrlSigner( $key_pair_id_string, CLOUDFRONT_PRIVATE_PEM_LOCATION );	
		}

		return self::$signer;
	}
	
	/**
	 *  @param  string  	$full_url                  	The URL of the S3 Object to sign. 
	 *  @param  int   	$expires_in_seconds_int   	When should this file expire (in seconds). Default is 5 minutes (300s)
	 *  @param  string  	$custom_key_pair_id_string	Optional if you want to use a different Key Pair ID from the @const
	 *  
	 *  @return string	Returns the signed URL.
	 */
	static function Sign( $full_url, $expires_in_seconds_int = 300, $custom_key_pair_id_string = self::KEY_PAIR_ID ) {
		
		// If the URL is empty return empty. Let the data flow through this and let other areas handle empty URLs. 
		if(empty($full_url)) {
			return $full_url;
		}
		
		// If the $signer is not set, set it now. 
		if(!self::$signer) {
			// Always set the signer. Or return the signer if it's set already. 
			self::setSigner( $custom_key_pair_id_string );
		}
		
		$url = self::$signer->getSignedUrl( $full_url, time() + $expires_in_seconds_int);
		
		return $url;
	}
	
}

?>
