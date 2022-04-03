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
class ThreadMy extends Controller
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
     *     name="threads_my",
     *     path="/api/threads/my",
     *     methods={"GET"},
     *     defaults={"_api_resource_class"=Thread::class, "_api_collection_operation_name"="my", "_api_receive"=false}
     * )
     *
     * @return \FOS\MessageBundle\Model\ThreadInterface[]
     */
    public function __invoke()
    {
        $threads = array_merge($this->provider->getInboxThreads(), $this->provider->getSentThreads());
        array_walk($threads, function (Thread $thread) {
            $thread->isReadByParticipant($this->getUser());
        });
        usort($threads, function (Thread $a, Thread $b) { return $a->getHasBeenRead() > $b->getHasBeenRead(); });

        return $threads;
    }
}