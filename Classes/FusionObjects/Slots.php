<?php

namespace Beromir\Slots\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class Slots extends AbstractFusionObject
{

    /**
     * @return string
     */
    public function evaluate(): string
    {
        $source = $this->fusionValue('source') ?? '';
        $target = $this->fusionValue('target') ?? '';

        return $this->fillSlots($source, $target);
    }

    /**
     * @param string $source
     * @param string $target
     * @return string
     */
    protected function fillSlots(string $source, string $target): string
    {
        $slots = [];

        // get all slots from the source HTML
        preg_match_all('@.*<x-slot\s*target="(.*)".*>(.*)</x-slot>.*@sU', $source, $slots, PREG_SET_ORDER);
        // remove all slots from the source HTML. The rest is the default slot
        $defaultSlot = preg_replace('@<x-slot\s*target=".*".*>.*</x-slot>@sU', '', $source);

        foreach ($slots as $slot) {
            // replace the named slots in the target HTML with the corresponding HTML from the source
            $target = preg_replace('@<x-slot\s*name="' . $slot[1] . '".*(/>|>.*</x-slot>)@sU', $slot[2], $target, 1);
        }

        if (str_contains($target, '<x-slot')) {
            // fill the default slot, if it exists
            $target = preg_replace('@<x-slot\s*(/>|>.*</x-slot>)@sU', $defaultSlot, $target, 1);
            // fill the remaining slots with their default content, if available
            $target = preg_replace('@<x-slot(\s*name=".*".*|)>(.*)</x-slot>@sU', '$2', $target);
            // remove the remaining slots
            $target = preg_replace('@<x-slot\s*(name=".*".*|)/>@sU', '', $target);
        }

        return $target;
    }
}
