<?php

namespace App\Twig;

use App\Entity\Media;
use App\Repository\MediaRepository;
use Twig\Extension\AbstractExtension;
use Vich\UploaderBundle\Entity\File;

class CmsImageExtension extends AbstractExtension
{
    private $mediaRepository;
    private $bannersPath;

    public function __construct(
        MediaRepository $mediaRepository,
        string $bannersPath
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->bannersPath = $bannersPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('cms_image_path', [$this, 'getImagePath']),
        ];
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function getImagePath(string $key)
    {
        $media = $this->mediaRepository->findOneByFileKey($key);

        if (!$this->mediaIsValid($media)) {
            return sprintf('build/img/slide/%d.jpg', rand(1,3));
        }

        return $this->bannersPath . DIRECTORY_SEPARATOR . $media->getImage()->getName();
    }

    private function mediaIsValid(Media $media): bool
    {
        return $media instanceof Media && $media->getImage() instanceof File && $media->getImage()->getName() !== null;
    }
}
