<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\IdeasWorkshop\AuthorCategoryEnum;
use AppBundle\Entity\IdeasWorkshop\Idea;
use AppBundle\Repository\IdeaRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IdeasWorkshopNormalizer implements NormalizerInterface, DenormalizerInterface
{
    private $normalizer;
    private $tokenStorage;
    private $ideaRepository;

    public function __construct(
        NormalizerInterface $normalizer,
        IdeaRepository $ideaRepository,
        TokenStorageInterface $tokenStorage
    ) {
        if (!$normalizer instanceof NormalizerInterface || !$normalizer instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException(
                'The normalizer must implement the NormalizerInterface and DenormalizerInterface interfaces.'
            );
        }

        $this->normalizer = $normalizer;
        $this->tokenStorage = $tokenStorage;
        $this->ideaRepository = $ideaRepository;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if (\in_array('idea_list_read', $context['groups'])) {
            $data['contributors_count'] = $this->ideaRepository->countIdeaContributors($object);
            $data['comments_count'] = $this->ideaRepository->countThreadComments($object);

            $total = $data['votes_count'];
            $votes = $this->ideaRepository->countVotesByType($object);
            $data['votes_count'] = $votes;
            $data['votes_count']['total'] = $total;

            if (\is_object($loggedUser = $this->tokenStorage->getToken()->getUser())) {
                $data['votes_count']['my_votes'] = $this->ideaRepository->getAdherentVotesForIdea($object, $loggedUser);
            }
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Idea;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        /** @var Idea $data */
        $data = $this->normalizer->denormalize($data, $class, $format, $context);

        if ($data->getCommittee()) {
            $data->setAuthorCategory(AuthorCategoryEnum::COMMITTEE);
        } elseif ($this->tokenStorage->getToken()->getUser()->isQGForIdeas()) {
            $data->setAuthorCategory(AuthorCategoryEnum::QG);
        } else {
            $data->setAuthorCategory(AuthorCategoryEnum::ADHERENT);
        }

        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $data instanceof Idea;
    }
}
