<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\AutoIncrementResetter;
use AppBundle\Entity\IdeasWorkshop\AuthorCategoryEnum;
use AppBundle\Entity\IdeasWorkshop\Idea;
use AppBundle\Entity\IdeasWorkshop\IdeaStatusEnum;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class LoadIdeaData extends AbstractFixture implements DependentFixtureInterface
{
    public const IDEA_01_UUID = 'e4ac3efc-b539-40ac-9417-b60df432bdc5';
    public const IDEA_02_UUID = '3b1ea810-115f-4b2c-944d-34a55d7b7e4d';
    public const IDEA_03_UUID = 'aa093ce6-8b20-4d86-bfbc-91a73fe47285';
    public const IDEA_04_UUID = 'c14937d6-fd42-465c-8419-ced37f3e6194';

    public function load(ObjectManager $manager)
    {
        AutoIncrementResetter::resetAutoIncrement($manager, 'ideas_workshop_idea');

        $need = $this->getReference('need-legal');
        $category = $this->getReference('category-european');
        $theme = $this->getReference('theme-army-defense');
        $committee = $this->getReference('committee-1');
        $adherent3 = $this->getReference('adherent-3');
        $adherent6 = $this->getReference('adherent-6');

        $ideaMakePeace = new Idea(
            'Faire la paix',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec maximus convallis dolor, id ultricies lorem lobortis et. Vivamus bibendum leo et ullamcorper dapibus.',
            $category,
            $theme,
            AuthorCategoryEnum::COMMITTEE,
            $committee,
            new \DateTime('2018-12-01 10:00:00'),
            IdeaStatusEnum::PENDING,
            $adherent3,
            Uuid::fromString(self::IDEA_01_UUID)
        );
        $ideaMakePeace->addNeed($need);
        $this->addReference('idea-peace', $ideaMakePeace);

        $ideaHelpEcology = new Idea(
            'Favoriser l\'écologie',
            'Mauris posuere eros eget nunc dapibus ornare. Vestibulum dolor eros, facilisis in venenatis eu, tristique a sapien.',
            $category,
            $theme,
            AuthorCategoryEnum::COMMITTEE,
            $committee,
            new \DateTime('2018-12-02 10:00:00'),
            IdeaStatusEnum::DRAFT,
            $adherent3,
            Uuid::fromString(self::IDEA_02_UUID)
        );
        $this->addReference('idea-help-ecology', $ideaHelpEcology);

        $ideaHelpPeople = new Idea(
            'Aider les gens',
            'Nam laoreet eros diam, vitae hendrerit libero interdum nec. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            $category,
            $theme,
            AuthorCategoryEnum::QG,
            null,
            new \DateTime('2018-12-03 10:00:00'),
            IdeaStatusEnum::DRAFT,
            $adherent6,
            Uuid::fromString(self::IDEA_03_UUID)
        );
        $this->addReference('idea-help-people', $ideaHelpPeople);

        $ideaReduceWaste = new Idea(
            'Réduire le gaspillage',
            'In nec risus vitae lectus luctus fringilla. Suspendisse vitae enim interdum, maximus justo a, elementum lectus. Mauris et augue et magna imperdiet eleifend a nec tortor.',
            $category,
            $theme,
            AuthorCategoryEnum::ADHERENT,
            null,
            new \DateTime('2018-12-04 10:00:00'),
            IdeaStatusEnum::FINALIZED,
            $adherent3,
            Uuid::fromString(self::IDEA_04_UUID)
        );
        $this->addReference('idea-reduce-waste', $ideaReduceWaste);

        $manager->persist($ideaMakePeace);
        $manager->persist($ideaHelpEcology);
        $manager->persist($ideaHelpPeople);
        $manager->persist($ideaReduceWaste);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadAdherentData::class,
            LoadIdeaNeedData::class,
            LoadIdeaCategoryData::class,
            LoadIdeaThemeData::class,
            LoadIdeaGuidelineData::class,
        ];
    }
}
