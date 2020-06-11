<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes;

use Illuminate\Support\Collection;
use Admin\Services\StylistDesk\Stylist\Classes\Sorting\ByCombinedCriteria;

/**
 * Class StylistSorter
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes
 */
class StylistSorter
{
    private Collection $stylists;

    private Collection $sortedStylists;

    /**
     * StylistSorter constructor.
     *
     * @param Collection $stylists
     */
    public function __construct(Collection $stylists)
    {
        $this->stylists = $stylists;

        $this->sortedStylists = new Collection;

        $this->sort();
    }

    /**
     * @return Collection
     */
    public function getSorted(): Collection
    {
        return $this->sortedStylists;
    }

    /**
     * @return void
     */
    private function sort(): void
    {
        $this->sortedStylists = (new ByCombinedCriteria($this->stylists))->getSorted();
    }
}