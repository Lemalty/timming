<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Group;
use App\Entity\Module;
use App\Entity\Task;
use App\Entity\Teacher;
use DateTime;

class AppFixtures extends Fixture
{
    const N_GROUPS = 14;
    const N_MODULES = 10;
    const N_TASKS = 10;
    const N_TEACHERS = 10;

    const GROUPS_NAMES = [
                            'TP1',
                            'TP2',
                            'TP3',
                            'TP4',
                            'TDA',
                            'TDB',
                            'CM',
                            'TP1',
                            'TP2',
                            'TP3',
                            'TP4',
                            'TDA',
                            'TDB',
                            'CM'
                        ];

    const MODULES_NAMES = [
        'M11:Anglais',
        'M12:Expression et communication',
        'M13:Algorithmique',
        'M14:Développement web',
        'M15:Intégration web',
        'M21:Anglais',
        'M22:Expression et communication',
        'M23:Algorithmique',
        'M24:Développement web',
        'M25:Intégration web'
    ];

    const TEACHERS_NAMES = [
        'François LOUET',
        'Bernadette CHAULET',
        'Smaïl BACHIR',
        'Didier GALONNIER',
        'José MOURRE',
        'Stéphanie DELAYRE',
        'Taoufik EL KHABIR',
        'Lionel YEPES',
        'Jean-Luc HENIN',
        'Louis NAPOLEON-BONAPARTE'
    ];

    const TASKS_DESCRIPTIONS = [
        'Débat avec Eric Zemmour',
        'Portfolio',
        'Rédaction d\'une newsletter',
        'English test',
        'TP Grid et Flexbox',
        'TP WordPress',
        'TP Symfony',
        'Soutenance PTUT',
        'Partiel de TIC',
        'Devoir de mémoire'
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadTeacher($manager);
        $this->loadModule($manager);
        $this->loadGroup($manager);
        $this->loadTask($manager);
    }

    public function loadGroup(ObjectManager $manager)
    {

        for ($i = 0; $i < self::N_GROUPS; $i++) {
            $group = new Group();
            $group->setName(self::GROUPS_NAMES[$i]);

            if (substr(self::GROUPS_NAMES[$i], 0, 2) == 'TP') {
                $group->setType('TP');
            }
            elseif (substr(self::GROUPS_NAMES[$i], 0, 2) == 'TD') {
                $group->setType('TD');
            }
            elseif (substr(self::GROUPS_NAMES[$i], 0, 2) == 'CM') {
                $group->setType('CM');
            }

            if ( $i <= (self::N_GROUPS / 2) ) {
                $group->setSemester('2');
                $group->setCampain('2020-2022');
            }
            else {
                $group->setSemester('4');
                $group->setCampain('2019-2021');
            }

            /*
            for($y = 1, $max = rand(0, 3); $y<= $max; $y++){
                $group->addTask($this->getReference('task-'.rand(0, (self::N_TASKS-1))));
            }*/

            $this->addReference("group-$i", $group);
            $manager->persist($group);
        }
        $manager->flush();
    }


    public function loadModule(ObjectManager $manager) {
        for ($i = 0; $i < self::N_MODULES; $i++) {
            $module = new Module();
            $module->setName(self::MODULES_NAMES[$i]);

            if (substr(self::MODULES_NAMES[$i], 1, 2) == '1' ) {
                $module->setYear('1');
                $module->setCampain('2020-2022');
            } else {
                $module->setYear('2');
                $module->setCampain('2019-2021');
            }

            //teacher
            for($y = 1, $max = rand(1, 2); $y<= $max; $y++){
                $module->addTeacher($this->getReference('teacher-'.rand(0, (self::N_TEACHERS-1))));
            }

            $this->addReference("module-$i", $module);
            $manager->persist($module);
        }
        $manager->flush();
    }


    public function loadTask(ObjectManager $manager) {
        for ($i = 0; $i < self::N_TASKS; $i++) {
            $task = new Task();
            $task->setDescription(self::TASKS_DESCRIPTIONS[$i]);
            $task->setDeadline(new DateTime());
            $task->setVisible(true);

            $task->setTeacher($this->getReference('teacher-'.rand(0, (self::N_TEACHERS-1))));
            $task->setModule($this->getReference('module-'.rand(0, (self::N_MODULES-1))));
            $task->setGroupOfTask($this->getReference('group-'.rand(0, (self::N_GROUPS-1))));


            $this->addReference("task-$i", $task);
            $manager->persist($task);
        }
        $manager->flush();
    }


    public function loadTeacher(ObjectManager $manager) {
        for ($i = 0; $i < self::N_TEACHERS; $i++) {
            $teacher = new Teacher();
            $teacher->setName(self::TEACHERS_NAMES[$i]);

            $this->addReference("teacher-$i", $teacher);
            $manager->persist($teacher);
        }
        $manager->flush();
    }

}