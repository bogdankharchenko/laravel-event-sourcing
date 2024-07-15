<?php

namespace Spatie\EventSourcing\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CarbonNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalize($object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        if (! $object instanceof CarbonInterface) {
            throw new InvalidArgumentException('Cannot serialize an object that is not a CarbonInterface in CarbonNormalizer.');
        }

        return $object->toRfc3339String();
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @inheritdoc
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof CarbonInterface;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, $class, string $format = null, array $context = []): mixed
    {
        return Date::parse($data);
    }


    public function supportsDenormalization($data, $type, string $format = null, array $context = []): bool
    {
        return is_a($type, CarbonInterface::class, true);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [CarbonInterface::class => false];
    }
}
