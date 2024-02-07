<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Service\LeaveRequestManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\LeaveRequestManagerRepository;

class LeaveRequestManagerController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LeaveRequestManagerService $leaveRequestManagerService,
        private LeaveRequestManagerRepository $leaveRequestManagerRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->leaveRequestManagerService = $leaveRequestManagerService;
        $this->leaveRequestManagerRepository = $leaveRequestManagerRepository;
    }

    #[Route('/api/leaverequest/list', name: 'api_leave_request_list')]
    public function getLeaveRequestList(): Response
    {
        $leaveRequestList = $this->leaveRequestManagerRepository->findAll();
        $leaveRequestsToArray = [];
        foreach ($leaveRequestList as $leaveRequest) {
            array_unshift($leaveRequestsToArray, $leaveRequest->toArray());
        }

        return new JsonResponse(['list' => $leaveRequestsToArray]);
    }

    #[Route('/api/leaverequest/add', name: 'api_leave_request_add')]
    public function postLeaveRequest(Request $request): Response
    {
        $errors = [];
        $data = json_decode($request->getContent(), true);
        if (!isset($data['validationStatus'])) {
            $errors = $this->leaveRequestManagerService->leaveRequestValidator($data);
        }

        if (empty($errors)) {
            $leaveRequestAdded =  $this->leaveRequestManagerService->setLeaveRequest($data);
            return new JsonResponse(['added' => $leaveRequestAdded, 'errors' => false]);
        } else {
            return new JsonResponse(['added' => false, 'errors' => $errors]);
        }
    }
}
