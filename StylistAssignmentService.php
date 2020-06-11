<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist;

use Admin\Models\User;
use Admin\Models\Employee;
use Illuminate\Support\Collection;
use Common\Services\Conversation\ConversationService;
use Admin\Services\StylistDesk\Stylist\Classes\StylistPicker;
use Admin\Services\StylistDesk\Stylist\Classes\StylistAssigner;
use Admin\Services\StylistDesk\Stylist\Exceptions\NoAvailableStylistsException;
use Admin\Services\StylistDesk\Stylist\Exceptions\AlreadyAssignedStylistException;
use Admin\Services\StylistDesk\Stylist\Exceptions\NoPrimaryStylistAssignedException;

/**
 * Class StylistAssignmentService
 *
 * @package Admin\Services\StylistDesk\Stylist
 */
class StylistAssignmentService
{
    private User $customer;

    private ?Employee $currentStylist;

    private ?Employee $targetStylist = null;

    /**
     * StylistAssignmentService constructor.
     *
     * @param User $customer
     */
    public function __construct(User $customer)
    {
        $this->customer = $customer;

        $this->currentStylist = $customer->stylist;
    }

    /**
     * @param Employee $stylist
     *
     * @return $this
     *
     * @throws AlreadyAssignedStylistException
     */
    public function setTargetStylist(Employee $stylist): self
    {
        if ($stylist->is($this->currentStylist)) {
            throw new AlreadyAssignedStylistException;
        }

        $this->targetStylist = $stylist;

        return $this;
    }

    /**
     * @return $this
     *
     * @throws AlreadyAssignedStylistException
     */
    public function searchTargetStylist(): self
    {
        $excludedStylists = (new Collection)->push($this->currentStylist);

        $targetStylist = (new StylistPicker)
            //TODO: think of how to cache already picked top stylists in case of > 1 iteration
            ->setExcludedStylists($excludedStylists)
            ->getTopStylist();

        $this->setTargetStylist($targetStylist);

        return $this;
    }

    /**
     * @return $this
     *
     * @throws NoAvailableStylistsException
     */
    public function assignActiveStylist(): self
    {
        if (!($this->targetStylist instanceof Employee)) {
            throw new NoAvailableStylistsException;
        }

        (new StylistAssigner($this->targetStylist, $this->customer))
            ->assignActiveStylistToCustomer();

        return $this;
    }

    /**
     * @return $this
     *
     * @throws NoPrimaryStylistAssignedException
     * @throws AlreadyAssignedStylistException
     */
    public function returnActiveStylist(): self
    {
        $primaryStylist = (new ConversationService)->getPrimaryStylist($this->customer);

        if (!($primaryStylist instanceof Employee)) {
            throw new NoPrimaryStylistAssignedException;
        }

        $this->setTargetStylist($primaryStylist);

        (new StylistAssigner($this->targetStylist, $this->customer))
            ->assignActiveStylistToCustomer();

        return $this;
    }
}