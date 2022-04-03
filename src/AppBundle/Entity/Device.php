<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Device
 *
 * @ORM\Table(name="device")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"device", "device-read"}},
 *     "denormalization_context"={"groups"={"device", "device-write"}},
 *     "filters"={"global.id_filter"}
 * })
 */
class Device
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"device"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"device"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Groups({"device"})
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Measurement", mappedBy="device")
     */
    private $measurements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->measurements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Device
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add measurement.
     *
     * @param \AppBundle\Entity\Measurement $measurement
     *
     * @return Device
     */
    public function addMeasurement(\AppBundle\Entity\Measurement $measurement)
    {
        $this->measurements[] = $measurement;

        return $this;
    }

    /**
     * Remove measurement.
     *
     * @param \AppBundle\Entity\Measurement $measurement
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMeasurement(\AppBundle\Entity\Measurement $measurement)
    {
        return $this->measurements->removeElement($measurement);
    }

    /**
     * Get measurements.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeasurements()
    {
        return $this->measurements;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Device
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
