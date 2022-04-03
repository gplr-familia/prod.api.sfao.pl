<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * WeekSummary
 *
 * @ORM\Table(name="summary")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"summary", "summary-read"}},
 *     "denormalization_context"={"groups"={"summary", "summary-write"}},
 *     "filters"={"global.id_filter", "global.user_filter", "summary.date_filter"}
 * })
 */
class Summary
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"summary-read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="weekSummaries")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"summary"})
     */
    private $user;

    /**
     * @var \DateTime $starts
     *
     * @ORM\Column(type="date")
     * @Groups({"summary"})
     */
    private $starts;

    /**
     * @var \DateTime $ends
     *
     * @ORM\Column(type="date")
     * @Groups({"summary"})
     */
    private $ends;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"summary"})
     */
    private $description;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"summary"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"summary-read"})
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return Summary
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
     * @return Summary
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
     * @return Summary
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
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Summary
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
     * Set starts.
     *
     * @param \DateTime $starts
     *
     * @return Summary
     */
    public function setStarts($starts)
    {
        $this->starts = $starts;

        return $this;
    }

    /**
     * Get starts.
     *
     * @return \DateTime
     */
    public function getStarts()
    {
        return $this->starts;
    }

    /**
     * Set ends.
     *
     * @param \DateTime $ends
     *
     * @return Summary
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
}
