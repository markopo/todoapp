<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TaskRepository
     */
    private $taskRepository;


    public function __construct(EntityManagerInterface $entityManager, TaskRepository $taskRepository)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }


    /**
     * @Route("/", name="todo_list")
     */
    public function index()
    {
        $tasks = $this->taskRepository->findAll();

        return $this->render('todolist/index.html.twig', [ 'tasks' => $tasks ]);
    }

    /**
     * @Route("/create", name="create_todo_list", methods={"POST"})
     */
    public function create(Request $request) {
            $title = trim($request->request->get('title'));

            if(empty($title)){
                return $this->redirectToRoute('todo_list');
            }

           // dd('create.. ' . $title);
            $task = new Task();
            $task->setTitle($title);
            $task->setStatus(false);
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return $this->redirectToRoute('todo_list');
    }


    /**
     * @Route("/switch-status/{id}", name="switch_status")
     */
    public function switchStatus(int $id) {


        dd('switch' . $id);
    }

    /**
     * @Route("/delete-task/{id}", name="delete_task")
     */
    public function deleteTask(int $id) {

        dd('delete '. $id);
    }
}
