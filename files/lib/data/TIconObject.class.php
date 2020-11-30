<?php

namespace theia\data;

trait TIconObject {
    protected $iconSize = [
        16 => 'icon16',
        24 => 'icon24',
        32 => 'icon32',
        64 => 'icon64',
        96 => 'icon96',
        128 => 'icon128',
        144 => 'icon144',
    ];

    /**
     * Return valid icon classes.
     * @param int $size
     * @return string
     */
    protected function getIconSizeClass(int $size): string
    {
        // Icon size is icon class.
        if (isset($this->iconSize[$size])) {
            return $this->iconSize[$size];
        }

        if ($size > 144) {
            return $this->iconSize[144];
        }

        $sizeKeys = array_keys($this->iconSize);
        foreach ($sizeKeys as $availableSize) {
            if ($availableSize > $size) {
                return $this->iconSize[$availableSize];
            }
        }
    }
}
