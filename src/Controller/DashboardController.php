<?php

namespace App\Controller;

use App\Repository\TasksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TasksRepository $tasksRepository)
    {
        $tasksByStatus = $tasksRepository->countTasksByStatus();

        $tasksOverdue = $tasksRepository->findOverdueTasks();

        $userStats = $tasksRepository->findStatsByUser();

        return $this->render('dashboard/index.html.twig', [
            'tasksByStatus' => $tasksByStatus,
            'tasksOverdue' => $tasksOverdue,
            'userStats' => $userStats,
        ]);
    }
}


