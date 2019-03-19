<?php

namespace luya\headless\modules\admin\models;

use luya\headless\base\BaseModel;
use luya\headless\ActiveEndpoint;
use luya\headless\Exception;
use luya\headless\endpoint\ActiveEndpointRequest;
use luya\headless\tests\ApiAdminUser;
use luya\headless\Client;

/**
 * Admin Storage File Model.
 *
 * @property ApiSotrageImage $images An array with image objects.
 * @property ApiAdminUser $user The user object
 * @property boolean $isImage
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ApiStorageFile extends ActiveEndpoint
{
    public $id;
    public $is_hidden;
    public $folder_id;
    public $name_original;
    public $new_new;
    public $new_new_compound;
    public $mime_type;
    public $extension;
    public $hash_file;
    public $hash_name;
    public $upload_timestamp;
    public $file_size;
    public $upload_user_id;
    public $is_deleted;
    public $passtrough_file;
    public $passtrough_file_password;
    public $passtrough_file_stats;
    public $inline_disposition;
    public $source;
    public $caption;
    public $captions; // an array with caption for a given language key as array.

    // expand
    public $sizeReadable;
    public $isImage;

    private $_imageMimeTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];

    /**
     * @inheritDoc
     */
    public function getEndpointName()
    {
        return '{{%api-admin-storage}}';
    }

    /**
     * @inheritDoc
     */
    public static function find()
    {
        throw new Exception("find() is not supported.");
    }

    /**
     * @inheritDoc
     */
    public static function view($id)
    {
        return (new ActiveEndpointRequest(new static))->setEndpoint('{endpointName}/file')->setDefaultExpand(['source'])->setArgs(['id' => $id]);
    }

    /**
     * Create an image version of a file.
     *
     * @param integer $filterId
     * @param Client $client
     * @return ApiStorageImage|boolean False if unable to create
     * @since 1.2.0
     */
    public function createImage($filterId, Client $client)
    {
        return ApiStorageImage::createImage($this->id, $filterId, $client);
    }

    private $_images = [];

    /**
     * Setter methods for images
     *
     * @param array $images
     */
    public function setImages($images)
    {
        $this->_images = (array) $images;
    }

    /**
     * Getter methods for images
     * 
     * @return ApiStorageImage
     * @since 1.2.0
     */
    public function getImages()
    {
        return ApiStorageImage::iterator($this->_images);
    }

    private $_user;

    /**
     * Setter image for user
     *
     * @param array $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * Getter method for user
     * 
     * @return ApiAdminUser
     */
    public function getUser()
    {
        return new ApiAdminUser($this->_user);
    }

    

        /**
     * Whether the file is of type image or not.
     *
     * If the mime type of the files is equals to:
     *
     * + `image/gif`
     * + `image/jpeg`
     * + `image/jpg`
     * + `image/png`
     * + `image/bmp`
     * + `image/tiff`
     *
     * The file indicates to be an image and return value is true.
     *
     * @return boolean Whether the file is of type image or not.
     * @since 1.2.0
     */
    public function getIsImage()
    {
        return in_array($this->mime_type, $this->_imageMimeTypes);
    }
}
