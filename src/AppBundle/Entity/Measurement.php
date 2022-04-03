<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Measurement
 *
 * @ORM\Table(name="measurement")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"measurement", "measurement-read"}},
 *     "denormalization_context"={"groups"={"measurement", "measurement-write"}},
 *     "filters"={"measurement.order_filter", "measurement.search_filter", "measurement.date_filter", "measurement.user_in_group_filter", "global.id_filter", "global.user_filter"}
 * })
 */
class Measurement
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"measurement", "user"})
     */
    private $id;

    /**
     * @var float
     *
     * @Groups({"measurement"})
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="measurements")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"measurement"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MeasurementType", inversedBy="measurements")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @Groups({"measurement"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Device", inversedBy="measurements")
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id")
     * @Groups({"measurement"})
     */
    private $device;

    /**
     * @var \DateTime $at
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"measurement"})
     */
    private $at;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"measurement"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"measurement-read"})
     */
    private $updated;

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
     * @return Measurement
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
     * @return Measurement
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
     * @return Measurement
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param \DateTime $updated
     *
     * @return Measurement
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
     * Set type
     *
     * @param \AppBundle\Entity\MeasurementType $type
     *
     * @return Measurement
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
     * Set device.
     *
     * @param \AppBundle\Entity\Device|null $device
     *
     * @return Measurement
     */
    public function setDevice(\AppBundle\Entity\Device $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device.
     *
     * @return \AppBundle\Entity\Device|null
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set at.
     *
     * @param \DateTime|null $at
     *
     * @return Measurement
     */
    public function setAt($at = null)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * Get at.
     *
     * @return \DateTime|null
     */
    public function getAt()
    {
        return $this->at;
    }
}
