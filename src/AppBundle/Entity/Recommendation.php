<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Recommendation
 *
 * @ORM\Table(name="recommendation")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"recommendation", "recommendation-read"}},
 *     "denormalization_context"={"groups"={"recommendation", "recommendation-write"}},
 *     "filters"={"recommendation.order_filter", "recommendation.search_filter", "recommendation.date_filter", "global.id_filter", "global.user_filter", "recommendation.user_in_group_filter"}
 * })
 */
class Recommendation
{
    const STATUS_EVALUATE = 'EVALUATE';
    const STATUS_DONE = 'DONE';
    const STATUS_NOT_DONE = 'NOT_DONE';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"recommendation", "user"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MeasurementType", inversedBy="measurements")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @Groups({"recommendation"})
     */
    private $type;

    /**
     * @var float
     *
     * @Groups({"recommendation"})
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="recommendations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"recommendation"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="id")
     * @Groups({"recommendation"})
     */
    private $createdBy;

    /**
     * @var \DateTime $at
     *
     * @ORM\Column(type="datetime")
     * @Groups({"recommendation"})
     */
    private $at;

    /**
     * @var \DateTime $ends
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"recommendation"})
     */
    private $ends;

    /**
     * @var bool $wholeDay
     *
     * @ORM\Column(type="boolean")
     * @Groups({"recommendation"})
     */
    private $wholeDay;

    /**
     * @var array $recurringDayOfWeek
     *
     * @ORM\Column(type="array")
     * @Groups({"recommendation"})
     */
    private $recurringDayOfWeek;

    /**
     * @var \DateTime $recurringFrom
     *
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"recommendation"})
     */
    private $recurringFrom;

    /**
     * @var \DateTime $recurringTo
     *
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"recommendation"})
     */
    private $recurringTo;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=255)
     * @Groups({"recommendation"})
     */
    private $status;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"recommendation"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"recommendation-read"})
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MediaObject")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"recommendation"})
     */
    private $attachment;

    public function __construct()
    {
        $this->wholeDay = false;
        $this->recurringDayOfWeek = [];
        $this->status = self::STATUS_EVALUATE;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Recommendation
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $user
     *
     * @return Recommendation
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \DateTime $created
     *
     * @return Recommendation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param \DateTime $updated
     *
     * @return Recommendation
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set at
     *
     * @param \DateTime $at
     *
     * @return Recommendation
     */
    public function setAt($at)
    {
        $this->at = $this->ends = $at;

        return $this;
    }

    /**
     * Get at
     *
     * @return \DateTime
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\MeasurementType $type
     *
     * @return Recommendation
     */
    public function setType(\AppBundle\Entity\MeasurementType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\MeasurementType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set ends.
     *
     * @param \DateTime $ends
     *
     * @return Recommendation
     */
    public function setEnds($ends)
    {
        $this->ends = $ends;

        return $this;
    }

    /**
     * Get ends.
     *
     * @return \DateTime
     */
    public function getEnds()
    {
        return $this->ends;
    }

    /**
     * Set wholeDay.
     *
     * @param bool $wholeDay
     *
     * @return Recommendation
     */
    public function setWholeDay($wholeDay)
    {
        $this->wholeDay = $wholeDay;

        return $this;
    }

    /**
     * Get wholeDay.
     *
     * @return bool
     */
    public function getWholeDay()
    {
        return $this->wholeDay;
    }

    /**
     * Set recurringDayOfWeek.
     *
     * @param array $recurringDayOfWeek
     *
     * @return Recommendation
     */
    public function setRecurringDayOfWeek($recurringDayOfWeek)
    {
        $this->recurringDayOfWeek = $recurringDayOfWeek;

        return $this;
    }

    /**
     * Get recurringDayOfWeek.
     *
     * @return array
     */
    public function getRecurringDayOfWeek()
    {
        return $this->recurringDayOfWeek;
    }

    /**
     * Set recurringFrom.
     *
     * @param \DateTime $recurringFrom
     *
     * @return Recommendation
     */
    public function setRecurringFrom($recurringFrom)
    {
        $this->recurringFrom = $recurringFrom;

        return $this;
    }

    /**
     * Get recurringFrom.
     *
     * @return \DateTime
     */
    public function getRecurringFrom()
    {
        return $this->recurringFrom;
    }

    /**
     * Set recurringTo.
     *
     * @param \DateTime $recurringTo
     *
     * @return Recommendation
     */
    public function setRecurringTo($recurringTo)
    {
        $this->recurringTo = $recurringTo;

        return $this;
    }

    /**
     * Get recurringTo.
     *
     * @return \DateTime
     */
    public function getRecurringTo()
    {
        return $this->recurringTo;
    }

    /**
     * Set createdBy.
     *
     * @param \AppBundle\Entity\User|null $createdBy
     *
     * @return Recommendation
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set attachment.
     *
     * @param \AppBundle\Entity\MediaObject|null $attachment
     *
     * @return Recommendation
     */
    public function setAttachment(\AppBundle\Entity\MediaObject $attachment = null)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment.
     *
     * @return \AppBundle\Entity\MediaObject|null
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Recommendation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
