<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Aws\S3\S3Client;
use Aws\Sdk;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AmazonController
 * This controller is to show off some basic integration functions with Amazon S3
 *
 * @author Jason Marchalonis
 * @since 1.0
 * @package App\Http\Controllers\Api
 * @property Controller $this
 */
class AmazonController extends Controller
{
    /**
     * @var S3Client $s3
     */
    private $s3;
    private $bucket = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     * @since 1.0
     * @author Jason Marchalonis
     */
    public function __construct()
    {
        $sharedConfig = [
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => config('services.aws.key'),
                'secret' => config('services.aws.secret')
            ]
        ];

        // Attach the S3 Client to the Controller and set the bucket as well
        $this->setS3Client(new S3Client($sharedConfig));
        $this->setBucket('boalt');
    }

    /**
     * Get Bucket
     * This is a getter function for the bucket property
     *
     * @return string
     * @since 1.0
     * @author Jason Marchalonis
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Set Bucket
     * This is a setter function for the bucket property
     *
     * @param $value
     * @return string
     * @since 1.0
     * @author Jason Marchalonis
     */
    public function setBucket($value)
    {
        $this->bucket = $value;
    }

    /**
     * Get S3 Client
     * This is a getter function for the Amazon s3 Client property
     *
     * @return string
     * @since 1.0
     * @author Jason Marchalonis
     */
    public function getS3Client()
    {
        return $this->s3;
    }

    /**
     * Set S3 Client
     * This is a setter function for the  Amazon s3 Client property
     *
     * @param $value
     * @return string
     * @since 1.0
     * @author Jason Marchalonis
     */
    public function setS3Client($value)
    {
        $this->s3 = $value;
    }

    /**
     * List Bucket Objects
     * This function is used to retrieve a list of all objects in the requested bucket
     *
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function listBucketObjects(Request $request)
    {
        $objects = $this->getS3Client()->listObjects([
            'Bucket' => $this->getBucket(),
            'MaxKeys' => 5
        ]);

        if (empty($objects->get('Contents'))) {
            return response(['message' => __('No objects were found in the bucket')]);
        }

        return $this->setApiResponse(['user' => $objects->get('Contents')]);
    }

    /**
     * Create Object
     * This function is used to upload/create a new object in the s3 bucket.
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     * @todo This is just a sample, but we should save the response data to a database
     *
     */
    public function createObject(Request $request)
    {
        $data = $request->validate([
            'key' => 'required',
            'file' => 'required',
        ]);

        $extension = $request->file('file')->extension();

        // Upload File to the bucket
        $result = $this->getS3Client()->putObject([
            'Bucket' => $this->getBucket(),
            'Key' => uniqid($this->getBucket() . '_') . '.' . $extension,
            'SourceFile' => $request->file('file'),
            'ACL' => 'public-read',
        ]);

        return $this->setApiResponse(['file' => $result['ObjectURL']]);
    }

    /**
     * Delete Object
     * This function is used to delete an object in the s3 bucket.
     *
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     * @author Jason Marchalonis
     * @todo This is just a sample, but we would also remove or may inactive the record for the a database
     *
     * @since 1.0
     */
    public function deleteObject(Request $request)
    {
        $validate_key = false;
        $data = $request->validate([
            'key' => 'required',
            'validate_key' => 'nullable|bool'
        ]);

        // Overwrite the default value if is valid and set
        if (isset($data['validate_key'])) {
            $validate_key = $data['validate_key'];
        }

        /* If we validate the key, we must make sure that the key exists before removal from S3,
           We can also use this to loop and remove objects that are folders if we wanted to with small
           modifications ( remove line 199 )
        */
        if ($validate_key == true) {
            $results = $this->getS3Client()->listObjectsV2([
                'Bucket' => $this->getBucket(),
            ]);

            // Check the key exists among the retrieved bucket objects
            if (isset($results['Contents'])) {
                $file_confirmed_removed = false;
                foreach ($results['Contents'] as $result) {

                    if ($result['Key'] == $data['key']) {
                        $this->getS3Client()->deleteObject([
                            'Bucket' => $this->getBucket(),
                            'Key' => $result['Key']
                        ]);
                        $file_confirmed_removed = true;
                    }
                }
                if ($file_confirmed_removed == true) {
                    return $this->setApiResponse(true);
                }
            }
            return response(['message' => __('The requested object was not found in the bucket')]);
        }

        /*
            We can handle non-validated delete requests here. If the object is found we remove it.
            We do not do additional processing in this case
        */
        $result = $this->s3->deleteObject([
            'Bucket' => $this->getBucket(),
            'Key' => $data['key'],
        ]);

        return $this->setApiResponse(true);
    }

}
