<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Device
 *
 * @ORM\Table(name="appointment")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"appointment", "appointment-read"}},
 *     "denormalization_context"={"groups"={"appointment", "appointment-write"}},
 *     "filters"={"global.id_filter", "appointment.search_filter"}
 * })
 */
class Appointment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"appointment-read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="appointments")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     * @Groups({"appointment"})
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="visits")
     * @ORM\JoinColumn(name="doctor_id", referencedColumnName="id")
     * @Groups({"appointment"})
     */
    private $doctor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"appointment"})
     */
    private $description;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"appointment"})
     */
    private $at;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"appointment-read"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"appointment-read"})
     */
    private $updated;

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
     * Set at.
     *
     * @param \DateTime|null $at
     *
     * @return Appointment
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

    /**
     * Set created.
     *
     * @param \DateTime|null $created
     *
     * @return Appointment
     */
    public function setCreated($created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime|null
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime|null $updated
     *
     * @return Appointment
     */
    public function setUpdated($updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set patient.
     *
     * @param \AppBundle\Entity\User|null $patient
     *
     * @return Appointment
     */
    public function setPatient(\AppBundle\Entity\User $patient = null)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set doctor.
     *
     * @param \AppBundle\Entity\User|null $doctor
     *
     * @return Appointment
     */
    public function setDoctor(\AppBundle\Entity\User $doctor = null)
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * Get doctor.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Appointment
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
}
