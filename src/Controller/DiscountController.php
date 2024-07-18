<?php

namespace App\Controller;

use App\Form\DiscountForm;
use App\Service\DiscountService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{

    #[Route('/calculate-discount', name: 'calculate_discount', methods: ['POST'])]
    public function calculateDiscount(Request $request, DiscountService $discountService): Response
    {
        $form = $this->createForm(DiscountForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $costWithDiscount = $discountService->calculateCostWithDiscount($data);
            } catch (Exception) {
                return $this->json(['error' => 'Error while calculating discount'],
                    Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return $this->json(['cost_with_discount' => $costWithDiscount]);
        }

        return $this->json(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
    }
}