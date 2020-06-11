<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes;

use Illuminate\Support\Collection;
use Admin\Services\StylistDesk\Stylist\Classes\Filtering\ByAvailability;
use Admin\Services\StylistDesk\Stylist\Classes\Filtering\ByExplicitData;

/**
 * Class StylistFilterer
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes
 */
class StylistFilterer
{
    private Collection $stylists;

    private Collection $excludedStylists;

    private Collection $filteredStylists;

    /**
     * StylistSorter constructor.
     *
     * @param Collection $stylists
     */
    public function __construct(Collection $stylists)
    {
        $this->stylists = $stylists;

        $this->filter();
    }

    /**
     * @param Collection $excludedStylists
     *
     * @return $this
     */
    public function setExcludedStylists(Collection $excludedStylists): self
    {
        $this->excludedStylists = $excludedStylists;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFiltered(): Collection
    {
        return $this->filteredStylists;
    }

    /**
     * @return void
     */
    private function filter(): void
    {
        $this->filteredStylists = (new ByAvailability($this->stylists))->getFiltered();
        $this->filteredStylists = (
            new ByExplicitData($this->filteredStylists, $this->excludedStylists)
        )->getFiltered();
    }
}