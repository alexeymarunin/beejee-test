<?php

namespace app\components;
use app\models\Media;

/**
 * Класс Library
 *
 * @package app\components
 */
class Library
{
    /**
     * @var string
     */
    public $uploadPath;

    /**
     * @var int
     */
    public $maxSize;

    /**
     * @var array
     */
    public $mimeType;

    /**
     * @var array
     */
    public $resizeTo;

    /**
     * @var int
     */
    public $minWidth;

    /**
     * @var int
     */
    public $maxWidth;

    /**
     * @var int
     */
    public $minHeight;

    /**
     * @var int
     */
    public $maxHeight;

    /**
     * @var Application
     */
    protected $app;


    /**
     * Library constructor.
     *
     * @param $config
     */
    public function __construct( $app, $config )
    {
        $this->app = $app;

        $this->uploadPath = $config['uploadPath'];
        $this->maxSize = $config['maxSize'];
        $this->mimeType = $config['mimeType'];
        $this->resizeTo = $config['resizeTo'];
        $this->minWidth = $config['minWidth'];
        $this->maxWidth = $config['maxWidth'];
        $this->minHeight = $config['minHeight'];
        $this->maxHeight = $config['maxHeight'];
    }

    /**
     * @param string $name
     *
     * @return Media|null
     */
    public function uploadImage( $name )
    {
        $factory = new \FileUpload\FileUploadFactory(
            new \FileUpload\PathResolver\Simple( $this->uploadPath ),
            new \FileUpload\FileSystem\Simple(),
            [
                new \FileUpload\Validator\MimeTypeValidator( $this->mimeType ),
                new \FileUpload\Validator\SizeValidator( $this->maxSize ),
//                new \FileUpload\Validator\DimensionValidator( [
//                    'min_width'  => $this->minWidth,
//                    'max_width'  => $this->maxWidth,
//                    'min_height' => $this->minHeight,
//                    'max_height' => $this->maxHeight,
//                ] ),
            ]
        );

        $uploader = $factory->create( $_FILES[ $name ], $_SERVER );

        $nameGenerator = new \FileUpload\FileNameGenerator\Random();
        $uploader->setFileNameGenerator( $nameGenerator );

        $uploader->processAll();

        $media = new Media( $this->app->getDb() );
        foreach ( $uploader->getFiles() as $file ) {
            if ( $file->error ) {
                $media->addError( 'filename', $file->error );
                return $media;
            };

            $filePath = $file->getRealPath();
            $image = new \Eventviva\ImageResize( $filePath );
            $image->resizeToBestFit( $this->resizeTo[0], $this->resizeTo[1] );
            $image->save( $filePath );

            $imageInfo = getimagesize( $filePath );

            $media->size = $file->getSize();
            $media->mime_type = $file->getMimeType();
            $media->filename = '/' . $file->getFilename();
            $media->width = $imageInfo[0];
            $media->height = $imageInfo[1];

            $media->save( false );
            /*
            $row = $this->app->getDb()->media()->where([
                'size = ' . $media->size,
                'width = ' . $media->width,
                'height = ' . $media->height,
                'mime_type = ' . $media->mime_type,
            ])->fetch();
            if ( $row ) {
                // Если такой файл уже загружался, то используем его вновь
                $media->load( $row->getData() );
            }
            */
            return $media;
        }

        return null;
    }
}
