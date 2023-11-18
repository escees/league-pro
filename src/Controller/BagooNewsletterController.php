<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LeagueRepository;
use Brevo\Client\Api\ContactsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\CreateContact;
use Exception;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BagooNewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter", name="app.bagoo.newsletter")
     */
    public function index(
        Request $request,
        string $brevoApiKey
    ): Response {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $brevoApiKey);
        $apiInstance = new ContactsApi(
            new Client(),
            $config
        );
        $decodedParams = json_decode($request->getContent());
        $createContact = new CreateContact();

        $createContact['email'] = $decodedParams['email'];
        $createContact['attributes'] = ['FNAME'=> $decodedParams['firstName'], 'LNAME'=>$decodedParams['lastname']];
        $createContact['listIds'] = [4];
        $createContact['emailBlacklisted'] = false;
        $createContact['smsBlacklisted'] = false;
        $createContact['updateEnabled'] = false;

        try {
            $result = $apiInstance->createContact($createContact);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
        }

        return $this->json(['success' => true]);
    }
}
