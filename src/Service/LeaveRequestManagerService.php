<?php

namespace App\Service;

use App\Repository\LeaveRequestManagerRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\LeaveRequestManager;
use App\Constant\ValidationStatusRequest;
use DateTime;

class LeaveRequestManagerService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LeaveRequestManagerRepository $leaveRequestManagerRepository,

    ) {
        $this->entityManager = $entityManager;
        $this->leaveRequestManagerRepository = $leaveRequestManagerRepository;
    }

    public function setLeaveRequest($data): bool
    {
        if (isset($data['id'])) {
            $currentLeaveRequest = $this->leaveRequestManagerRepository->findOneBy(['id' => $data['id']]);
        } else {
            $currentLeaveRequest = false;
        }

        if (!$currentLeaveRequest) {

            /* $data for Employee {
                periodFrom, 
                periodTo,
                employeeName
            } */
            $periodFrom = new DateTime($data['periodFrom']);
            $periodFrom->format('d-m-Y');
            $periodTo = new DateTime($data['periodTo']);
            $periodTo->format('d-m-Y');

            $leaveRequest = new LeaveRequestManager();
            $currentLeaveRequest = $leaveRequest;
            $currentLeaveRequest->setEmployeeName($data['employeeName']);
            $currentLeaveRequest->setValidationStatus(ValidationStatusRequest::PENDING);
            $currentLeaveRequest->setPeriodFrom($periodFrom);
            $currentLeaveRequest->setPeriodTo($periodTo);
        } else {
            /* $data for Manager {
                ?comment, 
                validationStatus,
            } */
            if (isset($data['comment'])) {
                $currentLeaveRequest->setComment($data['comment']);
            }
            $currentLeaveRequest->setValidationStatus($data['validationStatus']);
        }

        $this->entityManager->persist($currentLeaveRequest);
        $this->entityManager->flush();

        return $currentLeaveRequest->toArray() ? true : false;
    }


    public function leaveRequestValidator($formData)
    {
        $errors = [];

        if (strlen($formData['employeeName']) < 5) {
            $errors['employeeName'] = "Veuillez saisir au moins 8 caractères";
        }
        if (!isset($formData['periodTo']) | $formData['periodTo'] == null) {
            $errors['periodTo'] = "Veuillez saisir au moins 8 caractères";
        }
        $startDate = new DateTime($formData['periodFrom']);
        $endDate = clone $startDate;
        $endDate->modify('+5 weeks');

        $userSelectedEndDate = new DateTime($formData['periodTo']);

        $maxEndDate = clone $startDate;
        $maxEndDate->modify('+5 weeks');

        if ($userSelectedEndDate >= $maxEndDate) {
            $errors['periodTooLong'] = "Veuillez selectionner 5 semaines maximum";
        }

        foreach ($formData as $key => $value) {
            if (empty($value) | !isset($value)) {
                $errors[$key] = "Ce champ est vide";
            }
        }
        return $errors;
    }
    
}
