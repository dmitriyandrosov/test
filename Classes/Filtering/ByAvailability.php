<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Filtering;

use Admin\Models\Employee;
use Illuminate\Support\Collection;
use Common\Services\OnlineStatus\OnlineStatusService;

/**
 * Class ByAvailability
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Filtering
 */
class ByAvailability implements IFilterable
{
    private Collection $stylists;

    private Collection $filteredStylists;

    /**
     * ByAvailability constructor.
     *
     * @param Collection $stylists
     */
    public function __construct(Collection $stylists)
    {
        $this->stylists = $stylists;

        $this->filter();
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
        $this->filteredStylists = $this->stylists->filter(function (Employee $stylist) {
            return OnlineStatusService::isStylistAuthenticatableOnline($stylist);
        });
    }
}