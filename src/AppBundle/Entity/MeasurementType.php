<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * MeasurementType
 *
 * @ORM\Table(name="measurement_type")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"measurement_type", "measurement_type-read"}},
 *     "denormalization_context"={"groups"={"measurement_type", "measurement_type-write"}},
 *     "filters"={"global.id_filter"}
 * })
 */
class MeasurementType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"measurement_type"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"measurement_type"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255)
     * @Groups({"measurement_type"})
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=30, nullable=true)
     * @Groups({"measurement_type"})
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7)
     * @Groups({"measurement_type"})
     */
    private $color;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"measurement_type"})
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Measurement", mappedBy="type")
     */
    private $measurements;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recommendation", mappedBy="type")
     */
    private $recommendations;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MediaObject")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"measurement_type"})
     */
    private $attachment;

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
     * Set name
     *
     * @param string $name
     *
     * @return MeasurementType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set unit
     *
     * @param string $unit
     *
     * @return MeasurementType
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->measurements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add measurement
     *
     * @param \AppBundle\Entity\Measurement $measurement
     *
     * @return MeasurementType
     */
    public function addMeasurement(\AppBundle\Entity\Measurement $measurement)
    {
        $this->measurements[] = $measurement;

        return $this;
    }

    /**
     * Remove measurement
     *
     * @param \AppBundle\Entity\Measurement $measurement
     */
    public function removeMeasurement(\AppBundle\Entity\Measurement $measurement)
    {
        $this->measurements->removeElement($measurement);
    }

    /**
     * Get measurements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeasurements()
    {
        return $this->measurements;
    }

    /**
     * Add recommendation
     *
     * @param \AppBundle\Entity\Recommendation $recommendation
     *
     * @return MeasurementType
     */
    public function addRecommendation(\AppBundle\Entity\Recommendation $recommendation)
    {
        $this->recommendations[] = $recommendation;

        return $this;
    }

    /**
     * Remove recommendation
     *
     * @param \AppBundle\Entity\Recommendation $recommendation
     */
    public function removeRecommendation(\AppBundle\Entity\Recommendation $recommendation)
    {
        $this->recommendations->removeElement($recommendation);
    }

    /**
     * Get recommendations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }

    /**
     * Set attachment.
     *
     * @param \AppBundle\Entity\MediaObject|null $attachment
     *
     * @return MeasurementType
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return MeasurementType
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return MeasurementType
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set icon.
     *
     * @param string $icon
     *
     * @return MeasurementType
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
