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

        $createContact->setEmail($decodedParams['email']);
        $createContact->setAttributes($this->toObject(['FNAME' => $decodedParams['firstName'] ?? null, 'LNAME' => $decodedParams['lastname'] ?? null]));
        $createContact->setListIds([4]);
        $createContact->setEmailBlacklisted(false);
        $createContact->setSmsBlacklisted(false);
        $createContact->setUpdateEnabled(false);

        try {
            $result = $apiInstance->createContact($createContact);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
        }

        return $this->json(['success' => true]);
    }

    private function toObject(array $array)
    {
        $object = new \stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->toObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }
}
