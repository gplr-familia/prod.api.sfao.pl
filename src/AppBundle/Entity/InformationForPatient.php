<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InformationForPatient
 *
 * @ORM\Table(name="information_for_patient")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"information_for_patient", "information_for_patient-read"}},
 *     "denormalization_context"={"groups"={"information_for_patient", "information_for_patient-write"}},
 *     "filters"={"global.id_filter"}
 * })
 */
class InformationForPatient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"information_for_patient-read"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"information_for_patient"})
     */
    private $description;

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="informationForPatient")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"information_for_patient"})
     */
    private $user;

    /**
     * @var \DateTime $at
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"information_for_patient"})
     */
    private $at;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"information_for_patient"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MediaObject")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"information_for_patient"})
     */
    private $attachment;

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
     * Set description.
     *
     * @param string|null $description
     *
     * @return InformationForPatient
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
     * Set created.
     *
     * @param \DateTime|null $created
     *
     * @return InformationForPatient
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
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return InformationForPatient
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set attachment.
     *
     * @param \AppBundle\Entity\MediaObject|null $attachment
     *
     * @return InformationForPatient
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
     * Set at.
     *
     * @param \DateTime|null $at
     *
     * @return InformationForPatient
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
     * Set updated.
     *
     * @param \DateTime|null $updated
     *
     * @return InformationForPatient
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
}
