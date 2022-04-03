<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Thread;
use FOS\MessageBundle\Provider\ProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageSend
 *
 * @package AppBundle\Controller
 */
class ThreadDashboard extends Controller
{
    /**
     * @var \FOS\MessageBundle\Provider\ProviderInterface
     */
    private $provider;

    /**
     * MessageSend constructor.
     *
     * @param \FOS\MessageBundle\Provider\ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @Route(
     *     name="threads_my_dashboard",
     *     path="/api/threads/my/dashboard",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=Thread::class, "_api_collection_operation_name"="my_dashboard", "_api_receive"=false}
     * )
     * @return \FOS\MessageBundle\Model\ThreadInterface[]
     */
    public function __invoke()
    {
        $new = [];

        foreach ($this->provider->getInboxThreads() as $thread) {
            if (!$thread->isReadByParticipant($this->getUser())) {
                array_push($new, $thread);
            }
        }

        return $new;
    }
}