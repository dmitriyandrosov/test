<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Sorting;

use Admin\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class ByAssignedMembers
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Sorting
 */
class ByAssignedMembers implements ISortable
{
    private Collection $stylists;

    private Collection $sortedStylists;

    /**
     * ByAssignedMembers constructor.
     *
     * @param Collection $stylists
     */
    public function __construct(Collection $stylists)
    {
        $this->stylists = $stylists;

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
        $this->sortedStylists = $this->stylists->sort(function (Employee $stylistA, Employee $stylistB) {
            $stylistAMembersCount = $stylistA->members->count();
            $stylistBMembersCount = $stylistB->members->count();

            if ($stylistAMembersCount === $stylistBMembersCount) {
                return 0;
            }

            return $stylistAMembersCount > $stylistBMembersCount ? 1 : -1;
        });
    }
}