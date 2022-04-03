<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="fos_user")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"user", "user-read"}},
 *     "denormalization_context"={"groups"={"user", "user-write"}},
 *     "filters"={"user.order_filter", "global.id_filter"}
 * })
 */
class User extends BaseUser implements ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"user"})
     */
    protected $id;

    /**
     * @Groups({"user"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user", "thread-read"})
     */
    protected $fullname;

    /**
     * @Groups({"thread-read"})
     */
    private $isPatient;

    /**
     * @Groups({"user"})
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group", mappedBy="users")
     */
    protected $groups;

    /**
     * @Groups({"user"})
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Chat", mappedBy="users")
     */
    protected $chats;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user"})
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user"})
     */
    private $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user"})
     */
    private $phone;

    /**
     * @Groups({"user-write"})
     */
    protected $plainPassword;

    /**
     * @Groups({"user"})
     */
    protected $username;

    /**
     * @Groups({"user"})
     */
    protected $enabled;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Measurement", mappedBy="user")
     */
    protected $measurements;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recommendation", mappedBy="user")
     */
    protected $recommendations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DietRecommendation", mappedBy="user")
     */
    protected $dietRecommendations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Meal", mappedBy="user")
     */
    protected $meals;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PhysicalEffort", mappedBy="user")
     */
    protected $physicalEfforts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Summary", mappedBy="user")
     */
    protected $weekSummaries;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Drug", mappedBy="user")
     */
    protected $drugs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="patient")
     */
    protected $appointments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="doctor")
     */
    protected $visits;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="patients")
     * @ApiProperty(attributes={"isReadableLink"=false})
     * @Groups({"user"})
     */
    private $doctors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="doctors")
     * @ORM\JoinTable(name="doctor_patient",
     *     joinColumns={@ORM\JoinColumn(name="patient_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="doctor_id", referencedColumnName="id")}
     * )
     * @ApiProperty(attributes={"isReadableLink"=false})
     * @Groups({"user"})
     */
    private $patients;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ImagingExamination", mappedBy="user")
     */
    protected $imagingExaminations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\InformationForPatient", mappedBy="user")
     */
    protected $informationForPatient;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="user")
     */
    protected $notifications;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();
        $this->patients = new ArrayCollection();
        $this->doctors = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @param string $fullname
     *
     * @return $this
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param \FOS\UserBundle\Model\UserInterface|null $user
     *
     * @return bool
     */
    public function isUser(UserInterface $user = null)
    {
        return $user instanceof self && $user->id === $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeasurements()
    {
        return $this->measurements;
    }

    /**
     * Add measurement
     *
     * @param \AppBundle\Entity\Measurement $measurement
     *
     * @return User
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
     * Add recommendation
     *
     * @param \AppBundle\Entity\Recommendation $recommendation
     *
     * @return User
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
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add doctor
     *
     * @param \AppBundle\Entity\User $doctor
     *
     * @return User
     */
    public function addDoctor(\AppBundle\Entity\User $doctor)
    {
        $this->doctors[] = $doctor;

        return $this;
    }

    /**
     * Remove doctor
     *
     * @param \AppBundle\Entity\User $doctor
     */
    public function removeDoctor(\AppBundle\Entity\User $doctor)
    {
        $this->doctors->removeElement($doctor);
    }

    /**
     * Get doctors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDoctors()
    {
        return $this->doctors;
    }

    /**
     * Add patient
     *
     * @param \AppBundle\Entity\User $patient
     *
     * @return User
     */
    public function addPatient(\AppBundle\Entity\User $patient)
    {
        $this->patients[] = $patient;

        return $this;
    }

    /**
     * Remove patient
     *
     * @param \AppBundle\Entity\User $patient
     */
    public function removePatient(\AppBundle\Entity\User $patient)
    {
        $this->patients->removeElement($patient);
    }

    /**
     * Get patients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPatients()
    {
        return $this->patients;
    }

    /**
     * @return mixed
     */
    public function getIsPatient()
    {
        return $this->isPatient = $this->doctors->count() > 0;
    }

    /**
     * Add imagingExamination.
     *
     * @param \AppBundle\Entity\ImagingExamination $imagingExamination
     *
     * @return User
     */
    public function addImagingExamination(\AppBundle\Entity\ImagingExamination $imagingExamination)
    {
        $this->imagingExaminations[] = $imagingExamination;

        return $this;
    }

    /**
     * Remove imagingExamination.
     *
     * @param \AppBundle\Entity\ImagingExamination $imagingExamination
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeImagingExamination(\AppBundle\Entity\ImagingExamination $imagingExamination)
    {
        return $this->imagingExaminations->removeElement($imagingExamination);
    }

    /**
     * Get imagingExaminations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImagingExaminations()
    {
        return $this->imagingExaminations;
    }

    /**
     * Add informationForPatient.
     *
     * @param \AppBundle\Entity\InformationForPatient $informationForPatient
     *
     * @return User
     */
    public function addInformationForPatient(\AppBundle\Entity\InformationForPatient $informationForPatient)
    {
        $this->informationForPatient[] = $informationForPatient;

        return $this;
    }

    /**
     * Remove informationForPatient.
     *
     * @param \AppBundle\Entity\InformationForPatient $informationForPatient
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeInformationForPatient(\AppBundle\Entity\InformationForPatient $informationForPatient)
    {
        return $this->informationForPatient->removeElement($informationForPatient);
    }

    /**
     * Get informationForPatient.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInformationForPatient()
    {
        return $this->informationForPatient;
    }

    /**
     * Add appointment.
     *
     * @param \AppBundle\Entity\Appointment $appointment
     *
     * @return User
     */
    public function addAppointment(\AppBundle\Entity\Appointment $appointment)
    {
        $this->appointments[] = $appointment;

        return $this;
    }

    /**
     * Remove appointment.
     *
     * @param \AppBundle\Entity\Appointment $appointment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAppointment(\AppBundle\Entity\Appointment $appointment)
    {
        return $this->appointments->removeElement($appointment);
    }

    /**
     * Get appointments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * Add visit.
     *
     * @param \AppBundle\Entity\Appointment $visit
     *
     * @return User
     */
    public function addVisit(\AppBundle\Entity\Appointment $visit)
    {
        $this->visits[] = $visit;

        return $this;
    }

    /**
     * Remove visit.
     *
     * @param \AppBundle\Entity\Appointment $visit
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVisit(\AppBundle\Entity\Appointment $visit)
    {
        return $this->visits->removeElement($visit);
    }

    /**
     * Get visits.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * Add notification.
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return User
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification.
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        return $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Add dietRecommendation.
     *
     * @param \AppBundle\Entity\DietRecommendation $dietRecommendation
     *
     * @return User
     */
    public function addDietRecommendation(\AppBundle\Entity\DietRecommendation $dietRecommendation)
    {
        $this->dietRecommendations[] = $dietRecommendation;

        return $this;
    }

    /**
     * Remove dietRecommendation.
     *
     * @param \AppBundle\Entity\DietRecommendation $dietRecommendation
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDietRecommendation(\AppBundle\Entity\DietRecommendation $dietRecommendation)
    {
        return $this->dietRecommendations->removeElement($dietRecommendation);
    }

    /**
     * Get dietRecommendations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDietRecommendations()
    {
        return $this->dietRecommendations;
    }

    /**
     * Add meal.
     *
     * @param \AppBundle\Entity\Meal $meal
     *
     * @return User
     */
    public function addMeal(\AppBundle\Entity\Meal $meal)
    {
        $this->meals[] = $meal;

        return $this;
    }

    /**
     * Remove meal.
     *
     * @param \AppBundle\Entity\Meal $meal
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMeal(\AppBundle\Entity\Meal $meal)
    {
        return $this->meals->removeElement($meal);
    }

    /**
     * Get meals.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Add physicalEffort.
     *
     * @param \AppBundle\Entity\PhysicalEffort $physicalEffort
     *
     * @return User
     */
    public function addPhysicalEffort(\AppBundle\Entity\PhysicalEffort $physicalEffort)
    {
        $this->physicalEfforts[] = $physicalEffort;

        return $this;
    }

    /**
     * Remove physicalEffort.
     *
     * @param \AppBundle\Entity\PhysicalEffort $physicalEffort
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePhysicalEffort(\AppBundle\Entity\PhysicalEffort $physicalEffort)
    {
        return $this->physicalEfforts->removeElement($physicalEffort);
    }

    /**
     * Get physicalEfforts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhysicalEfforts()
    {
        return $this->physicalEfforts;
    }

    /**
     * Add drug.
     *
     * @param \AppBundle\Entity\Drug $drug
     *
     * @return User
     */
    public function addDrug(\AppBundle\Entity\Drug $drug)
    {
        $this->drugs[] = $drug;

        return $this;
    }

    /**
     * Remove drug.
     *
     * @param \AppBundle\Entity\Drug $drug
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDrug(\AppBundle\Entity\Drug $drug)
    {
        return $this->drugs->removeElement($drug);
    }

    /**
     * Get drugs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDrugs()
    {
        return $this->drugs;
    }

    /**
     * Add weekSummary.
     *
     * @param \AppBundle\Entity\Summary $weekSummary
     *
     * @return User
     */
    public function addWeekSummary(\AppBundle\Entity\Summary $weekSummary)
    {
        $this->weekSummaries[] = $weekSummary;

        return $this;
    }

    /**
     * Remove weekSummary.
     *
     * @param \AppBundle\Entity\Summary $weekSummary
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeWeekSummary(\AppBundle\Entity\Summary $weekSummary)
    {
        return $this->weekSummaries->removeElement($weekSummary);
    }

    /**
     * Get weekSummaries.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWeekSummaries()
    {
        return $this->weekSummaries;
    }

    /**
     * Add chat.
     *
     * @param \AppBundle\Entity\Chat $chat
     *
     * @return User
     */
    public function addChat(\AppBundle\Entity\Chat $chat)
    {
        $this->chats[] = $chat;

        return $this;
    }

    /**
     * Remove chat.
     *
     * @param \AppBundle\Entity\Chat $chat
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChat(\AppBundle\Entity\Chat $chat)
    {
        return $this->chats->removeElement($chat);
    }

    /**
     * Get chats.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChats()
    {
        return $this->chats;
    }
}
