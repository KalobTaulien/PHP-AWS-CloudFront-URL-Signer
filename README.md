# Setup
This class requires the [AWS PHP SDK](https://github.com/aws/aws-sdk-php). Installing the AWS PHP SDK is easiest using composer. 

When you open Signer.php you will see 3 constants, make sure you edit these. They are:
`KEY_PAIR_ID` is your AWS Key Pair ID
`STREAMING_URL` is your CloudFront domain name
`CLOUDFRONT_PRIVATE_PEM_LOCATION` is the exact location of your private .pem file

## Usage
```php
<?php
	require 'vendor/autoload.php';
	require 'Signer.php';

	$location_to_s3_object = "https://s3.amazonaws.com/bucket_name/signed_file.jpg";

	// Sign an S3 object with a cloudfront URL for 10 minutes
	$SignedUrl = Signer::Sign( $location_to_s3_object, 600 );
?>
```
