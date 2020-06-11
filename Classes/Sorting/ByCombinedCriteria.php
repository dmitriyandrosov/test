<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Sorting;

use Admin\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class ByCombinedCriteria
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Sorting
 */
class ByCombinedCriteria implements ISortable
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
            $byAssignedMembersResult = $this->compareByAssignedMembers($stylistA, $stylistB);

            if (0 === $byAssignedMembersResult) {
                return $this->compareByRank($stylistA, $stylistB);
            }

            return $byAssignedMembersResult;
        });
    }

    /**
     * @param Employee $stylistA
     * @param Employee $stylistB
     *
     * @return int
     */
    private function compareByAssignedMembers(Employee $stylistA, Employee $stylistB): int
    {
        $stylistAMembersCount = $stylistA->members->count();
        $stylistBMembersCount = $stylistB->members->count();

        if ($stylistAMembersCount === $stylistBMembersCount) {
            return 0;
        }

        return $stylistAMembersCount > $stylistBMembersCount ? 1 : -1;
    }

    /**
     * @param Employee $stylistA
     * @param Employee $stylistB
     *
     * @return int
     */
    private function compareByRank(Employee $stylistA, Employee $stylistB): int
    {
        $stylistARank = $stylistA->rank;
        $stylistBRank = $stylistB->rank;

        if ($stylistARank === $stylistBRank) {
            return 0;
        }

        return $stylistARank > $stylistBRank ? 1 : -1;
    }
}