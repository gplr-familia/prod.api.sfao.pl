<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity()
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"notification", "notification-read"}},
 *     "denormalization_context"={"groups"={"notification", "notification-write"}},
 *     "filters"={"notification.date_filter", "notification.order_filter", "notification.created_for_filter", "global.id_filter", "global.user_filter", "notification.status_filter"}
 * })
 */
class Notification
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_DECLINED = 'DECLINED';

    const TYPE_INFO = 'INFO';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"notification-read"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @Groups({"notification"})
     * @ORM\Column(name="at", type="datetime")
     */
    private $at;

    /**
     * @var string
     *
     * @Groups({"notification"})
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @Groups({"notification"})
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var User
     *
     * @Groups({"notification"})
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var array
     *
     * @Groups({"notification"})
     * @ORM\Column(name="metadata", type="json", length=255)
     */
    private $metadata;

    /**
     * @var string
     *
     * @Groups({"notification"})
     * @ORM\Column(name="created_for", type="string", length=255)
     */
    private $createdFor;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"notification"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"notification-read"})
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
     * @param \DateTime $at
     *
     * @return Notification
     */
    public function setAt($at)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * Get at.
     *
     * @return \DateTime
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Notification
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

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Notification
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set metadata.
     *
     * @param array $metadata
     *
     * @return Notification
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata.
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set created.
     *
     * @param \DateTime|null $created
     *
     * @return Notification
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
     * @return Notification
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
     * Set createdFor.
     *
     * @param string $createdFor
     *
     * @return Notification
     */
    public function setCreatedFor($createdFor)
    {
        $this->createdFor = $createdFor;

        return $this;
    }

    /**
     * Get createdFor.
     *
     * @return string
     */
    public function getCreatedFor()
    {
        return $this->createdFor;
    }
}
