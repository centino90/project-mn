<?php

class Image
{
    const IMAGE_ROOT = DOCROOT . '/public/img/profiles/';
    const IMAGE_THUMBNAIL_ROOT = DOCROOT . '/public/img/profiles/thumbnails/';

    const IMAGE_DIRECTORY = 'img/profiles/';
    const IMAGE_THUMBNAIL_DIRECTORY = 'img/profiles/thumbnails/';

    public $width = 500;
    public $height = 500;
    public $quality = 25;

    public $path = '';
    public $filename = '';
    public $img = null;
    public $img_repurposed = null;
    public $file = null;


    public function __construct()
    {
    }

    public function start(string $file, string $filename)
    {
        $this->filename = $filename;
        $this->file = $file;
        $this->img = $this->create($file);

        if (is_null($this->img)) {
            throw new Error('Your file format is invalid. Follow these following file formats .jpg, .gif, .png, & .webp');
        }

        return $this;
    }

    public function repurpose(int $width, int $height)
    {
        if (!$this->img) {
            throw new Error('You need to set the img file');
        }

        $this->width = $width;
        $this->height = $height;

        // Get new dimensions
        list($width_orig, $height_orig) = getimagesize($this->file);

        $ratio_orig = $width_orig / $height_orig;

        if ($this->width / $this->height > $ratio_orig) {
            $this->width = $this->height * $ratio_orig;
        } else {
            $this->height = $this->width / $ratio_orig;
        }

        // Resampling the image 
        $image_p = imagecreatetruecolor($this->width, $this->height);
        imagefill($image_p, 0, 0, imagecolorallocate($image_p, 255, 255, 255));
        $this->img_repurposed = $image_p;

        return imagecopyresampled(
            $this->img_repurposed,
            $this->img,
            0,
            0,
            0,
            0,
            $this->width,
            $this->height,
            $width_orig,
            $height_orig
        ) ? $this : false;
    }

    public function save(string $path, int $quality)
    {
        $this->path = $path;
        $this->quality = $quality;
        header('Content-Type: image/webp');

        return imagewebp($this->img_repurposed, $this->path . $this->filename, $this->quality)
            ? $this->filename : false;
    }

    private function create($file)
    {
        $info = getimagesize($file);
        $image = '';

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($file);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($file);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($file);

        elseif ($info['mime'] == 'image/webp')
            $image = imagecreatefromwebp($file);

        return !empty($image) ? $image : null;
    }
}
